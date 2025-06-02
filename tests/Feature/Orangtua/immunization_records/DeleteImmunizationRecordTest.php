<?php

namespace Tests\Feature\Orangtua;

use App\Models\User;
use App\Models\Immunization;
use App\Models\ImmunizationRecord;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class DeleteImmunizationRecordTest extends TestCase
{
    use RefreshDatabase;

    public function test_orangtua_can_delete_own_immunization_record()
    {
        $user = User::create([
            'nama_anak' => 'Fahira',
            'nik_anak' => '3210987654329999',
            'password' => Hash::make('fahira123'),
            'role' => 'orangtua',
        ]);

        $imunisasi = Immunization::create(['name' => 'TBC', 'age' => '1 bulan']);

        $record = ImmunizationRecord::create([
            'user_id' => $user->id,
            'immunization_id' => $imunisasi->id,
            'immunized_at' => now()->subDays(5)->toDateString(),
            'status' => 'Sudah',
        ]);

        $this->actingAs($user)->delete("/orangtua/immunization_records/{$record->id}")
             ->assertRedirect(route('orangtua.immunization_records.index'));

        $this->assertDatabaseMissing('immunization_records', ['id' => $record->id]);
    }
}
