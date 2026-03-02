<?php
// app/Http/Controllers/Webhook/MidtransWebhookController.php
namespace App\Http\Controllers\Webhook;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Midtrans\Config;

class MidtransWebhookController extends Controller
{
    public function handle(Request $request)
    {
        // MIDTRANS CONFIG
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');

        $payload = $request->all();

        // VALIDASI SIGNATURE
        $signatureKey = hash(
            'sha512',
            $payload['order_id'] .
            $payload['status_code'] .
            $payload['gross_amount'] .
            config('midtrans.server_key')
        );

        if ($signatureKey !== $payload['signature_key']) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        // Ambil invoice dari order_id
        $invoiceCode = explode('-', $payload['order_id'])[1];

        $invoice = Invoice::with('siswa')
            ->where('invoice_code', $invoiceCode)
            ->first();

        if (!$invoice) {
            return response()->json(['message' => 'Invoice not found'], 404);
        }

        // HANDLE STATUS
        $transactionStatus = $payload['transaction_status'];
        $fraudStatus = $payload['fraud_status'] ?? null;

        if (
            $transactionStatus === 'capture' && $fraudStatus === 'accept' ||
            $transactionStatus === 'settlement'
        ) {
            // ===== PAID =====
            $invoice->update([
                'status' => 'PAID',
                'paid_at' => now(),
            ]);

            // KIRIM WA KONFIRMASI
            $phone = preg_replace('/[^0-9]/', '', $invoice->siswa->wa);
$phone = preg_replace('/^0/', '62', $phone);

            $message =
"Halo Bapak/Ibu {$invoice->siswa->nama_orangtua},

Kami informasikan bahwa pembayaran Edufa telah kami TERIMA dengan detail berikut:

Nama Anak : {$invoice->siswa->nama_anak}
Periode   : {$invoice->periode}
Nominal   : Rp " . number_format($invoice->nominal) . "

Terima kasih atas kepercayaan dan kerja samanya.

Hormat kami,
Edufa";

            try {
                WhatsAppService::send($phone, $message);
            } catch (\Exception $e) {
                // WA gagal tidak menggagalkan payment
            }

        } elseif (in_array($transactionStatus, ['expire', 'cancel', 'deny'])) {
            // ===== FAILED / EXPIRED =====
            $invoice->update([
                'status' => strtoupper($transactionStatus),
            ]);
        }

        return response()->json(['message' => 'OK']);
    }
}
