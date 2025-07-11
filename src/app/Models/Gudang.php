<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gudang extends Model
{   
    protected $table = "gudangs";

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'jenis_barang',
        'stok',
        'satuan'
    ];

    
}
