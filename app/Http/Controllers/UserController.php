<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::whereIn('role', ['petugas', 'admin'])->get();
        return view('user.index', compact('users'));
    }

    public function create()
    {
        return view('user.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:users,name',
            'email' => 'required|unique:users,email|email',
            'role' => 'required',
            'password' => 'required|min:6',
        ], [
            'name.required' => 'Kolom nama wajib diisi.',
            'name.unique' => 'Nama ini sudah terdaftar. Silakan gunakan nama lain.',
            
            'email.required' => 'Kolom email wajib diisi.',
            'email.unique' => 'Alamat email sudah terdaftar.',
            'email.email' => 'Alamat email harus dalam format yang valid.',
        
            'role.required' => 'Kolom peran wajib diisi.',
            
            'password.required' => 'Kolom kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal :min karakter.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        // Kirim pesan sukses ke halaman index
        return redirect()->route('user')->with('success', 'Data pengguna berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('user.form', compact('user'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input dari form
        $request->validate([
            'name' => 'required|unique:users,name,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6', // Password opsional saat update
            'role' => 'required',
        ], [
            // Pesan error untuk validasi umum
            'required' => 'Kolom :attribute wajib diisi.',
            'email' => 'Kolom :attribute harus berupa alamat email yang valid.',
            'unique' => ':attribute sudah terdaftar.',
            'min' => ':attribute minimal :min karakter.',
            
            // Pesan error spesifik
            'name.required' => 'Nama pengguna wajib diisi.',
            'name.unique' => 'Nama ini sudah terdaftar. Silakan gunakan nama lain.',
            
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Alamat email ini sudah digunakan oleh pengguna lain.',
            
            'role.required' => 'Peran pengguna wajib diisi.',
            
            'password.min' => 'Kata sandi minimal harus :min karakter.',
        ]);

        // Temukan user berdasarkan ID
        $user = User::findOrFail($id);

        // Perbarui data user
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => $request->password ? Hash::make($request->password) : $user->password, // Hanya update password jika diisi
        ]);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('user')->with('success', 'Data pengguna berhasil diperbarui!');
    }

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            
            return redirect()->route('user')->with('success', 'Data pengguna berhasil dihapus!');
        } catch (\Exception $e) {
            
            return redirect()->route('user')->with('error', 'Terjadi kesalahan saat menghapus data!');
        }
    }

    public function index_pelanggan()
    {
        $users = User::where('role', 'pelanggan')->get();
        return view('pelanggan.index', compact('users'));
    }

    public function create_pelanggan()
    {
        return view('pelanggan.form');
    }

    public function store_pelanggan(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:users,name',
            'email' => 'required|email|unique:users,email',
            'role' => 'required',
        ], [
            // Pesan umum untuk semua field
            'required' => 'Kolom :attribute wajib diisi.',
            'email' => 'Kolom :attribute harus berupa alamat email yang valid.',
            'unique' => ':attribute sudah terdaftar.',
        
            // Pesan spesifik per field
            'name.required' => 'Nama pengguna wajib diisi.',
            'name.unique' => 'Nama ini sudah digunakan. Silakan pilih nama lain.',
            
            'email.required' => 'Alamat email wajib diisi.',
            'email.unique' => 'Alamat email ini sudah terdaftar.',
            'email.email' => 'Format alamat email tidak valid.',
        
            'role.required' => 'Peran pengguna wajib diisi.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => '',
        ]);

        // Kirim pesan sukses ke halaman index
        return redirect()->route('pelanggan')->with('success', 'Data pelanggan berhasil ditambahkan!');
    }

    public function edit_pelanggan($id)
    {
        $user = User::where('role', 'pelanggan')->find($id);
        return view('pelanggan.form', compact('user'));
    }

    public function update_pelanggan(Request $request, $id)
    {
        // Validasi input dari form
        $request->validate([
            'name' => 'required|unique:users,name,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required',
        ], [
            // Pesan umum untuk semua field
            'required' => 'Kolom :attribute wajib diisi.',
            'unique' => ':attribute sudah digunakan.',
            'email' => 'Kolom :attribute harus berupa alamat email yang valid.',
        
            // Pesan spesifik per field
            'name.required' => 'Nama pengguna wajib diisi.',
            'name.unique' => 'Nama ini sudah digunakan oleh pengguna lain.',
            
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'email.unique' => 'Alamat email ini sudah terdaftar oleh pengguna lain.',
            
            'role.required' => 'Peran pengguna wajib diisi.',
        ]);

        // Temukan user berdasarkan ID
        $user = User::findOrFail($id);

        // Perbarui data user
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => '',
        ]);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('pelanggan')->with('success', 'Data Pelanggan berhasil diperbarui!');
    }

    public function destroy_pelanggan($id)
    {
        try {
            $user = User::where('role', 'pelanggan')->find($id);
            $user->delete();
            
            return redirect()->route('pelanggan')->with('success', 'Data Pelanggan berhasil dihapus!');
        } catch (\Exception $e) {
            
            return redirect()->route('pelanggan')->with('error', 'Terjadi kesalahan saat menghapus data!');
        }
    }
}