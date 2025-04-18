<?php

namespace App\Http\Controllers;

use App\Models\Detection;
use Illuminate\Http\Request;

class DetectionController extends Controller
{
    // Tampilkan form + riwayat deteksi milik user yang login
    public function create()
    {
        if (auth()->user()->role === 'admin') {
            $semua = Detection::latest()->get(); // Admin bisa lihat semua
        } else {
            $semua = Detection::where('user_id', auth()->id())->latest()->get(); // User biasa hanya datanya sendiri
        }

        return view('deteksi', compact('semua'));
    }

    // Simpan hasil deteksi
    public function store(Request $request)
    {
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
    
        // Tentukan status berdasarkan Z-Score
        $status = match (true) {
            $z_score < -2 => 'Stunting',
            $z_score >= -2 && $z_score <= 2 => 'Normal',
            default => 'Tinggi'
        };
    
        // Simpan data deteksi dengan nama anak dari user yang login
        $hasil = Detection::create([
            'user_id' => auth()->id(),
            'nama' => auth()->user()->nama_anak, // Ambil nama anak dari user yang login
            'umur' => $umur,
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'berat_badan' => $validated['berat_badan'],
            'tinggi_badan' => $validated['tinggi_badan'],
            'z_score' => round($z_score, 2),
            'status' => $status,
        ]);
    
        // Ambil semua data deteksi milik user yang login
        $semua = Detection::where('user_id', auth()->id())->latest()->get();
    
        return view('deteksi', [
            'success' => 'Deteksi berhasil disimpan!',
            'hasil' => $hasil,
            'semua' => $semua,
        ]);
    }
}    