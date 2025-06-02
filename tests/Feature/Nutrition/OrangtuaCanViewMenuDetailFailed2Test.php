<?php

namespace Tests\Feature\Nutrition;

use Tests\TestCase;

class OrangtuaCanViewMenuDetailFailed2Test extends TestCase
{
    public function test_orangtua_redirected_when_not_logged_in()
    {
        // Akses detail menu tanpa login
        $response = $this->get(route('orangtua.nutritionUs.show', 1)); // Asumsikan ID 1 ada

        // Harus redirect ke halaman login
        $response->assertRedirect(route('login'));
        $response->assertStatus(302);
    }
}
