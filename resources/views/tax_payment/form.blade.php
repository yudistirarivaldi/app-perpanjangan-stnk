@extends('layouts.app')

@section('title', isset($tax_payment) ? 'Form Edit Pembayaran' : 'Form Tambah Pembayaran')

@section('contents')
  <form action="{{ isset($tax_payment) ? route('tax_payment.update', $tax_payment->id) : route('tax_payment.tambah.simpan') }}" method="post">
    @csrf

    <div class="row">
      <div class="col-12">
        <div class="card shadow mb-4">
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ isset($tax_payment) ? 'Form Edit Pembayaran' : 'Form Tambah Pembayaran' }}</h6>
          </div>
          <div class="card-body">
            <div class="form-group">
              <label for="vehicle_id">Nomor Plat</label>
              <select name="vehicle_id" id="vehicle_id" class="custom-select @error('vehicle_id') is-invalid @enderror">
                <option value="" disabled selected>-- Pilih Nomor Plat --</option>
                @foreach($vehicles as $vehicle)
                  <option value="{{ $vehicle->id }}" {{ old('vehicle_id', isset($tax_payment) ? $tax_payment->vehicle_id : '') == $vehicle->id ? 'selected' : '' }}>
                    {{ $vehicle->plate_number }} - {{ $vehicle->user->name }}
                  </option>
                @endforeach
              </select>
              @error('vehicle_id')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            
            <div class="form-group">
              <label for="payment_date">Tanggal Pembayaran</label>
              <input type="date" class="form-control @error('payment_date') is-invalid @enderror" id="payment_date" name="payment_date" value="{{ old('payment_date', isset($tax_payment) ? $tax_payment->payment_date : '') }}">
              @error('payment_date')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="payment_amount">Total Pembayaran</label>
              <input 
                type="text" 
                class="form-control @error('payment_amount') is-invalid @enderror" 
                id="payment_amount" 
                name="payment_amount" 
                value="{{ old('payment_amount', isset($tax_payment) ? number_format($tax_payment->payment_amount, 2, ',', '.') : '') }}" 
                onkeyup="formatRupiah(this)" placeholder="Masukkan total pembayaran">
              
              @error('payment_amount')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="payment_method">Metode Pembayaran</label>
              <select name="payment_method" id="payment_method" class="custom-select @error('payment_method') is-invalid @enderror">
                <option value="" disabled selected>-- Pilih Metode Pembayaran --</option>
                <option value="cash" {{ old('payment_method', isset($tax_payment) ? $tax_payment->payment_method : '') == 'cash' ? 'selected' : '' }}>Cash</option>
                <option value="transfer" {{ old('payment_method', isset($tax_payment) ? $tax_payment->payment_method : '') == 'transfer' ? 'selected' : '' }}>Transfer</option>
                <option value="online" {{ old('payment_method', isset($tax_payment) ? $tax_payment->payment_method : '') == 'online' ? 'selected' : '' }}>Online</option>
              </select>
              @error('payment_method')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="payment_status">Status Pembayaran</label>
              <select name="payment_status" id="payment_status" class="custom-select @error('payment_status') is-invalid @enderror">
                <option value="" disabled selected>-- Pilih Status Pembayaran --</option>
                <option value="success" {{ (old('payment_status', isset($pax_payment) ? $pax_payment->payment_status : '') == 'success') ? 'selected' : '' }}>success</option>
                <option value="pending" {{ (old('payment_status', isset($pax_payment) ? $pax_payment->payment_status : '') == 'pending') ? 'selected' : '' }}>pending</option>
                <option value="failed" {{ (old('payment_status', isset($pax_payment) ? $pax_payment->payment_status : '') == 'failed') ? 'selected' : '' }}>failed</option>
              </select>
              @error('payment_status')
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

<script>
  function formatRupiah(element) {
    // Ambil nilai dari input
    let value = element.value;

    // Hilangkan karakter selain angka
    value = value.replace(/[^,\d]/g, '');

    // Pisahkan nilai menjadi bagian ribuan
    let split = value.split(',');
    let sisa = split[0].length % 3;
    let rupiah = split[0].substr(0, sisa);
    let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    // Jika ada ribuan, tambahkan titik
    if (ribuan) {
      let separator = sisa ? '.' : '';
      rupiah += separator + ribuan.join('.');
    }

    // Tambahkan desimal jika ada
    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

    // Set nilai ke input
    element.value = rupiah;
  }
</script>

@endsection

  