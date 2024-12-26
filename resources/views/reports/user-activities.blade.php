@extends('layouts.app')

@section('title', 'Laporan Aktivitas Pengguna')

@section('contents')
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Laporan Aktivitas Pengguna</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Pengguna</th>
              <th>Deskripsi Aktivitas</th>
              <th>Waktu Aktivitas</th>
            </tr>
          </thead>
          <tbody>
            @php($no = 1)
            @foreach ($activities as $row)
            <tr class="text-center">
                <th>{{ $no++ }}</th>
                <td>{{ $row->causer->name ?? '-' }}</td>
                <td>{{ $row->description }}</td>
                <td>{{ $row->created_at }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection