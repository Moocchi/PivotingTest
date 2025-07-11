<?php

namespace App\Filament\Admin\Resources\BarangKeluarResource\Pages;

use App\Filament\Admin\Resources\BarangKeluarResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBarangKeluars extends ListRecords
{
    protected static string $resource = BarangKeluarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
