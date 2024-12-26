<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
	public function index()
	{
		$kategori = Category::get();
		return view('kategori/index', ['kategori' => $kategori]);
	}

	public function create()
	{
		return view('kategori.form');
	}

	public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories,name',
            'description' => 'nullable',
        ]);

        Category::create($request->all());

        return redirect()->route('kategori')->with('success', 'Kategori berhasil ditambahkan!');
    }

	public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('kategori.form', compact('category'));
    }

	public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:categories,name,' . $id,
            'description' => 'nullable',
        ]);

        $category = Category::findOrFail($id);
        $category->update($request->all());

        return redirect()->route('kategori')->with('success', 'Kategori berhasil diperbarui!');
    }

	public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('kategori')->with('success', 'Kategori berhasil dihapus!');
    }
}
