<?php

// App\Http\Controllers\DetectionController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DetectionController extends Controller
{
    // Method buat nampilin halaman deteksi untuk si admin
    public function index()
    {
        // buat ngeCek apakah user yang login adalah admin
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        // Ambil data yang dibutuhkan untuk halaman admin, misalnya deteksi stunting
        // Data yang diambil bisa disesuaikan dengan kebutuhan
        return view('admin.detections.index');
    }

    // Method lainnya seperti create, store, dsb. sudah ada sebelumnya
}


