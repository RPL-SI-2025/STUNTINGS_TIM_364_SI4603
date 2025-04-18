<?php

namespace App\Http\Controllers;

use App\Models\Detection;
use Illuminate\Http\Request;

class AdminDetectionController extends Controller
{
    public function index()
    {
        $detections = Detection::latest()->get();
        return view('admin.detections.index', compact('detections'));
    }
}

