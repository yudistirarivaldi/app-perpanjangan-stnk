@extends('layouts.app')

@section('title', isset($user) ? 'Form Edit Pengguna' : 'Form Tambah Pengguna')

@section('contents')
  <form action="{{ isset($user) ? route('user.update', $user->id) : route('user.tambah.simpan') }}" method="post">
    @csrf

    <div class="row">
      <div class="col-12">
        <div class="card shadow mb-4">
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ isset($user) ? 'Form Edit Pengguna' : 'Form Tambah Pengguna' }}</h6>
          </div>
          <div class="card-body">
            <div class="form-group">
              <label for="name">Nama</label>
              <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', isset($user) ? $user->name : '') }}" placeholder="Masukkan email pengguna">
              @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', isset($user) ? $user->email : '') }}" placeholder="Masukkan email pengguna">
              @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="role">Role</label>
              <select name="role" id="role" class="custom-select @error('role') is-invalid @enderror">
                <option value="" disabled>-- Pilih Tipe Role --</option>
                <option value="admin" {{ (old('role', isset($user) ? $user->role : '') == 'admin') ? 'selected' : '' }}>Admin</option>
                <option value="petugas" {{ (old('role', isset($user) ? $user->role : '') == 'petugas') ? 'selected' : '' }}>Petugas</option>
              </select>
              @error('role')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" value="{{ old('password', isset($user) ? $user->password : '') }}" placeholder="Masukkan email password">
              @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

          <div class="card-footer">
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </div>
      </div>
    </div>
  </form>

  <!-- Tambahkan SweetAlert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    // Notifikasi Sukses
    @if(session('success'))
      Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('success') }}',
        showConfirmButton: true
      });
    @endif

    // Notifikasi Gagal
    @if(session('error'))
      Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: '{{ session('error') }}',
        showConfirmButton: true
      });
    @endif
  </script>

@endsection

  