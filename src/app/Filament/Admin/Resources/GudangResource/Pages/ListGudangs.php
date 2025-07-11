<?php

namespace App\Filament\Admin\Resources\GudangResource\Pages;

use App\Filament\Admin\Resources\GudangResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGudangs extends ListRecords
{
    protected static string $resource = GudangResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
