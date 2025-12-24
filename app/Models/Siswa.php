<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_anak',
        'no_induk',
        'nama_orangtua',
        'wa',
        'email',
        'cabang_id',
        'jumlah_sesi',
        'keterangan',
    ];

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function cabang()
    {
        return $this->belongsTo(Cabang::class);
    }
}
