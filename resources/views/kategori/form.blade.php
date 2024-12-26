@extends('layouts.app')

@section('title', isset($category) ? 'Form Edit Kategori' : 'Form Tambah Kategori Kendaraan')

@section('contents')
  <form action="{{ isset($category) ? route('kategori.update', $category->id) : route('kategori.tambah.simpan') }}" method="post">
    @csrf

    <div class="row">
      <div class="col-12">
        <div class="card shadow mb-4">
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ isset($category) ? 'Form Edit Kategori Kendaraan' : 'Form Tambah Kategori Kendaraan' }}</h6>
          </div>
          <div class="card-body">
            <div class="form-group">
              <label for="name">Nama</label>
              <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', isset($category) ? $category->name : '') }}" placeholder="Masukkan nama kategori">
              @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="description">Deskripsi</label>
              <input type="text" class="form-control @error('description') is-invalid @enderror" id="description" name="description" value="{{ old('description', isset($category) ? $category->description : '') }}" placeholder="Masukkan deskripsi kategori">
              @error('description')
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

  