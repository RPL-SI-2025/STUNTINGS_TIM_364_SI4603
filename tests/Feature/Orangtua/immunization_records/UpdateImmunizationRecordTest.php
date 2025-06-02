<?php

namespace Tests\Feature\Orangtua;

use App\Models\User;
use App\Models\Immunization;
use App\Models\ImmunizationRecord;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UpdateImmunizationRecordTest extends TestCase
{
    use RefreshDatabase;

    public function test_orangtua_can_update_own_immunization_record()
    {
        $user = User::create([
            'nama_anak' => 'Zahra',
            'nik_anak' => '3210987654322222',
            'password' => Hash::make('pass123'),
            'role' => 'orangtua',
        ]);

        $imunisasi1 = Immunization::create(['name' => 'DPT', 'age' => '2 bulan']);
        $imunisasi2 = Immunization::create(['name' => 'Hepatitis B', 'age' => '0 bulan']);

        $record = ImmunizationRecord::create([
            'user_id' => $user->id,
            'immunization_id' => $imunisasi1->id,
            'immunized_at' => now()->subDays(10)->toDateString(),
            'status' => 'Belum',
        ]);

        $this->actingAs($user)->put("/orangtua/immunization_records/{$record->id}", [
            'immunization_id' => $imunisasi2->id,
            'immunized_at' => now()->toDateString(),
            'status' => 'Sudah',
        ])->assertRedirect(route('orangtua.immunization_records.index'));

        $this->assertDatabaseHas('immunization_records', [
            'id' => $record->id,
            'immunization_id' => $imunisasi2->id,
            'status' => 'Sudah',
        ]);
    }
}
