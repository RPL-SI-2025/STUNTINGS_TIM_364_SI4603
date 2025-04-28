<?php

namespace App\Http\Controllers;

use App\Models\Detection;
use Illuminate\Http\Request;

class DetectionController extends Controller
{
    // Menampilkan form input dan tabel riwayat
    public function create()
    {
        $semua = Detection::latest()->get();
        return view('deteksi', compact('semua'));
    }

    // Menyimpan hasil deteksi ke database dan menampilkan hasil langsung
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string',
            'umur' => 'required|integer',
            'jenis_kelamin' => 'required|in:L,P',
            'berat_badan' => 'required|numeric',
            'tinggi_badan' => 'required|numeric',
        ]);

        $filePath = $validated['jenis_kelamin'] === 'L'
            ? storage_path('app/zscores_boys.json')
            : storage_path('app/zscores_girls.json');

        if (!file_exists($filePath)) {
            return back()->with('error', 'File WHO tidak ditemukan di: ' . $filePath);
        }

        $json = file_get_contents($filePath);
        $data = json_decode($json, true);

        if (!$data || !is_array($data)) {
            return back()->with('error', 'Gagal membaca file WHO.');
        }

        $umur = (int) $validated['umur'];

        $who_data = collect($data)->first(function ($item) use ($umur) {
            return isset($item['Month']) && (int) $item['Month'] === $umur;
        });

        if (!$who_data) {
            return back()->with('error', 'Data WHO tidak tersedia untuk umur ini.');
        }

        $median = $who_data['M'] ?? 0;
        $sd = $who_data['SD'] ?? 1;

        $z_score = ($validated['tinggi_badan'] - $median) / $sd;

        if ($z_score < -2) {
            $status = 'Stunting';
        } elseif ($z_score >= -2 && $z_score <= 2) {
            $status = 'Normal';
        } else {
            $status = 'Tinggi';
        }

        $hasil = Detection::create([
            'nama' => $validated['nama'],
            'umur' => $umur,
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'berat_badan' => $validated['berat_badan'],
            'tinggi_badan' => $validated['tinggi_badan'],
            'z_score' => round($z_score, 2),
            'status' => $status,
        ]);

        $semua = Detection::latest()->get();

        return view('deteksi', [
            'success' => 'Deteksi berhasil disimpan!',
            'hasil' => $hasil,
            'semua' => $semua,
        ]);
    }
}
