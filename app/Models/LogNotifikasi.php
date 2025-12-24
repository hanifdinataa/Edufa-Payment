<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogNotifikasi extends Model
{
    protected $table = 'log_notifikasis'; // sesuaikan kalau beda

    protected $fillable = [
        'invoice_id',
        'tipe',
        'status',
        'waktu',
    ];

    public $timestamps = false; // karena kamu pakai kolom 'waktu'
}
