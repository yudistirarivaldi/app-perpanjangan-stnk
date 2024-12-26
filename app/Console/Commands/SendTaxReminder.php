<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Vehicle;
use App\Models\Notification;
use Illuminate\Support\Facades\Mail;
use App\Models\Time;

class SendTaxReminder extends Command
{
    /**
     * Nama dan deskripsi command
     */
    protected $signature = 'tax:reminder';

    protected $description = 'Kirim notifikasi pengingat pajak kendaraan yang akan jatuh tempo dalam 7 hari ke depan.';

    /**
     * Logika Command
     */
    public function handle()
    {

        $time = Time::findOrFail(1);

        $vehicles = Vehicle::whereDate('tax_due_date', now()->addDays($time->hari))
                    ->with('user')
                    ->get();

        if ($vehicles->count() > 0) {
            foreach ($vehicles as $vehicle) {
                try {
                    if ($vehicle->user) { // Pastikan relasi user ada
                        $message = 
                            "Yth. {$vehicle->user->name},\n\n" .
                            "Pengingat Pajak Kendaraan Anda\n\n" .
                            "Detail Kendaraan:\n" .
                            "- Nomor Plat     : {$vehicle->plate_number}\n" .
                            "- Pemilik        : {$vehicle->user->name}\n" .
                            "- Merk/Model     : {$vehicle->merk->name} / {$vehicle->model}\n" .
                            "- Tipe Kendaraan : {$vehicle->category->name}\n" .
                            "- Tahun Kendaraan: {$vehicle->year}\n" .
                            "\n" .
                            "Pajak kendaraan Anda akan jatuh tempo pada tanggal **" . date('d-m-Y', strtotime($vehicle->tax_due_date)) . "**.\n" .
                            "Harap segera melakukan pembayaran sebelum tanggal tersebut untuk menghindari denda keterlambatan.\n\n" .
                            "Untuk informasi lebih lanjut atau bantuan, silakan hubungi layanan pelanggan kami.\n\n" .
                            "Hormat kami,\nDinas Pendapatan Daerah Provinsi Kalimantan Selatan.";

                        Notification::create([
                            'vehicle_id' => $vehicle->id,
                            'message' => $message,
                            'notification_date' => now(),
                            'status' => 'sent'
                        ]);

                        // Kirim email melalui Gmail
                        Mail::raw($message, function ($mail) use ($vehicle) {
                            $mail->to($vehicle->user->email)
                                ->subject('Pemberitahuan Pajak Kendaraan Jatuh Tempo');
                        });

                        $this->info('Notifikasi berhasil dikirim ke ' . $vehicle->user->email);
                    } else {
                        $this->error('Pengguna dari kendaraan dengan ID ' . $vehicle->id . ' tidak ditemukan.');
                    }
                } catch (\Exception $e) {
                    Notification::create([
                        'vehicle_id' => $vehicle->id,
                        'message' => 'Gagal mengirim notifikasi ke ' . ($vehicle->user ? $vehicle->user->email : 'User Tidak Ditemukan'),
                        'notification_date' => now(),
                        'status' => 'failed'
                    ]);

                    $this->error('Gagal mengirim notifikasi ke ' . ($vehicle->user ? $vehicle->user->email : 'User Tidak Ditemukan') . '. Error: ' . $e->getMessage());
                }
            }
        } else {
            $this->info('Tidak ada kendaraan yang pajaknya akan jatuh tempo dalam ' . $time->hari . ' hari ke depan.');
        }
    }
}