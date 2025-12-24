<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Cabang;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // =========================
        // CENTRE
        // =========================
        $centre = Cabang::where('tipe', 'CENTRE')->first();

        User::updateOrCreate(
            ['email' => 'centre@gmail.com'],
            [
                'name'      => 'Admin Centre',
                'password'  => Hash::make('centre123'),
                'role'      => 'CENTRE',
                'cabang_id' => $centre->id,
            ]
        );

        // =========================
        // ADMIN CABANG
        // =========================
        $cabangs = [
            'HOMEBASE' => 'admin@gmail.com',
            'PLA CIMAHI' => 'cimahi@gmail.com',
            'PLA MOJOKERTO' => 'mojokerto@gmail.com',
            'PLA LAMPUNG' => 'lampung@gmail.com',
            'PLA PEKANBARU' => 'pekanbaru@gmail.com',
            'PLA PADANG' => 'padang@gmail.com',
            'PLA BOGOR' => 'bogor@gmail.com',
        ];

        foreach ($cabangs as $namaCabang => $email) {
            $cabang = Cabang::where('nama_cabang', $namaCabang)->first();

            if (!$cabang) {
                continue; // kalau cabang belum ada, skip biar tidak error
            }

            User::updateOrCreate(
                ['email' => $email],
                [
                    'name'      => 'Admin ' . $namaCabang,
                    'password'  => Hash::make('admin123'),
                    'role'      => 'CABANG',
                    'cabang_id' => $cabang->id,
                ]
            );
        }
    }
}
