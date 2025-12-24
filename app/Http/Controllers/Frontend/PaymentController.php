<?php
// app/Http/Controllers/Frontend/PaymentController.php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;

class PaymentController extends Controller
{
    /**
     * =====================================================
     * HALAMAN INVOICE PUBLIK
     * URL: /pay/{invoice_code}
     * =====================================================
     */
    public function show(string $invoice_code)
    {
        $invoice = Invoice::with('siswa')
            ->where('invoice_code', $invoice_code)
            ->first();

        // JIKA INVOICE TIDAK DITEMUKAN
        if (!$invoice) {
            return response()
                ->view('payment.not-found', [], 404);
        }

        return view('payment.show', compact('invoice'));
    }

    /**
     * =====================================================
     * PROSES BAYAR (MIDTRANS)
     * =====================================================
     */
    public function pay(string $invoice_code)
    {
        $invoice = Invoice::with('siswa')
            ->where('invoice_code', $invoice_code)
            ->first();

        // JIKA INVOICE TIDAK DITEMUKAN
        if (!$invoice) {
            return response()
                ->view('payment.not-found', [], 404);
        }

        // JIKA SUDAH DIBAYAR
        if ($invoice->status === 'PAID') {
            return response()
                ->view('payment.already-paid', compact('invoice'), 403);
        }

        /**
         * =====================
         * MIDTRANS CONFIG
         * =====================
         */
        Config::$serverKey     = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized  = true;
        Config::$is3ds        = true;

        // ORDER ID UNIK (WAJIB, TIDAK BOLEH DUPLIKAT)
        $orderId = $invoice->invoice_code . '-' . time();

        $params = [
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => (int) $invoice->nominal,
            ],
            'customer_details' => [
                'first_name' => $invoice->siswa->nama_orangtua ?? $invoice->siswa->nama_anak,
                'phone'      => $invoice->siswa->wa,
            ],
            'item_details' => [
                [
                    'id'       => $invoice->invoice_code,
                    'price'    => (int) $invoice->nominal,
                    'quantity' => 1,
                    'name'     => 'Tagihan Edufa ' . $invoice->periode,
                ],
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        // UPDATE STATUS → PENDING
        $invoice->update([
            'order_id' => $orderId,
            'status'   => 'PENDING',
        ]);

        return view('payment.pay', compact('invoice', 'snapToken'));
    }

    /**
     * =====================================================
     * DEV ONLY - FORCE PAID
     * =====================================================
     */
    public function forcePaid(string $invoice_code)
    {
        $invoice = Invoice::where('invoice_code', $invoice_code)->first();

        if (!$invoice) {
            return response()
                ->view('payment.not-found', [], 404);
        }

        $invoice->update([
            'status'  => 'PAID',
            'paid_at'=> now(),
        ]);

        return back()->with('success', 'Invoice berhasil ditandai LUNAS (DEV)');
    }
}
