<?php

namespace Tests\Feature\Nutrition;

use Tests\TestCase;
use App\Models\User;

class SearchNutritionFailViewTest extends TestCase
{
    public function test_orangtua_fails_wrong_view_assertion()
{
    $orangtua = \App\Models\User::where('role', 'orangtua')->first();
    $this->assertNotNull($orangtua);

    $response = $this->actingAs($orangtua)->get('/nutrition/user');

    // Pastikan status 404 (atau sesuai responsenya)
    $response->assertStatus(404);

    // Pastikan responsenya bukan instance view
    $this->assertFalse($response->baseResponse instanceof \Illuminate\View\View);
}



}
