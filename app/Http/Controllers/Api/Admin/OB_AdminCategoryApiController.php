<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\OB_Category;
use Illuminate\Http\Request;

class OB_AdminCategoryApiController extends Controller
{
    // LIST ALL CATEGORIES
    public function index()
    {
        $categories = OB_Category::orderBy('name', 'asc')->get();

        return response()->json($categories);
    }

    // STORE CATEGORY
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = OB_Category::create([
            'name' => $request->name,
        ]);

        return response()->json([
            'message' => 'Category created successfully',
            'category' => $category
        ], 201);
    }

    // SHOW ONE CATEGORY
    public function show($id)
    {
        $category = OB_Category::findOrFail($id);

        return response()->json($category);
    }

    // UPDATE CATEGORY
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = OB_Category::findOrFail($id);

        $category->update([
            'name' => $request->name,
        ]);

        return response()->json([
            'message' => 'Category updated successfully',
            'category' => $category
        ]);
    }

    // DELETE CATEGORY
    public function destroy($id)
    {
        $category = OB_Category::findOrFail($id);
        $category->delete();

        return response()->json([
            'message' => 'Category deleted successfully'
        ]);
    }
}