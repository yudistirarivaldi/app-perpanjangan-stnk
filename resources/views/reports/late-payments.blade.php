@extends('layouts.app')

@section('title', 'Laporan Keterlambatan Pembayaran Pajak')

@section('contents')
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Laporan Keterlambatan Pembayaran Pajak</h6>
    </div>

    <div class="card-body">
      <!-- Filter Form -->
      <form action="{{ route('reports.late-payments') }}" method="GET">
        <div class="row mb-4">
          <div class="col-md-4">
            <label for="start_date">Tanggal Mulai</label>
            <input type="date" class="form-control" id="start_date" name="start_date" value="{{ request('start_date') }}">
          </div>
          <div class="col-md-4">
            <label for="end_date">Tanggal Akhir</label>
            <input type="date" class="form-control" id="end_date" name="end_date" value="{{ request('end_date') }}">
          </div>
          <div class="col-md-4">
            <label>&nbsp;</label> 
            <button type="submit" class="btn btn-primary btn-block">Filter</button>
          </div>
          <div class="col-md-4">
            <label for="end_date"></label>
            <a href="{{ route('reports.late-payments.export', ['start_date' => request('start_date'), 'end_date' => request('end_date')]) }}" 
              class="btn btn-danger mt-2" target="_blank">
              <i class="fas fa-file-pdf"></i> Export PDF
           </a>
          </div>
        </div>
      </form>

      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr class="text-center">
              <th>No</th>
              <th>Nomor Plat</th>
              <th>Nama Pemilik</th>
              <th>Tanggal Jatuh Tempo</th>
              <th>Jumlah Hari Keterlambatan</th>
              <th>Status Pembayaran</th>
            </tr>
          </thead>
          <tbody>
            @php($no = 1)
            @foreach ($latePayments as $row)
            <tr class="text-center">
                <th>{{ $no++ }}</th>
                <td>{{ $row->plate_number ?? '' }}</td>
                <td>{{ $row->user_name ?? '' }}</td>
                <td>{{ $row->tax_due_date ?? '' }}</td>
                <td>{{ $row->days_late ?? '' }} Hari</td>
                <td>{{ ucfirst($row->payment_status ?? 'Belum Bayar') }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection