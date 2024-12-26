<?php

namespace App\Http\Controllers;

use App\Models\Merk;
use Illuminate\Http\Request;

class MerkController extends Controller
{
	public function index()
	{
		$merk = Merk::get();
		return view('merk/index', ['merk' => $merk]);
	}

	public function create()
	{
		return view('merk.form');
	}

	public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories,name',
            'description' => 'nullable',
        ], [
            // Pesan error umum
            'required' => 'Kolom :attribute wajib diisi.',
            'unique' => ':attribute sudah terdaftar.',
            
            // Pesan spesifik untuk atribut tertentu
            'name.required' => 'Nama kategori wajib diisi.',
            'name.unique' => 'Nama kategori ini sudah ada. Silakan gunakan nama lain.',
        ]);

        Merk::create($request->all());

        return redirect()->route('merk')->with('success', 'Merk berhasil ditambahkan!');
    }

	public function edit($id)
    {
        $merk = Merk::findOrFail($id);
        return view('merk.form', compact('merk'));
    }

	public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:merk,name,' . $id,
            'description' => 'nullable',
        ], [
            // Pesan error umum
            'required' => 'Kolom :attribute wajib diisi.',
            'unique' => ':attribute sudah terdaftar.',
            
            // Pesan spesifik untuk atribut tertentu
            'name.required' => 'Nama merk wajib diisi.',
            'name.unique' => 'Nama merk ini sudah digunakan. Silakan gunakan nama lain.',
        ]);

        $merk = Merk::findOrFail($id);
        $merk->update($request->all());

        return redirect()->route('merk')->with('success', 'Merk berhasil diperbarui!');
    }

	public function destroy($id)
    {
        $merk = Merk::findOrFail($id);
        $merk->delete();

        return redirect()->route('merk')->with('success', 'Merk berhasil dihapus!');
    }
}
