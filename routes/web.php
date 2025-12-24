<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Centre\CentreDashboardController;
use App\Http\Controllers\Centre\CentreReportController;
use App\Http\Controllers\Frontend\PaymentController;

Route::post(
    '/admin/invoice/{invoice}/transaksi',
    [InvoiceController::class, 'addTransaksi']
)->name('admin.invoice.transaksi');
/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => redirect('/login'));

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
// Route::get('/pay/{invoice_code}', [PaymentController::class, 'show'])
//     ->name('payment.show');
// use App\Http\Controllers\Frontend\PaymentController;

Route::get('/pay/{invoice_code}', [PaymentController::class, 'show'])
    ->name('payment.show');

Route::post('/pay/{invoice_code}', [PaymentController::class, 'pay'])
    ->name('payment.pay');


use App\Http\Controllers\Webhook\MidtransWebhookController;

Route::post('/webhook/midtrans', [MidtransWebhookController::class, 'handle'])
    ->name('webhook.midtrans');

    Route::post('/_dev/force-paid/{invoiceCode}', [PaymentController::class, 'forcePaid']);

/*
|--------------------------------------------------------------------------
| ADMIN CABANG
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])
        ->name('dashboard');

    Route::resource('siswa', SiswaController::class);

    Route::resource('invoice', InvoiceController::class)
        ->except(['show']);

    Route::post(
        'invoice/{invoice}/send-wa',
        [InvoiceController::class, 'sendWA']
    )->name('invoice.send-wa');

    Route::post(
        'invoice/{invoice}/reminder',
        [InvoiceController::class, 'reminder']
    )->name('invoice.reminder');
});

/*
|--------------------------------------------------------------------------
| CENTRE
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:CENTRE'])
    ->prefix('centre')
    ->name('centre.')
    ->group(function () {

        Route::get('/dashboard', [CentreDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/laporan', [CentreReportController::class, 'index'])
            ->name('laporan.index');

        Route::get('/laporan/{cabang}', [CentreReportController::class, 'detail'])
            ->name('laporan.detail');
    });

//     Route::get('/pay/{invoice_code}', [PaymentController::class, 'show'])
//     ->name('payment.show');

// Route::post('/pay/{invoice_code}', [PaymentController::class, 'pay'])
//     ->name('payment.pay');
