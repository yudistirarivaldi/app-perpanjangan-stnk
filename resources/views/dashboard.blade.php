@extends('layouts.app')

@section('title', '')

@section('contents')
<div class="container-fluid">

  <!-- Row untuk Selamat Datang -->
  <div class="row justify-content-center align-items-center mt-5">
    <div class="col-md-8 text-center">
      {{-- <img src="{{ asset('img/logo_bapenda.png') }}" alt="Logo Bapenda Banjarbaru" class="mb-4" width="420px"> --}}
      <h1 class="display-4 font-weight-bold text-primary">Selamat Datang di Bapenda Banjarbaru</h1>
      <p class="lead text-gray-800 mt-3">Melayani dengan Integritas dan Profesionalisme untuk Masyarakat Banjarbaru</p>
      <hr class="my-4">
      <p>Kami berkomitmen memberikan pelayanan terbaik dalam pengelolaan pajak dan pendapatan daerah. Bersama kita wujudkan Banjarbaru yang lebih maju!</p>
    </div>
  </div>

  <!-- Informasi atau Quote -->
  <div class="row mt-5">
    <div class="col-md-4">
      <div class="card border-left-primary shadow py-2">
        <div class="card-body">
          <div class="text-center">
            <i class="fas fa-hand-holding-usd fa-3x text-primary mb-3"></i>
            <h5 class="font-weight-bold">Pajak Daerah</h5>
            <p>Pajak yang Anda bayar adalah kontribusi nyata untuk pembangunan Banjarbaru. Dengan prinsip kerja cerdas</p>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card border-left-success shadow py-2">
        <div class="card-body">
          <div class="text-center">
            <i class="fas fa-city fa-3x text-success mb-3"></i>
            <h5 class="font-weight-bold">Pembangunan</h5>
            <p>Setiap kontribusi Anda mendukung pembangunan infrastruktur dan kesejahteraan masyarakat.</p>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card border-left-warning shadow py-2">
        <div class="card-body">
          <div class="text-center">
            <i class="fas fa-users fa-3x text-warning mb-3"></i>
            <h5 class="font-weight-bold">Pelayanan</h5>
            <p>Kami hadir untuk memberikan kemudahan dan kenyamanan dalam setiap layanan yang Anda butuhkan.</p>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
@endsection