<?php

namespace Tests\Feature\Orangtua;

use App\Models\User;
use App\Models\Immunization;
use App\Models\ImmunizationRecord;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ViewImmunizationRecordTest extends TestCase
{
    use RefreshDatabase;

    public function test_orangtua_can_see_own_immunization_records()
    {
        $user = User::create([
            'nama_anak' => 'Zara',
            'nik_anak' => '3210987654321122',
            'password' => Hash::make('pass123'),
            'role' => 'orangtua',
        ]);

        $imunisasi = Immunization::create([
            'name' => 'Campak',
            'age' => '9 bulan',
            'description' => 'Campak vaksin',
        ]);

        ImmunizationRecord::create([
            'user_id' => $user->id,
            'immunization_id' => $imunisasi->id,
            'immunized_at' => now()->toDateString(),
            'status' => 'Sudah',
        ]);

        $response = $this->actingAs($user)->get('/orangtua/immunization_records');

        $response->assertStatus(200);
        $response->assertSee('Campak');
    }
}
