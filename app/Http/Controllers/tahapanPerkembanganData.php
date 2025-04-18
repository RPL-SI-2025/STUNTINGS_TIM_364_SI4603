<?php

namespace App\Http\Controllers;

use App\Models\tahapanPerkembanganData;
use App\Models\tahapanPerkembangan;
use Illuminate\Http\Request;

class tahapanPerkembanganDataController extends Controller
{
    public function index()
    {
        $tahapanPerkembanganData = tahapanPerkembanganData::all();
        return view('tahapanPerkembanganData.index', compact('tahapanPerkembanganData'));
    }
    
    
        public function create()
        {
            $tahapanPerkembangan = tahapanPerkembangan::all();
            return view('tahapanPerkembanganData.create', compact('tahapanPerkembangan'));
        }
    
        public function store(Request $request)
        {
            $request->validate([
                'status' => 'required',
                'tahapan_perkembangan_id' => 'required',
            ]);
    
            tahapanPerkembanganData::create($request->all());
    
            return redirect()->route('tahapanPerkembanganData.index')->with('success', 'Data berhasil ditambahkan');
        }

        public function edit($id)
        {
            $tahapanPerkembanganData = tahapanPerkembanganData::findOrFail($id);
            $tahapanPerkembangan = tahapanPerkembangan::all();
            return view('tahapanPerkembanganData.edit', compact('tahapanPerkembanganData', 'tahapanPerkembangan'));
        }
        public function update(Request $request, $id)
        {
            $request->validate([
                'status' => 'required',
                'tahapan_perkembangan_id' => 'required',
            ]);
    
            $tahapanPerkembanganData = tahapanPerkembanganData::findOrFail($id);
            $tahapanPerkembanganData->update($request->all());
    
            return redirect()->route('tahapanPerkembanganData.index')->with('success', 'Data berhasil diperbarui');
        }
}