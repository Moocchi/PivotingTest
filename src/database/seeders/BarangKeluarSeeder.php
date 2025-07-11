<?php

namespace Database\Seeders;

use App\Models\BarangKeluar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class BarangKeluarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BarangKeluar::create([
            'id_barang' => 1,
            'tanggal_keluar' => '2025-05-31',
            'jumlah_keluar' => 20,
        ]);
    }
}
