@extends('layouts.app')

@section('title', 'Form Edit Pengingat Otomatis')

@section('contents')
  <form action="{{route('time.update', $time->id)}}" method="post">
    @csrf

    <div class="row">
      <div class="col-12">
        <div class="card shadow mb-4">
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Edit Pengingat Otomatis</h6>
          </div>
          <div class="card-body">
            <div class="form-group">
              <label for="jam">Jam</label>
              <input type="time" class="form-control @error('jam') is-invalid @enderror" id="jam" name="jam" value="{{ old('jam', isset($time) ? $time->jam : '') }}">
              @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="hari">Hari Pengingat Otomatis Sebelum Jatuh Tempo</label>
              <input type="number" class="form-control @error('hari') is-invalid @enderror" id="hari" name="hari" value="{{ old('hari', isset($time) ? $time->hari : '') }}">
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

  