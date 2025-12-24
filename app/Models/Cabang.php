<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cabang extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_cabang',
        'tipe',
    ];

    public function siswas()
    {
        return $this->hasMany(Siswa::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
