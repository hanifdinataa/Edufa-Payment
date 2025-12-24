<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Invoice extends Model
{
    protected $fillable = [
        'invoice_code',
        'order_id',
        'siswa_id',
        'periode',
        'nominal',
        'tipe',
        'status',
        'paid_at',
        'due_date',
    ];

    protected static function booted()
    {
        static::creating(function ($invoice) {
            if (empty($invoice->invoice_code)) {
                $invoice->invoice_code =
                    'INV-' .
                    now()->format('Ymd') .
                    '-' .
                    strtoupper(Str::random(6));
            }
        });
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function transaksis()
    {
        return $this->hasMany(\App\Models\Transaksi::class);
    }

    public function getTotalPaidAttribute()
    {
        return $this->transaksis()->sum('amount');
    }

    public function getPaymentStatusAttribute()
    {
        if ($this->total_paid == 0) {
            return 'MENUNGGU';
        }

        if ($this->total_paid < $this->nominal) {
            return $this->tipe === 'BULANAN' ? 'BULANAN' : 'DP';
        }

        return 'LUNAS';
    }
}
