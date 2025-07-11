<?php

namespace Database\Seeders;

use App\Models\BarangMasuk;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangMasukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BarangMasuk::create([
            'id_barang' => 1,
            'tanggal_masuk' => '2025-05-31',
            'jumlah_masuk' => 50,
        ]);
    }
}
