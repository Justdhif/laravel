<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function addCategories(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
        ]);

        Category::create([
            'category_name' => $request->category_name,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function destroyCategories($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Kategori berhasil dihapus.');
    }
}
