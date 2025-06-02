<?php

namespace Tests\Feature\Nutrition;

use Tests\TestCase;
use App\Models\User;
use App\Models\NutritionRecommendation;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AccessOrangtuaIndexFiled2Test extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_nutrition_index()
{
    // Akses tanpa login
    $response = $this->get(route('orangtua.nutritionUs.index'));

    // Harus redirect ke login
    $response->assertRedirect(route('login'));
}

    
}
