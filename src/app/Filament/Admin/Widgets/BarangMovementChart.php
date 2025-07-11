<?php

namespace App\Filament\Admin\Widgets;

use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;

class BarangMovementChart extends ChartWidget
{
    protected static ?string $heading = 'Pergerakan Barang (7 Hari Terakhir)';
    protected static ?string $maxHeight = '300px'; // Atur tinggi maksimal chart

    protected function getData(): array
    {
        // Data barang masuk
        $masukData = Trend::model(BarangMasuk::class)
            ->between(
                start: now()->subDays(7),
                end: now(),
            )
            ->perDay()
            ->sum('jumlah_masuk');
            
        // Data barang keluar
        $keluarData = Trend::model(BarangKeluar::class)
            ->between(
                start: now()->subDays(7),
                end: now(),
            )
            ->perDay()
            ->sum('jumlah_keluar');
            
        return [
            'datasets' => [
                [
                    'label' => 'Barang Masuk',
                    'data' => $masukData->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => '#3b82f6', // Warna biru untuk garis
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)', // Warna area bawah garis
                    'fill' => true, // Mengisi area bawah garis
                    'tension' => 0.3, // Membuat garis lebih smooth
                    'borderWidth' => 2, // Ketebalan garis
                    'pointBackgroundColor' => '#3b82f6', // Warna titik data
                    'pointRadius' => 4, // Ukuran titik data
                ],
                [
                    'label' => 'Barang Keluar',
                    'data' => $keluarData->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => '#ef4444', // Warna merah untuk garis
                    'backgroundColor' => 'rgba(239, 68, 68, 0.1)', // Warna area bawah garis
                    'fill' => true,
                    'tension' => 0.3,
                    'borderWidth' => 2,
                    'pointBackgroundColor' => '#ef4444',
                    'pointRadius' => 4,
                ],
            ],
            'labels' => $masukData->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line'; // Mengubah tipe chart menjadi line
    }

    // Optional: Menambahkan konfigurasi tambahan
    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'title' => [
                        'display' => true,
                        'text' => 'Jumlah Barang',
                    ],
                    'grid' => [
                        'color' => 'rgba(0, 0, 0, 0.05)',
                    ],
                ],
                'x' => [
                    'title' => [
                        'display' => true,
                        'text' => 'Tanggal',
                    ],
                    'grid' => [
                        'display' => false,
                    ],
                ],
            ],
            'plugins' => [
                'legend' => [
                    'position' => 'top',
                    'labels' => [
                        'boxWidth' => 12,
                    ],
                ],
                'tooltip' => [
                    'mode' => 'index',
                    'intersect' => false,
                ],
            ],
            'interaction' => [
                'mode' => 'nearest',
                'axis' => 'x',
                'intersect' => false,
            ],
            'responsive' => true,
            'maintainAspectRatio' => false,
        ];
    }
}