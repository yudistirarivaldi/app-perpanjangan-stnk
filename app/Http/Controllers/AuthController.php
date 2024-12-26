<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
	public function register()
	{
		return view('auth/register');
	}

	public function registerSimpan(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'nama' => 'required',
			'email' => 'required|email|unique:users,email', 
			'password' => 'required|confirmed|min:6'
		]);
		
		if ($validator->fails()) {
			return redirect()->back()
				->withErrors($validator)
				->withInput()
				->with('error', 'Gagal mendaftar! Periksa kembali data Anda.');
		}
		
		User::create([
			'name' => $request->nama,
			'email' => $request->email,
			'password' => Hash::make($request->password),
		]);

		return redirect()->route('login')->with('success', 'Akun berhasil didaftarkan. Silakan login.');
	}

	public function login()
	{
		return view('auth/login');
	}

	public function loginAksi(Request $request)
	{
		// Validasi input dari form
		$validator = Validator::make($request->all(), [
			'email' => 'required|email',
			'password' => 'required'
		]);

		// Jika validasi gagal, kembalikan ke halaman sebelumnya dengan pesan error
		if ($validator->fails()) {
			return redirect()->back()
				->withErrors($validator)
				->withInput()
				->with('error', 'Gagal login! Periksa kembali email dan password Anda.');
		}

		// Coba otentikasi user
		if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
			return redirect()->back()
				->with('error', 'Email atau password salah, silakan coba lagi.');
		}

		// Regenerasi sesi setelah login sukses
		$request->session()->regenerate();

		// Redirect ke dashboard dengan pesan sukses
		return redirect()->route('dashboard')->with('success', 'Selamat datang kembali!');
	}

	public function logout(Request $request)
	{
		Auth::guard('web')->logout();

		$request->session()->invalidate();

		return redirect('/');
	}
}
