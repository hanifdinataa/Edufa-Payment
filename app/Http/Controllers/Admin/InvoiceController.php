<?php
// app/Http/Controllers/Admin/InvoiceController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Siswa;
use App\Models\Transaksi;
use App\Services\MidtransService;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with('siswa')
            ->whereHas('siswa', function ($q) {
                $q->where('cabang_id', Auth::user()->cabang_id);
            })
            ->latest()
            ->get();

        return view('admin.invoice.index', compact('invoices'));
    }

    public function create()
    {
        $siswas = Siswa::where('cabang_id', Auth::user()->cabang_id)->get();
        return view('admin.invoice.create', compact('siswas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required',
            'nominal'  => 'required|numeric',
            'tipe'     => 'required',
            'periode'  => 'required',
            'due_date' => 'required|date',
        ]);

        Invoice::create([
            'siswa_id' => $request->siswa_id,
            'nominal'  => $request->nominal,
            'tipe'     => $request->tipe,
            'periode'  => $request->periode,
            'due_date' => $request->due_date,
            'status'   => 'UNPAID',
        ]);

        return redirect()
            ->route('admin.invoice.index')
            ->with('success', 'Invoice berhasil dibuat');
    }

    public function edit(Invoice $invoice)
    {
        if ($invoice->status !== 'UNPAID') {
            return redirect()
                ->route('admin.invoice.index')
                ->with('error', 'Invoice dengan status ' . $invoice->status . ' tidak dapat diedit.');
        }

        $siswas = Siswa::where('cabang_id', auth()->user()->cabang_id)->get();

        return view('admin.invoice.edit', compact('invoice', 'siswas'));
    }


    public function update(Request $request, Invoice $invoice)
    {
        if ($invoice->status !== 'UNPAID') {
            return redirect()
                ->route('admin.invoice.index')
                ->with('error', 'Invoice dengan status ' . $invoice->status . ' tidak dapat diubah.');
        }

        $request->validate([
            'siswa_id' => 'required',
            'nominal'  => 'required|numeric',
            'tipe'     => 'required',
            'periode'  => 'required',
            'due_date' => 'required|date',
        ]);

        $invoice->update($request->only([
            'siswa_id',
            'nominal',
            'tipe',
            'periode',
            'due_date',
        ]));

        return redirect()
            ->route('admin.invoice.index')
            ->with('success', 'Invoice berhasil diperbarui.');
    }


    /* ================= DELETE ================= */

    public function destroy(Invoice $invoice)
    {
        if ($invoice->status !== 'UNPAID') {
            abort(403, 'Invoice tidak dapat dihapus');
        }

        $invoice->delete();

        return redirect()
            ->route('admin.invoice.index')
            ->with('success', 'Invoice berhasil dihapus');
    }

    public function show(Invoice $invoice)
    {
        $invoice->load('siswa');
        return view('admin.invoice.show', compact('invoice'));
    }

    /**
     * KIRIM WHATSAPP TAGIHAN
     */
    public function sendWA(Invoice $invoice)
    {
        $invoice->load('siswa');

        if (!$invoice->siswa || !$invoice->siswa->wa) {
            return back()->with('error', 'Nomor WhatsApp tidak tersedia');
        }

        $phone = preg_replace('/[^0-9]/', '', $invoice->siswa->wa);
        $phone = preg_replace('/^0/', '62', $phone);

        // 🔥 INI YANG PALING PENTING
        $paymentLink = route('payment.show', $invoice->invoice_code);

        $message =
            "Halo Bapak/Ibu {$invoice->siswa->nama_orangtua},

Kami informasikan bahwa terdapat tagihan pembayaran Edufa untuk:

Nama Anak : {$invoice->siswa->nama_anak}
Invoice   : {$invoice->invoice_code}
Nominal   : Rp " . number_format($invoice->nominal) . "

Untuk melakukan pembayaran, silakan klik tautan berikut:

{$paymentLink}

Terima kasih atas perhatian dan kerja samanya.

Hormat kami,
Edufa";

        WhatsAppService::send($phone, $message);

        return back()->with('success', 'WhatsApp tagihan berhasil dikirim');
    }


    /**
     * REMINDER MANUAL
     */
    public function reminder(Invoice $invoice)
    {
        $invoice->load('siswa');

        if ($invoice->status !== 'UNPAID') {
            return back()->with('error', 'Invoice sudah lunas');
        }

        if (!$invoice->siswa || !$invoice->siswa->wa) {
            return back()->with('error', 'Nomor WhatsApp tidak tersedia');
        }

        $phone = preg_replace('/[^0-9]/', '', $invoice->siswa->wa);
        $phone = preg_replace('/^0/', '62', $phone);
        $paymentLink = route('invoice.pay', $invoice->invoice_code);

        $message =
            "Halo Bapak/Ibu {$invoice->siswa->nama_orangtua},

Kami ingin mengingatkan kembali terkait pembayaran Edufa untuk:

Nama Anak : {$invoice->siswa->nama_anak}
Periode   : {$invoice->periode}
Nominal   : Rp " . number_format($invoice->nominal) . "

Hingga saat ini, pembayaran tersebut belum kami terima.

Untuk kemudahan pembayaran, silakan menggunakan tautan berikut:
{$paymentLink}

Kami mohon kesediaan Bapak/Ibu untuk segera melakukan pembayaran.

Terima kasih atas perhatian dan kerja samanya.

Hormat kami,
Edufa";

        try {
            WhatsAppService::send($phone, $message);
        } catch (\Exception $e) {
            return back()->with('error', 'Reminder gagal dikirim: ' . $e->getMessage());
        }

        return back()->with('success', 'Reminder WhatsApp berhasil dikirim');
    }

    public function addTransaksi(Request $request, Invoice $invoice)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1'
        ]);

        Transaksi::create([
            'order_id' => 'MANUAL-' . uniqid(),
            'invoice_id' => $invoice->id,
            'amount' => $request->amount,
            'status_midtrans' => 'manual',
            'metode' => 'admin',
            'paid_at' => now(),
        ]);

        return back()->with('success', 'Pembayaran berhasil dicatat');
    }
}
