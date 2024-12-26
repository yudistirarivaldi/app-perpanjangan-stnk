@extends('layouts.app')

@section('title', 'Laporan Pendapatan Pajak')

@section('contents')
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Laporan Pendapatan Pajak</h6>
    </div>

    <div class="card-body">
      <!-- Filter Form -->
      <form action="{{ route('reports.revenue') }}" method="GET">
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
            <a href="{{ route('reports.revenue.export', ['start_date' => request('start_date'), 'end_date' => request('end_date')]) }}" 
              class="btn btn-danger mt-2" target="_blank">
              <i class="fas fa-file-pdf"></i> Export PDF
           </a>
          </div>
        </div>
      </form>

      <!-- Table Data -->
      <div class="table-responsive">
        <table class="table table-bordered" width="100%" cellspacing="0" id=dataTable>
          <thead>
            <tr class="text-center">
              <th>No</th>
              <th>Nama Pemilik</th>
              <th>Plat Kendaraan</th>
              <th>Merk</th>
              <th>Model</th>
              <th>Kategori</th>
              <th>Total Pajak</th>
            </tr>
          </thead>
          <tbody>
            @php($no = 1)
            @foreach ($revenues as $row)
              <tr class="text-center">
                <td>{{ $no++ }}</td>
                <td>{{ $row->pemilik ?? '-' }}</td>
                <td>{{ $row->plate_number ?? '-' }}</td>
                <td>{{ $row->merk ?? '-' }}</td>
                <td>{{ $row->model ?? '-' }}</td>
                <td>{{ $row->kategori ?? '-' }}</td>
                <td>Rp {{ number_format($row->payment_amount, 2, ',', '.') }}</td>
              </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr class="text-center">
              <td colspan="6"><strong>Total Kendaraan</strong></td>
              <td><strong>{{ $totalKendaraan }}</strong></td>
            </tr>
            <tr class="text-center">
              <td colspan="6"><strong>Grand Total</strong></td>
              <td><strong>Rp {{ number_format($grandTotal, 2, ',', '.') }}</strong></td>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>
@endsection