@extends('layouts.app')

@section('title', 'Data Kategori Kendaraan')

@section('contents')
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Data Pengingat Otomatis</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr class="text-center">
              <th>No</th>
              <th>Jam</th>
              <th>Hari Pengingat Otomatis Sebelum Jatuh Tempo</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @php($no = 1)
            @foreach ($time as $row)
            <tr class="text-center">
                <th>{{ $no++ }}</th>
                <td>{{ $row->jam ?? '' }}</td>
                <td>{{ $row->hari ?? '' }} Hari sebelum jatuh tempo</td>
                <td>
                  <a href="{{ route('time.edit', $row->id) }}" class="text-warning mr-2">
                      <i class="fas fa-edit"></i>
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
