<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TaxPayment;
use App\Models\Vehicle;
use App\Models\Notification;
use App\Models\User;
use Dompdf\Dompdf;
use Dompdf\Options;

class ReportController extends Controller
{
    /**
     * Laporan Pembayaran Pajak
     */
    public function paymentReport(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $payments = \DB::table('tax_payments')
            ->join('vehicles', 'tax_payments.vehicle_id', '=', 'vehicles.id')
            ->join('users', 'vehicles.user_id', '=', 'users.id')
            ->select(
                'tax_payments.*',
                'vehicles.plate_number',
                'users.name as user_name'
            )
            ->where('users.role', 'pelanggan')
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                $query->whereBetween('tax_payments.payment_date', [$startDate, $endDate]);
            })
            ->orderBy('tax_payments.payment_date', 'desc')
            ->get();

        return view('reports.payments', compact('payments', 'startDate', 'endDate'));
    }

    public function exportPaymentPDF(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $payments = \DB::table('tax_payments')
            ->join('vehicles', 'tax_payments.vehicle_id', '=', 'vehicles.id')
            ->join('users', 'vehicles.user_id', '=', 'users.id')
            ->select(
                'tax_payments.*',
                'vehicles.plate_number',
                'users.name as user_name'
            )
            ->where('users.role', 'pelanggan')
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                $query->whereBetween('tax_payments.payment_date', [$startDate, $endDate]);
            })
            ->orderBy('tax_payments.payment_date', 'desc')
            ->get();

        $html = view('pdf.pdf_payments', compact('payments', 'startDate', 'endDate'))->render();

        $options = new Options();
        $options->set('isRemoteEnabled', true);  // Izinkan akses URL eksternal
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landsportraitcape');
        $dompdf->render();
        return $dompdf->stream('laporan_pembayaran.pdf', ['Attachment' => false]);
    }

    /**
     * Laporan Kendaraan
     */
    public function vehicleReport(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $vehicles = \DB::table('vehicles')
            ->join('users', 'vehicles.user_id', '=', 'users.id')
            ->join('categories', 'vehicles.category_id', '=', 'categories.id')
            ->join('merk', 'vehicles.merk_id', '=', 'merk.id')
            ->select(
                'vehicles.*',
                'users.name as user_name',
                'categories.name as category_name',
                'merk.name as merk_name'
            )
            ->where('users.role', 'pelanggan')
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                $query->whereBetween('vehicles.created_at', [$startDate, $endDate]);
            })
            ->orderBy('vehicles.created_at', 'desc')
            ->get();

        return view('reports.vehicles', compact('vehicles', 'startDate', 'endDate'));
    }

    public function exportVehiclePDF(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $vehicles = \DB::table('vehicles')
            ->join('users', 'vehicles.user_id', '=', 'users.id')
            ->join('categories', 'vehicles.category_id', '=', 'categories.id')
            ->join('merk', 'vehicles.merk_id', '=', 'merk.id')
            ->select(
                'vehicles.*',
                'users.name as user_name',
                'categories.name as category_name',
                'merk.name as merk_name'
            )
            ->where('users.role', 'pelanggan')
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                $query->whereBetween('vehicles.created_at', [$startDate, $endDate]);
            })
            ->orderBy('vehicles.created_at', 'desc')
            ->get();

        $html = view('pdf.pdf_vehicles', compact('vehicles', 'startDate', 'endDate'))->render();

        $options = new Options();
        $options->set('isRemoteEnabled', true);  // Izinkan akses URL eksternal
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        
        return $dompdf->stream('laporan_kendaraan.pdf', ['Attachment' => false]);
    }

    /**
     * Laporan Peringatan
     */
    public function notificationReport(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $notifications = \DB::table('notifications')
            ->join('vehicles', 'notifications.vehicle_id', '=', 'vehicles.id')
            ->select(
                'notifications.*',
                'vehicles.plate_number'
            )
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                $query->whereBetween('notifications.notification_date', [$startDate, $endDate]);
            })
            ->orderBy('notifications.notification_date', 'desc')
            ->get();

        return view('reports.notifications', compact('notifications', 'startDate', 'endDate'));
    }

    public function exportNotificationPDF(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $notifications = \DB::table('notifications')
            ->join('vehicles', 'notifications.vehicle_id', '=', 'vehicles.id')
            ->select(
                'notifications.*',
                'vehicles.plate_number'
            )
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                $query->whereBetween('notifications.notification_date', [$startDate, $endDate]);
            })
            ->orderBy('notifications.notification_date', 'desc')
            ->get();

        $html = view('pdf.pdf_notifications', compact('notifications', 'startDate', 'endDate'))->render();

        $options = new Options();
        $options->set('isRemoteEnabled', true);  // Izinkan akses URL eksternal
        
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf->stream('laporan_notifikasi.pdf', ['Attachment' => false]);
    }

    /**
     * Laporan Keterlambatan Pembayaran
     */
    public function latePaymentReport(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $latePayments = \DB::table('vehicles')
            ->leftJoin('tax_payments', function ($join) {
                $join->on('vehicles.id', '=', 'tax_payments.vehicle_id')
                    ->where('tax_payments.payment_status', '=', 'success');
            })
            ->join('users', 'vehicles.user_id', '=', 'users.id')
            ->select(
                'vehicles.plate_number',
                'users.name as user_name',
                'vehicles.tax_due_date',
                \DB::raw('DATEDIFF(CURDATE(), vehicles.tax_due_date) as days_late'),
                'tax_payments.payment_date',
                'tax_payments.payment_amount',
                'tax_payments.payment_status'
            )
            ->whereNull('tax_payments.payment_date')
            ->where('users.role', 'pelanggan')
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                $query->whereBetween('vehicles.tax_due_date', [$startDate, $endDate]);
            })
            ->where('vehicles.tax_due_date', '<', now())
            ->orderBy('vehicles.tax_due_date', 'desc')
            ->get();

        return view('reports.late-payments', compact('latePayments', 'startDate', 'endDate'));
    }

    public function exportLatePaymentPDF(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $latePayments = \DB::table('vehicles')
            ->leftJoin('tax_payments', function ($join) {
                $join->on('vehicles.id', '=', 'tax_payments.vehicle_id')
                    ->where('tax_payments.payment_status', '=', 'success');
            })
            ->join('users', 'vehicles.user_id', '=', 'users.id')
            ->select(
                'vehicles.plate_number',
                'users.name as user_name',
                'vehicles.tax_due_date',
                \DB::raw('DATEDIFF(CURDATE(), vehicles.tax_due_date) as days_late'),
                'tax_payments.payment_date',
                'tax_payments.payment_amount',
                'tax_payments.payment_status'
            )
            ->whereNull('tax_payments.payment_date')
            ->where('users.role', 'pelanggan')
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                $query->whereBetween('vehicles.tax_due_date', [$startDate, $endDate]);
            })
            ->where('vehicles.tax_due_date', '<', now())
            ->orderBy('vehicles.tax_due_date', 'desc')
            ->get();

        $html = view('pdf.pdf_late_payments', compact('latePayments', 'startDate', 'endDate'))->render();

        $options = new Options();
        $options->set('isRemoteEnabled', true); 
        
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf->stream('laporan_tunggakan_pajak.pdf', ['Attachment' => false]);
    }

    /**
     * Laporan Aktivitas Pengguna
     */
    public function userActivityReport(Request $request)
    {
        $activities = \DB::table('activity_log')
            ->when($request->user_id, function ($query) use ($request) {
                $query->where('causer_id', $request->user_id);
            })
            ->when($request->start_date && $request->end_date, function ($query) use ($request) {
                $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $users = User::all();
        return view('reports.user-activities', compact('activities', 'users'));
    }

    public function revenueReport(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        // Query untuk mendapatkan data laporan
        $revenues = \DB::table('tax_payments')
            ->join('vehicles', 'tax_payments.vehicle_id', '=', 'vehicles.id')
            ->join('users', 'vehicles.user_id', '=', 'users.id')
            ->join('categories', 'vehicles.category_id', '=', 'categories.id')
            ->join('merk', 'vehicles.merk_id', '=', 'merk.id')
            ->selectRaw("DATE_FORMAT(tax_payments.payment_date, '%Y-%m') as periode")
            ->selectRaw("DATE_FORMAT(tax_payments.payment_date, '%M %Y') as bulan_tahun")
            ->select(
                'users.name as pemilik',
                'vehicles.plate_number',
                'merk.name as merk',
                'vehicles.model',
                'categories.name as kategori',
                'tax_payments.payment_amount'
            )
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                $query->whereBetween('tax_payments.payment_date', [$startDate, $endDate]);
            })
            ->orderBy(\DB::raw("DATE_FORMAT(tax_payments.payment_date, '%Y-%m')"), 'desc')
            ->get();

        // Hitung Grand Total Pendapatan dan Jumlah Kendaraan
        $grandTotal = $revenues->sum('payment_amount');
        $totalKendaraan = $revenues->count();  // Hitung jumlah kendaraan

        return view('reports.revenue', compact('revenues', 'startDate', 'endDate', 'grandTotal', 'totalKendaraan'));
    }

    public function exportRevenuePDF(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $revenues = \DB::table('tax_payments')
            ->join('vehicles', 'tax_payments.vehicle_id', '=', 'vehicles.id')
            ->join('users', 'vehicles.user_id', '=', 'users.id')
            ->join('categories', 'vehicles.category_id', '=', 'categories.id')
            ->join('merk', 'vehicles.merk_id', '=', 'merk.id')
            ->selectRaw("DATE_FORMAT(tax_payments.payment_date, '%Y-%m') as periode")
            ->selectRaw("DATE_FORMAT(tax_payments.payment_date, '%M %Y') as bulan_tahun")
            ->select(
                'users.name as pemilik',
                'vehicles.plate_number',
                'merk.name as merk',
                'vehicles.model',
                'categories.name as kategori',
                'tax_payments.payment_amount'
            )
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                $query->whereBetween('tax_payments.payment_date', [$startDate, $endDate]);
            })
            ->orderBy(\DB::raw("DATE_FORMAT(tax_payments.payment_date, '%Y-%m')"), 'desc')
            ->get();

        $grandTotal = $revenues->sum('payment_amount');
        $totalKendaraan = $revenues->count();

        $html = view('pdf.pdf_revenue', compact('revenues', 'startDate', 'endDate', 'grandTotal', 'totalKendaraan'))->render();

        $options = new Options();
        $options->set('isRemoteEnabled', true); 
        
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf->stream('laporan_pendapatan.pdf', ['Attachment' => false]);
    }

}