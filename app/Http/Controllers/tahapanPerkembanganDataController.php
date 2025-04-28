<?php

namespace App\Http\Controllers;

use App\Models\TahapanPerkembangan;
use App\Models\TahapanPerkembanganData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TahapanPerkembanganDataController extends Controller
{
    public function index()
    {
        $tahapanPerkembanganData = TahapanPerkembanganData::where('user_id', Auth::id())->get();

        return view('orangtua.tahapan_perkembangan.index', compact('tahapanPerkembanganData'));
    }

    public function create()
    {
        $tahapanPerkembangan = TahapanPerkembangan::all();
        return view('orangtua.tahapan_perkembangan.create', compact('tahapanPerkembangan'));
    }

    public function edit($id)
    {
        $tahapanPerkembanganData = TahapanPerkembanganData::findOrFail($id);
        $tahapanPerkembangan = TahapanPerkembangan::all();


        return view('orangtua.tahapan_perkembangan.edit', compact('tahapanPerkembanganData', 'tahapanPerkembangan'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'tahapan_perkembangan_id' => 'required|exists:tahapan_perkembangan,id',
            'tanggal_pencapaian' => 'required|date|before_or_equal:today',
            'status' => 'required|in:tercapai,belum_tercapai',
            'catatan' => 'nullable|string',
        ]);


        TahapanPerkembanganData::create([
            'user_id' => Auth::id(),
            'tahapan_perkembangan_id' => $request->tahapan_perkembangan_id,
            'tanggal_pencapaian' => $request->tanggal_pencapaian,
            'status' => $request->status,
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('orangtua.tahapan_perkembangan.index')->with('success', 'Pencapaian tahapan perkembangan berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'tahapan_perkembangan_id' => 'required|exists:tahapan_perkembangan,id',
            'tanggal_pencapaian' => 'required|date|before_or_equal:today',
            'status' => 'required|in:tercapai,belum_tercapai',
            'catatan' => 'nullable|string',
        ]);

        $tahapanPerkembanganData = TahapanPerkembanganData::findOrFail($id);

        $tahapanPerkembanganData->update([
            'tahapan_perkembangan_id' => $request->tahapan_perkembangan_id,
            'tanggal_pencapaian' => $request->tanggal_pencapaian,
            'status' => $request->status,
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('orangtua.tahapan_perkembangan.index')->with('success', 'Pencapaian tahapan perkembangan berhasil diupdate.');
    }
    public function destroy($id)
    {
        $tahapanPerkembanganData = TahapanPerkembanganData::findOrFail($id);
        $tahapanPerkembanganData->delete();

        return redirect()->route('orangtua.tahapan_perkembangan.index')->with('success', 'Pencapaian tahapan perkembangan berhasil dihapus.');
    }
}