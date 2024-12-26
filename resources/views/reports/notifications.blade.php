@extends('layouts.app')

@section('title', 'Laporan Peringatan')

@section('contents')
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Laporan Peringatan</h6>
    </div>

    <div class="card-body">
      <!-- Filter Form -->
      <form action="{{ route('reports.notifications') }}" method="GET">
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
            <label for="end_date"></label>
            <button type="submit" class="btn btn-primary btn-block mt-2">Filter</button>
          </div>
          <div class="col-md-4">
            <label for="end_date"></label>
            <a href="{{ route('reports.notifications.export', ['start_date' => request('start_date'), 'end_date' => request('end_date')]) }}" 
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
              <th>Pesan</th>
              <th>Tanggal Notifikasi</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            @php($no = 1)
            @foreach ($notifications as $row)
            <tr class="text-center">
                <th>{{ $no++ }}</th>
                <td>{{ $row->plate_number ?? '' }}</td>
                <td>{{ $row->message ?? '' }}</td>
                <td>{{ $row->notification_date ?? '' }}</td>
                <td>{{ ucfirst($row->status) ?? '' }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection