<?php

namespace Tests\Feature\Orangtua;

use App\Models\User;
use App\Models\Immunization;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CreateImmunizationRecordTest extends TestCase
{
    use RefreshDatabase;

    public function test_orangtua_can_create_immunization_record()
    {
        $user = User::create([
            'nama_anak' => 'Tania',
            'nik_anak' => '3210987654321234',
            'password' => Hash::make('password123'),
            'role' => 'orangtua',
        ]);

        $imunisasi = Immunization::create([
            'name' => 'Polio',
            'age' => '0 bulan',
            'description' => 'Vaksin Polio',
        ]);

        $this->actingAs($user)->post('/orangtua/immunization_records', [
            'immunization_id' => $imunisasi->id,
            'immunized_at' => now()->toDateString(),
            'status' => 'Sudah',
        ])->assertRedirect(route('orangtua.immunization_records.index'));

        $this->assertDatabaseHas('immunization_records', [
            'user_id' => $user->id,
            'immunization_id' => $imunisasi->id,
            'status' => 'Sudah',
        ]);
    }
}
