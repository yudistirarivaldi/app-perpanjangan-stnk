<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\User;
use App\Models\Category;
use App\Models\Merk;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::with(['user', 'category', 'merk'])->get();
        return view('vehicle.index', compact('vehicles'));
    }

    public function create()
    {
        $users = User::where('role', 'pelanggan')->get();
        $categorys = Category::all();
        $merks = Merk::all();

        return view('vehicle.form', compact('users', 'categorys', 'merks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'plate_number' => 'required|unique:vehicles,plate_number',
            'category_id' => 'required',
            'merk_id' => 'required',
            'model' => 'required',
            'year' => 'required|numeric',
            'tax_due_date' => 'required|date',
        ], [
            // Pesan umum
            'required' => 'Kolom :attribute wajib diisi.',
            'unique' => ':attribute sudah terdaftar.',
            'numeric' => 'Kolom :attribute harus berupa angka.',
            'date' => 'Kolom :attribute harus berupa tanggal yang valid.',
        
            // Pesan spesifik per field
            'plate_number.required' => 'Nomor plat wajib diisi.',
            'plate_number.unique' => 'Nomor plat ini sudah digunakan oleh kendaraan lain.',
            
            'year.required' => 'Tahun kendaraan wajib diisi.',
            'year.numeric' => 'Tahun kendaraan harus berupa angka.',
        
            'tax_due_date.required' => 'Tanggal jatuh tempo pajak wajib diisi.',
            'tax_due_date.date' => 'Format tanggal jatuh tempo pajak tidak valid.',
        ]);

        Vehicle::create($request->all());

        // Kirim pesan sukses ke halaman index
        return redirect()->route('vehicle')->with('success', 'Data kendaraan berhasil ditambahkan!');
    }

    public function edit($id)
    {
        // Ambil data kendaraan berdasarkan id, dan juga relasi user
        $vehicle = Vehicle::with(['user', 'category', 'merk'])->findOrFail($id);
    
        // Ambil semua data user untuk dropdown
        $users = User::where('role', 'pelanggan')->get();
        $categorys = Category::all();
        $merks = Merk::all();
        
    
        return view('vehicle.form', compact('vehicle', 'users', 'categorys', 'merks'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required',
            'plate_number' => 'required|unique:vehicles,plate_number,' . $id,
            'category_id' => 'required',
            'merk_id' => 'required',
            'model' => 'required',
            'year' => 'required|numeric',
            'tax_due_date' => 'required|date',
        ], [
            // Pesan umum
            'required' => 'Kolom :attribute wajib diisi.',
            'unique' => ':attribute sudah terdaftar.',
            'numeric' => 'Kolom :attribute harus berupa angka.',
            'date' => 'Kolom :attribute harus berupa tanggal yang valid.',
        
            // Pesan spesifik untuk atribut tertentu
            'plate_number.required' => 'Nomor plat wajib diisi.',
            'plate_number.unique' => 'Nomor plat ini sudah digunakan oleh kendaraan lain.',
            
            'year.required' => 'Tahun kendaraan wajib diisi.',
            'year.numeric' => 'Tahun kendaraan harus berupa angka.',
        
            'tax_due_date.required' => 'Tanggal jatuh tempo pajak wajib diisi.',
            'tax_due_date.date' => 'Format tanggal jatuh tempo pajak tidak valid.',
        ]);

        $vehicle = Vehicle::findOrFail($id);
        $vehicle->update($request->all());

        return redirect()->route('vehicle')->with('success', 'Data kendaraan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        try {
            $vehicle = Vehicle::findOrFail($id);
            $vehicle->delete();
            
            return redirect()->route('vehicle')->with('success', 'Data kendaraan berhasil dihapus!');
        } catch (\Exception $e) {
            
            return redirect()->route('vehicle')->with('error', 'Terjadi kesalahan saat menghapus data!');
        }
    }
}