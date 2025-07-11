<?php

namespace App\Filament\Admin\Widgets;

use App\Models\BarangKeluar;
use App\Models\BarangMasuk;
use App\Models\Gudang;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class GudangStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Barang', Gudang::count())
                ->description('Jumlah jenis barang di gudang')
                ->descriptionIcon('heroicon-m-cube')
                ->color('primary'),
                
            Stat::make('Total Stok', Gudang::sum('stok'))
                ->description('Total semua stok barang')
                ->descriptionIcon('heroicon-m-archive-box')
                ->color('success'),
                
            Stat::make('Barang Masuk Hari Ini', BarangMasuk::whereDate('tanggal_masuk', today())->sum('jumlah_masuk'))
                ->description('Jumlah barang masuk hari ini')
                ->descriptionIcon('heroicon-m-arrow-down-tray')
                ->color('info'),
                
            Stat::make('Barang Keluar Hari Ini', BarangKeluar::whereDate('tanggal_keluar', today())->sum('jumlah_keluar'))
                ->description('Jumlah barang keluar hari ini')
                ->descriptionIcon('heroicon-m-arrow-up-tray')
                ->color('warning'),
        ];
    }
}