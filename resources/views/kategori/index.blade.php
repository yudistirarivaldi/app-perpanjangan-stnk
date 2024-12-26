@extends('layouts.app')

@section('title', 'Data Kategori Kendaraan')

@section('contents')
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Data Kategori Kendaraan</h6>
    </div>
    <div class="card-body">
      <a href="{{ route('kategori.tambah') }}" class="btn btn-primary mb-3">Tambah Kategori Kendaraan</a>
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr class="text-center">
              <th>No</th>
              <th>Nama </th>
              <th>Deskripsi</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @php($no = 1)
            @foreach ($kategori as $row)
            <tr class="text-center">
                <th>{{ $no++ }}</th>
                <td>{{ $row->name ?? '' }}</td>
                <td>{{ $row->description ?? '' }}</td>
                <td>
                  <a href="{{ route('kategori.edit', $row->id) }}" class="text-warning mr-2">
                      <i class="fas fa-edit"></i>
                  </a>
                  <a href="{{ route('kategori.hapus', $row->id) }}" class="text-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">
                      <i class="fas fa-trash"></i>
                  </a>
              </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

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
