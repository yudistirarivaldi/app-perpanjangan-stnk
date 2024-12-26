@extends('layouts.app')

@section('title', isset($vehicle) ? 'Form Edit Kendaraan' : 'Form Tambah Kendaraan')

@section('contents')
  <form action="{{ isset($vehicle) ? route('vehicle.update', $vehicle->id) : route('vehicle.tambah.simpan') }}" method="post">
    @csrf

    <div class="row">
      <div class="col-12">
        <div class="card shadow mb-4">
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ isset($vehicle) ? 'Form Edit Kendaraan' : 'Form Tambah Kendaraan' }}</h6>
          </div>
          <div class="card-body">
            <div class="form-group">
              <div class="form-group">
                <label for="user_id">Pemilik Kendaraan</label>
                <select class="form-control @error('user_id') is-invalid @enderror" id="user_id" name="user_id">
                  <option value="" disabled selected>-- Pilih Pemilik Kendaraan --</option>
                  @foreach ($users as $user)
                    <option value="{{ $user->id }}" 
                      {{ old('user_id', isset($vehicle) ? $vehicle->user_id : '') == $user->id ? 'selected' : '' }}>
                      {{ $user->name }}
                    </option>
                  @endforeach
                </select>
                @error('user_id')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="form-group">
                <label for="category_id">Kategori Kendaraan</label>
                <select class="form-control @error('category_id') is-invalid @enderror" id="category_id" name="category_id">
                  <option value="" disabled selected>-- Pilih Kategori Kendaraan --</option>
                  @foreach ($categorys as $category)
                    <option value="{{ $category->id }}" 
                      {{ old('category_id', isset($vehicle) ? $vehicle->category_id : '') == $category->id ? 'selected' : '' }}>
                      {{ $category->name }}
                    </option>
                  @endforeach
                </select>
                @error('category_id')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
  
            <div class="form-group">
              <label for="plate_number">Nomor Plat</label>
              <input type="text" class="form-control @error('plate_number') is-invalid @enderror" id="plate_number" name="plate_number" value="{{ old('plate_number', isset($vehicle) ? $vehicle->plate_number : '') }}" placeholder="Masukkan nomor plat kendaraan">
              @error('plate_number')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="merk_id">Merk Kendaraan</label>
              <select class="form-control @error('merk_id') is-invalid @enderror" id="merk_id" name="merk_id">
                <option value="" disabled selected>-- Pilih Merk Kendaraan --</option>
                @foreach ($merks as $merk)
                  <option value="{{ $merk->id }}" 
                    {{ old('merk_id', isset($vehicle) ? $vehicle->merk_id : '') == $merk->id ? 'selected' : '' }}>
                    {{ $merk->name }}
                  </option>
                @endforeach
              </select>
              @error('merk_id')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="model">Model</label>
              <input type="text" class="form-control @error('model') is-invalid @enderror" id="model" name="model" value="{{ old('model', isset($vehicle) ? $vehicle->model : '') }}" placeholder="Masukkan model kendaraan">
              @error('model')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="year">Tahun</label>
              <input type="number" class="form-control @error('year') is-invalid @enderror" id="year" name="year" value="{{ old('year', isset($vehicle) ? $vehicle->year : '') }}" placeholder="Masukkan tahun rilis/beli kendaraan">
              @error('year')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="tax_due_date">Tanggal Jatuh Tempo</label>
              <input type="date" class="form-control @error('tax_due_date') is-invalid @enderror" id="tax_due_date" name="tax_due_date" value="{{ old('tax_due_date', isset($vehicle) ? $vehicle->tax_due_date : '') }}">
              @error('tax_due_date')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
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

  