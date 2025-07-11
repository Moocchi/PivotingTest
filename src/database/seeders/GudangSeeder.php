<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Gudang;

class GudangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            for ($i = 1; $i <= 100; $i++) {
                $jenisBarang = ['Urinal', 'Wc', 'Wastafel'];
                $namaBarang = [
                    'Urinal' => 'Stand Urinal',
                    'Wc' => 'Wc Duduk',
                    'Wastafel' => 'Wastafel'
                ];

                $jenis = $jenisBarang[array_rand($jenisBarang)];
                Gudang::create([
                    'kode_barang' => 'GUD' . str_pad($i, 3, '0', STR_PAD_LEFT),
                    'nama_barang' => $namaBarang[$jenis] . " " . $i,
                    'jenis_barang' => $jenis,
                    'stok' => 100,
                    'satuan' => 'pcs',
                ]);
            }
    }
}
