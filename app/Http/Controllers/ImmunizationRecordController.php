<?php

namespace App\Http\Controllers;

use App\Models\Immunization;
use App\Models\ImmunizationRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImmunizationRecordController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'orangtua') {
            abort(403, 'Unauthorized');
        }

        $records = ImmunizationRecord::with('immunization')
            ->where('user_id', auth()->id())
            ->get();

        return view('orangtua.immunization_records.index', compact('records'));
    }

    public function create()
    {
        if (auth()->user()->role !== 'orangtua') {
            abort(403, 'Unauthorized');
        }

        $immunizations = Immunization::all();
        return view('orangtua.immunization_records.create', compact('immunizations'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'orangtua') {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'immunization_id' => ['required', 'exists:immunizations,id'],
            'immunized_at' => ['required', 'date', 'before_or_equal:today'],
            'status' => ['required', 'in:Sudah,Belum'],
        ]);

        ImmunizationRecord::create([
            'user_id' => auth()->id(),
            ...$validated,
        ]);

        return redirect()
            ->route('orangtua.immunization_records.index')
            ->with('success', 'Riwayat imunisasi berhasil ditambahkan.');
    }

    public function edit(ImmunizationRecord $immunization_record)
    {
        if (auth()->user()->role !== 'orangtua') {
            abort(403, 'Unauthorized');
        }

        $this->authorizeRecord($immunization_record);

        $immunizations = Immunization::all();

        return view('orangtua.immunization_records.edit', compact('immunization_record', 'immunizations'));
    }

    public function update(Request $request, ImmunizationRecord $immunization_record)
    {
        if (auth()->user()->role !== 'orangtua') {
            abort(403, 'Unauthorized');
        }

        $this->authorizeRecord($immunization_record);

        $validated = $request->validate([
            'immunization_id' => ['required', 'exists:immunizations,id'],
            'immunized_at' => ['required', 'date', 'before_or_equal:today'],
            'status' => ['required', 'in:Sudah,Belum'],
        ]);

        $immunization_record->update($validated);

        return redirect()
            ->route('orangtua.immunization_records.index')
            ->with('success', 'Riwayat imunisasi berhasil diperbarui.');
    }

    public function destroy(ImmunizationRecord $immunization_record)
    {
        if (auth()->user()->role !== 'orangtua') {
            abort(403, 'Unauthorized');
        }

        $this->authorizeRecord($immunization_record);

        $immunization_record->delete();

        return redirect()
            ->route('orangtua.immunization_records.index')
            ->with('success', 'Riwayat imunisasi berhasil dihapus.');
    }

    private function authorizeRecord(ImmunizationRecord $record)
    {
        if ($record->user_id !== auth()->id()) {
            abort(403, 'Akses ditolak.');
        }
    }
}

