<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Gudang;

class BarangKeluar extends Model
{
    protected $table = "barang_keluars";

    protected $fillable = [
        'id_barang',
        'tanggal_keluar',
        'jumlah_keluar',
    ];

    public function gudang()
    {
        return $this->belongsTo(Gudang::class, 'kode_barang', 'kode_barang');
    }

    public function barang()
    {
        return $this->belongsTo(Gudang::class, 'id_barang', 'id');
    }

    protected static function booted()
    {
        static::created(function ($barangKeluar) {
            DB::transaction(function () use ($barangKeluar) {
                $barangKeluar->barang->decrement('stok', $barangKeluar->jumlah_keluar);
            });
        });

        static::updated(function ($barangKeluar) {
            DB::transaction(function () use ($barangKeluar) {
                $diff = $barangKeluar->getOriginal('jumlah_keluar') - $barangKeluar->jumlah_keluar;
                $barangKeluar->barang->increment('stok', $diff);
            });
        });

        static::deleted(function ($barangKeluar) {
            DB::transaction(function () use ($barangKeluar) {
                $barangKeluar->barang->increment('stok', $barangKeluar->jumlah_keluar);
            });
        });
    }
}
