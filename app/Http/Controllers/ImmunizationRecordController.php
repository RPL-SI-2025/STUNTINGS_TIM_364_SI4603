<?php

namespace App\Http\Controllers;

use App\Models\Immunization;
use App\Models\ImmunizationRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImmunizationRecordController extends Controller
{
    public function __construct()
    {
        // Hanya orangtua yang bisa mengakses controller ini
        $this->middleware(function ($request, $next) {
            if (Auth::check() && Auth::user()->role !== 'orangtua') {
                // Jika role bukan orangtua, tampilkan 403 forbidden
                abort(403, 'Anda tidak memiliki akses ke halaman ini.');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $records = ImmunizationRecord::with('immunization')
            ->where('user_id', Auth::id())
            ->get();

        return view('orangtua.immunization_records.index', compact('records'));
    }

    public function create()
    {
        $immunizations = Immunization::all();
        return view('orangtua.immunization_records.create', compact('immunizations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'immunization_id' => ['required', 'exists:immunizations,id'],
            'immunized_at' => ['required', 'date', 'before_or_equal:today'],
            'status' => ['required', 'in:Sudah,Belum'],
        ]);

        ImmunizationRecord::create([
            'user_id' => Auth::id(),
            ...$validated,
        ]);

        return redirect()
            ->route('orangtua.immunization_records.index')
            ->with('success', 'Riwayat imunisasi berhasil ditambahkan.');
    }

    public function edit(ImmunizationRecord $immunization_record)
    {
        $this->authorizeRecord($immunization_record);

        $immunizations = Immunization::all();

        return view('orangtua.immunization_records.edit', compact('immunization_record', 'immunizations'));
    }

    public function update(Request $request, ImmunizationRecord $immunization_record)
    {
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
        $this->authorizeRecord($immunization_record);

        $immunization_record->delete();

        return redirect()
            ->route('orangtua.immunization_records.index')
            ->with('success', 'Riwayat imunisasi berhasil dihapus.');
    }

    private function authorizeRecord(ImmunizationRecord $record)
    {
        if ($record->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }
    }
}
