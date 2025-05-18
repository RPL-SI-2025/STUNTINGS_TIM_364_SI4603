<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NutritionRecommendation;

class NutritionController extends Controller
{
    public function index()
    {
        $menus = NutritionRecommendation::all();
        return view('nutrition.index', compact('menus'));
    }

    public function create()
    {
        return view('nutrition.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'nutrition' => 'required',
            'ingredients' => 'required',
            'instructions' => 'required',
            'category' => 'required|in:pagi,siang,malam,snack',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('uploads/nutrition', 'public');
        }

        NutritionRecommendation::create($data);

        return redirect()->route('nutrition.index')->with('success', 'Menu berhasil ditambahkan');
    }

    public function edit($id)
    {
        $menu = NutritionRecommendation::findOrFail($id);
        return view('nutrition.edit', compact('menu'));
    }

    public function update(Request $request, $id)
    {
        $menu = NutritionRecommendation::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'nutrition' => 'required',
            'ingredients' => 'required',
            'instructions' => 'required',
            'category' => 'required|in:pagi,siang,malam,snack',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('uploads/nutrition', 'public');
        }

        $menu->update($data);

        return redirect()->route('nutrition.index')->with('success', 'Menu berhasil diperbarui');
    }

    public function delet($id)
    {
        $menu = NutritionRecommendation::findOrFail($id);
        $menu->delete();

        return redirect()->route('nutrition.index')->with('success', 'Menu berhasil dihapus');
    }

    public function user()
    {

        
    }
}
