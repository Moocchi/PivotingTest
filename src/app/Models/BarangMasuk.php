<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Gudang;

class BarangMasuk extends Model
{
    protected $table = "barang_masuks";

    protected $fillable = [
        'id_barang',
        'tanggal_masuk',
        'jumlah_masuk',
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
        static::created(function ($barangMasuk) {
            DB::transaction(function () use ($barangMasuk) {
                $barangMasuk->barang->increment('stok', $barangMasuk->jumlah_masuk);
            });
        });

        static::updated(function ($barangMasuk) {
            DB::transaction(function () use ($barangMasuk) {
                $diff = $barangMasuk->jumlah_masuk - $barangMasuk->getOriginal('jumlah_masuk');
                $barangMasuk->barang->increment('stok', $diff);
            });
        });

        static::deleted(function ($barangMasuk) {
            DB::transaction(function () use ($barangMasuk) {
                $barangMasuk->barang->decrement('stok', $barangMasuk->jumlah_masuk);
            });
        });
    }
}
