<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaxPaymentController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\MerkController;
use App\Http\Controllers\TimeController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::controller(AuthController::class)->group(function () {
	Route::get('register', 'register')->name('register');
	Route::post('register', 'registerSimpan')->name('register.simpan');

	Route::get('/', 'login')->name('login');
	Route::post('login', 'loginAksi')->name('login.aksi');

	Route::get('logout', 'logout')->middleware('auth')->name('logout');
});

Route::middleware('auth')->group(function () {
	Route::get('dashboard', function () {
		return view('dashboard');
	})->name('dashboard');

	Route::controller(VehicleController::class)->prefix('vehicle')->group(function () {
		Route::get('', 'index')->name('vehicle');
		Route::get('tambah', 'create')->name('vehicle.tambah');
		Route::post('tambah', 'store')->name('vehicle.tambah.simpan');
		Route::get('edit/{id}', 'edit')->name('vehicle.edit');
		Route::post('edit/{id}', 'update')->name('vehicle.update');
		Route::get('hapus/{id}', 'destroy')->name('vehicle.hapus');
	});

	Route::controller(UserController::class)->prefix('user')->group(function () {
		Route::get('', 'index')->name('user');
		Route::get('tambah', 'create')->name('user.tambah');
		Route::post('tambah', 'store')->name('user.tambah.simpan');
		Route::get('edit/{id}', 'edit')->name('user.edit');
		Route::post('edit/{id}', 'update')->name('user.update');
		Route::get('hapus/{id}', 'destroy')->name('user.hapus');
	});

	Route::controller(UserController::class)->prefix('pelanggan')->group(function () {
		Route::get('', 'index_pelanggan')->name('pelanggan');
		Route::get('tambah', 'create_pelanggan')->name('pelanggan.tambah');
		Route::post('tambah', 'store_pelanggan')->name('pelanggan.tambah.simpan');
		Route::get('edit/{id}', 'edit_pelanggan')->name('pelanggan.edit');
		Route::post('edit/{id}', 'update_pelanggan')->name('pelanggan.update');
		Route::get('hapus/{id}', 'destroy_pelanggan')->name('pelanggan.hapus');
	});

	Route::controller(TaxPaymentController::class)->prefix('tax_payment')->group(function () {
		Route::get('', 'index')->name('tax_payment');
		Route::get('tambah', 'create')->name('tax_payment.tambah');
		Route::post('tambah', 'store')->name('tax_payment.tambah.simpan');
		Route::get('edit/{id}', 'edit')->name('tax_payment.edit');
		Route::post('edit/{id}', 'update')->name('tax_payment.update');
		Route::get('hapus/{id}', 'destroy')->name('tax_payment.hapus');
	});

	Route::controller(KategoriController::class)->prefix('kategori')->group(function () {
		Route::get('', 'index')->name('kategori');
		Route::get('tambah', 'create')->name('kategori.tambah');
		Route::post('tambah', 'store')->name('kategori.tambah.simpan');
		Route::get('edit/{id}', 'edit')->name('kategori.edit');
		Route::post('edit/{id}', 'update')->name('kategori.update');
		Route::get('hapus/{id}', 'destroy')->name('kategori.hapus');
	});

	Route::controller(TimeController::class)->prefix('time')->group(function () {
		Route::get('', 'index')->name('time');
		Route::get('edit/{id}', 'edit')->name('time.edit');
		Route::post('edit/{id}', 'update')->name('time.update');
	});

	Route::controller(MerkController::class)->prefix('merk')->group(function () {
		Route::get('', 'index')->name('merk');
		Route::get('tambah', 'create')->name('merk.tambah');
		Route::post('tambah', 'store')->name('merk.tambah.simpan');
		Route::get('edit/{id}', 'edit')->name('merk.edit');
		Route::post('edit/{id}', 'update')->name('merk.update');
		Route::get('hapus/{id}', 'destroy')->name('merk.hapus');
	});

	Route::prefix('reports')->group(function () {
		Route::get('/reports/payments', [ReportController::class, 'paymentReport'])->name('reports.payments');
		Route::get('/reports/vehicles', [ReportController::class, 'vehicleReport'])->name('reports.vehicles');
		Route::get('/reports/notifications', [ReportController::class, 'notificationReport'])->name('reports.notifications');
		Route::get('/reports/late-payments', [ReportController::class, 'latePaymentReport'])->name('reports.late-payments');
		Route::get('/reports/revenue', [ReportController::class, 'revenueReport'])->name('reports.revenue');

		// Route::get('/user-activities', [ReportController::class, 'userActivityReport'])->name('reports.user-activities');

		// pdf
		Route::get('/export-payments', [ReportController::class, 'exportPaymentPDF'])->name('reports.export-payments');
		Route::get('/reports/vehicles/export', [ReportController::class, 'exportVehiclePDF'])->name('reports.vehicles.export');
		Route::get('/reports/notifications/export', [ReportController::class, 'exportNotificationPDF'])->name('reports.notifications.export');
		Route::get('/reports/late-payments/export', [ReportController::class, 'exportLatePaymentPDF'])->name('reports.late-payments.export');
		Route::get('/reports/revenue/export', [ReportController::class, 'exportRevenuePDF'])->name('reports.revenue.export');
	});


});
