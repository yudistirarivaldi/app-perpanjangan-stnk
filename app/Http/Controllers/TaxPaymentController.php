<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TaxPayment;
use App\Models\Vehicle;

class TaxPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = TaxPayment::all();
        return view('tax_payment.index', compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vehicles = Vehicle::all();
        return view('tax_payment.form', compact('vehicles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'payment_date' => 'required|date',
            'payment_amount' => 'required|string',
            'payment_method' => 'required|in:cash,transfer,online',
            'payment_status' => 'required|in:success,pending,failed',
        ], [
            // Pesan error umum
            'required' => 'Kolom :attribute wajib diisi.',
            'exists' => 'Data :attribute tidak ditemukan dalam sistem.',
            'date' => 'Kolom :attribute harus berupa tanggal yang valid.',
            'in' => 'Kolom :attribute harus berupa salah satu dari: :values.',
            'string' => 'Kolom :attribute harus berupa teks.',
        
            // Pesan spesifik untuk atribut tertentu
            'vehicle_id.required' => 'Kendaraan wajib dipilih.',
            'vehicle_id.exists' => 'Kendaraan yang dipilih tidak valid.',
        
            'payment_date.required' => 'Tanggal pembayaran wajib diisi.',
            'payment_date.date' => 'Format tanggal pembayaran tidak valid.',
        
            'payment_amount.required' => 'Jumlah pembayaran wajib diisi.',
            'payment_amount.string' => 'Jumlah pembayaran harus berupa teks atau angka.',
        
            'payment_method.required' => 'Metode pembayaran wajib dipilih.',
            'payment_method.in' => 'Metode pembayaran harus berupa cash, transfer, atau online.',
        
            'payment_status.required' => 'Status pembayaran wajib diisi.',
            'payment_status.in' => 'Status pembayaran harus berupa success, pending, atau failed.',
        ]);
    
        // Hilangkan format Rupiah sebelum disimpan ke database
        $payment_amount = str_replace('.', '', $request->payment_amount);
        $payment_amount = str_replace(',', '.', $payment_amount);
    
        // Simpan data pembayaran pajak ke tabel tax_payments
        TaxPayment::create([
            'vehicle_id' => $request->vehicle_id,
            'payment_date' => $request->payment_date,
            'payment_amount' => $payment_amount, // Nilai sudah dibersihkan dari format rupiah
            'payment_method' => $request->payment_method,
            'payment_status' => $request->payment_status,
        ]);
        return redirect()->route('tax_payment')->with('success', 'Pembayaran pajak berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tax_payment = TaxPayment::findOrFail($id);
        $vehicles = Vehicle::all();
        return view('tax_payment.form', compact('tax_payment', 'vehicles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'payment_date' => 'required|date',
            'payment_amount' => 'required|numeric|min:1000',
            'payment_method' => 'required|in:cash,transfer,online',
            'payment_status' => 'required|in:success,pending,failed',
        ], [
            // Pesan umum
            'required' => 'Kolom :attribute wajib diisi.',
            'exists' => 'Data :attribute tidak ditemukan dalam sistem.',
            'date' => 'Kolom :attribute harus berupa tanggal yang valid.',
            'in' => 'Kolom :attribute harus salah satu dari: :values.',
            'numeric' => 'Kolom :attribute harus berupa angka.',
            'min' => 'Kolom :attribute minimal sebesar Rp :min.',
        
            // Pesan spesifik per field
            'vehicle_id.required' => 'Kendaraan wajib dipilih.',
            'vehicle_id.exists' => 'Kendaraan yang dipilih tidak terdaftar.',
            
            'payment_date.required' => 'Tanggal pembayaran wajib diisi.',
            'payment_date.date' => 'Format tanggal pembayaran tidak valid.',
        
            'payment_amount.required' => 'Jumlah pembayaran wajib diisi.',
            'payment_amount.numeric' => 'Jumlah pembayaran harus berupa angka.',
            'payment_amount.min' => 'Jumlah pembayaran minimal adalah Rp 1.000.',
        
            'payment_method.required' => 'Metode pembayaran wajib dipilih.',
            'payment_method.in' => 'Metode pembayaran harus berupa cash, transfer, atau online.',
        
            'payment_status.required' => 'Status pembayaran wajib diisi.',
            'payment_status.in' => 'Status pembayaran harus berupa success, pending, atau failed.',
        ]);
    
        // Hilangkan format Rupiah sebelum disimpan ke database
        $payment_amount = str_replace('.', '', $request->payment_amount);
        $payment_amount = str_replace(',', '.', $payment_amount);
    
        $payment = TaxPayment::findOrFail($id);
        $payment->update([
            'vehicle_id' => $request->vehicle_id,
            'payment_date' => $request->payment_date,
            'payment_amount' => $payment_amount, // Nilai sudah dibersihkan dari format rupiah
            'payment_method' => $request->payment_method,
            'payment_status' => $request->payment_status,
        ]);

        return redirect()->route('tax_payment')->with('success', 'Data pembayaran pajak berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $payment = TaxPayment::findOrFail($id);
        $payment->delete();
        return redirect()->route('tax_payment')->with('success', 'Data pembayaran pajak berhasil dihapus!');
    }
}
