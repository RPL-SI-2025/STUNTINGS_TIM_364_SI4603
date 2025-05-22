<?php

namespace App\Http\Controllers;

use App\Models\Detection;
use Illuminate\Http\Request;

class DetectionController extends Controller
{
    // jadi ini buat si admin doang
    public function index(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $query = Detection::query();

        if ($request->has('nama') && !empty($request->nama)) {
            $query->where('nama', 'like', '%' . $request->nama . '%');
        }

        $semua = $query->latest()->get();

        return view('admin.detections.index', [
            'semua' => $semua,
            'filterNama' => $request->nama ?? '',
        ]);
    }

    // yang ini buat ortu doang
    public function create()
    {
        if (auth()->user()->role !== 'orangtua') {
            abort(403, 'Unauthorized');
        }

        $semua = Detection::where('user_id', auth()->id())->latest()->get();
        return view('orangtua.detections.deteksi', compact('semua'));
    }

    // ini cuma ortu doang yang bisa nyimpen data
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

        $hasil = Detection::create([
            'user_id' => auth()->id(),
            'nama' => auth()->user()->nama_anak,
            'umur' => $umur,
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'berat_badan' => $validated['berat_badan'],
            'tinggi_badan' => $validated['tinggi_badan'],
            'z_score' => round($z_score, 2),
            'status' => $status,
        ]);

        $semua = Detection::where('user_id', auth()->id())->latest()->get();

        return view('orangtua.detections.deteksi', [
            'success' => 'Deteksi berhasil disimpan!',
            'hasil' => $hasil,
            'semua' => $semua,
        ]);
    }

    public function destroy($id)
    {
        $detection = Detection::findOrFail($id);

        // Cek apakah data ini milik user yang sedang login
        if ($detection->user_id !== auth()->id()) {
            abort(403, 'Akses ditolak');
        }

        $detection->delete();

        return redirect()->back()->with('success', 'Data deteksi berhasil dihapus.');
    }
}
