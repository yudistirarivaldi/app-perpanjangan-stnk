<?php

namespace App\Http\Controllers;

use App\Models\Time;
use Illuminate\Http\Request;

class TimeController extends Controller
{
	public function index()
	{
		$time = Time::get();
		return view('time/index', ['time' => $time]);
	}

	public function edit($id)
    {
        $time = Time::findOrFail($id);
        return view('time.form', compact('time'));
    }

	public function update(Request $request, $id)
    {
        $request->validate([
            'jam' => 'required',
            'hari' => 'required',
        ], [
            'required' => 'Kolom :attribute wajib diisi.',
        ], [
            'jam' => 'Jam',
            'hari' => 'Hari',
        ]);

        $category = Time::findOrFail($id);
        $category->update($request->all());

        return redirect()->route('time')->with('success', 'Pengingat berhasil diperbarui!');
    }
}
