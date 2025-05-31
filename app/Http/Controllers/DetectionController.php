<?php

namespace App\Http\Controllers;

use App\Models\Detection;
use Illuminate\Http\Request;

class DetectionController extends Controller
{
    // Untuk admin: list semua data dengan fitur pencarian
    public function index(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $query = Detection::with('user')->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('nama_anak', 'like', '%' . $search . '%');
            });
        }

        $semua = $query->get();

        return view('admin.detections.index', compact('semua'));
    }


    // Untuk orangtua: tampilkan form deteksi + riwayat
    public function create()
    {
        if (auth()->user()->role !== 'orangtua') {
            abort(403, 'Unauthorized');
        }

        $semua = Detection::where('user_id', auth()->id())->latest()->get();
        return view('orangtua.detections.deteksi', compact('semua'));
    }

    // Orangtua bisa simpan data deteksi
    public function store(Request $request)
    {
        if (auth()->user()->role !== 'orangtua') {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'umur' => 'required|integer',
            'jenis_kelamin' => 'required|in:L,P',
            'berat_badan' => 'required|numeric',
            'tinggi_badan' => 'required|numeric',
        ]);

        $filePath = $validated['jenis_kelamin'] === 'L'
            ? storage_path('app/zscores_boys.json')
            : storage_path('app/zscores_girls.json');

        if (!file_exists($filePath)) {
            return back()->with('error', 'File WHO tidak ditemukan.');
        }

        $data = json_decode(file_get_contents($filePath), true);
        if (!$data || !is_array($data)) {
            return back()->with('error', 'Gagal membaca file WHO.');
        }

        $umur = (int) $validated['umur'];
        $who_data = collect($data)->first(fn($item) => (int) $item['Month'] === $umur);

        if (!$who_data) {
            return back()->with('error', 'Data WHO tidak tersedia untuk umur ini.');
        }

        $median = $who_data['M'] ?? 0;
        $sd = $who_data['SD'] ?? 1;
        $z_score = ($validated['tinggi_badan'] - $median) / $sd;

        $status = match (true) {
            $z_score < -2 => 'Stunting',
            $z_score >= -2 && $z_score <= 2 => 'Normal',
            default => 'Tinggi'
        };

        Detection::create([
            'user_id' => auth()->id(),
            'nama' => auth()->user()->nama_anak,
            'umur' => $umur,
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'berat_badan' => $validated['berat_badan'],
            'tinggi_badan' => $validated['tinggi_badan'],
            'z_score' => round($z_score, 2),
            'status' => $status,
        ]);

        // Redirect ke halaman form agar lebih baik UX nya
        return redirect()->route('orangtua.detections.create')->with('success', 'Deteksi berhasil disimpan!');
    }

    // Hapus data deteksi, hanya milik user yang bersangkutan
    public function destroy($id)
    {
        $detection = Detection::findOrFail($id);

        if (auth()->user()->id !== $detection->user_id) {
            abort(403);
        }

        $detection->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus.');
    }
}
