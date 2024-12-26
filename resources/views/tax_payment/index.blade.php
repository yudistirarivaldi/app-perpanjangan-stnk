@extends('layouts.app')

@section('title', 'Data Pembayaran Pajak')

@section('contents')
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Data Pembayaran Pajak</h6>
    </div>
    <div class="card-body">
      <a href="{{ route('tax_payment.tambah') }}" class="btn btn-primary mb-3">Tambah Pembayaran</a>
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr class="text-center">
              <th>No</th>
              <th>Pemilik Kendaraan</th>
              <th>Kendaraan</th>
              <th>Tanggal Pembayaran</th>
              <th>Jumlah Pembayaran</th>
              <th>Metode Pembayaran</th>
              <th>Status Pembayaran</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @php($no = 1)
            @foreach ($payments as $row)
            <tr class="text-center">
                <th>{{ $no++ }}</th>
                <td>{{ $row->vehicle->user->name }}</td>
                <td>{{ $row->vehicle->plate_number }}</td>
                <td>{{ $row->payment_date }}</td>
                <td>Rp {{ number_format($row->payment_amount, 2) }}</td>
                <td>{{ ucfirst($row->payment_method) }}</td>
                <td>{{ ucfirst($row->payment_status) }}</td>
                <td>
                  <a href="{{ route('tax_payment.edit', $row->id) }}" class="text-warning mr-2">
                    <i class="fas fa-edit"></i>
                  </a>
                  <a href="{{ route('tax_payment.hapus', $row->id) }}" class="text-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">
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
