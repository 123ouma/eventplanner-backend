<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OB_Category;
use Illuminate\Http\Request;

class OB_CategoryController extends Controller
{
    // LIST
    public function index()
    {
        $categories = OB_Category::orderBy('id', 'desc')->get();
        return view('admin.categories.OB_index', compact('categories'));
    }

    // CREATE FORM
    public function create()
    {
        return view('admin.categories.OB_create');
    }

    // STORE
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        OB_Category::create([
            'name' => $request->name,
        ]);
return redirect()->route('admin.categories.index')
    ->with('success', 'Category created successfully');
    }

    // SHOW
    public function show($id)
    {
        $category = OB_Category::findOrFail($id);
        return view('admin.categories.OB_show', compact('category'));
    }

    // EDIT FORM
    public function edit($id)
    {
        $category = OB_Category::findOrFail($id);
        return view('admin.categories.OB_edit', compact('category'));
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = OB_Category::findOrFail($id);

        $category->update([
            'name' => $request->name,
        ]);
return redirect()->route('admin.categories.index')
    ->with('success', 'Category updated successfully');
    }

    // DELETE
    public function destroy($id)
    {
        $category = OB_Category::findOrFail($id);
        $category->delete();

        return back()->with('success', 'Category deleted successfully');
    }
}
