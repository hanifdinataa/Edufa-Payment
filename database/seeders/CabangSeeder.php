<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Cabang;

class CabangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Cabang::insert([
            ['nama_cabang' => 'CENTRE', 'tipe' => 'CENTRE'],
            ['nama_cabang' => 'HOMEBASE', 'tipe' => 'CABANG'],
            ['nama_cabang' => 'PLA CIMAHI', 'tipe' => 'CABANG'],
            ['nama_cabang' => 'PLA MOJOKERTO', 'tipe' => 'CABANG'],
            ['nama_cabang' => 'PLA LAMPUNG', 'tipe' => 'CABANG'],
            ['nama_cabang' => 'PLA PEKANBARU', 'tipe' => 'CABANG'],
            ['nama_cabang' => 'PLA PADANG', 'tipe' => 'CABANG'],
            ['nama_cabang' => 'PLA BOGOR', 'tipe' => 'CABANG'],
        ]);
    }
}
