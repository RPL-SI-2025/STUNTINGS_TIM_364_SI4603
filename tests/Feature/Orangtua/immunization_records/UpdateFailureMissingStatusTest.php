<?php

namespace Tests\Feature\Orangtua\ImmunizationRecord;

use App\Models\User;
use App\Models\Immunization;
use App\Models\ImmunizationRecord;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UpdateFailureMissingStatusTest extends TestCase
{
    use RefreshDatabase;

    public function test_update_fails_when_required_status_is_empty()
    {
        $user = User::create([
            'nama_anak' => 'Salsa',
            'nik_anak' => '3210987654328888',
            'password' => Hash::make('password123'),
            'role' => 'orangtua',
        ]);

        $imunisasi = Immunization::create([
            'name' => 'Campak',
            'age' => '9 bulan',
        ]);

        $record = ImmunizationRecord::create([
            'user_id' => $user->id,
            'immunization_id' => $imunisasi->id,
            'immunized_at' => now()->subWeek()->toDateString(),
            'status' => 'Sudah',
        ]);

        $response = $this->actingAs($user)->put("/orangtua/immunization_records/{$record->id}", [
            'immunization_id' => $imunisasi->id,
            'immunized_at' => now()->toDateString(),
            'status' => '', // dikosongkan
        ]);

        $response->assertSessionHasErrors('status');
    }
}
