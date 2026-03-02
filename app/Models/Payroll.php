<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    protected $fillable = [
        'cabang_id',
        'bulan',
        'tahun',
        'nominal',
    ];

    public function cabang()
    {
        return $this->belongsTo(Cabang::class);
    }
}
?>