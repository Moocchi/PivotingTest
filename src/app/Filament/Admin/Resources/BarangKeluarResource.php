<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\BarangKeluarResource\Pages;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Collection;
use Filament\Notifications\Notification;
use App\Filament\Admin\Resources\BarangKeluarResource\RelationManagers;
use App\Models\BarangKeluar;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Gudang;

class BarangKeluarResource extends Resource
{
    protected static ?string $model = BarangKeluar::class;
    protected static ?string $navigationGroup = 'Control';
    protected static ?string $navigationLabel = 'Barang Keluar';
    protected static ?int $navigationSort = -3;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('id_barang')
                    ->numeric()
                    ->reactive()
                    ->afterStateUpdated(fn($state, $set) => $set('kode_barang', Gudang::where('id', $state)->value('kode_barang') ?? 'barang tidak ditemukan'))
                    ->afterStateUpdated(fn($state, $set) => $set('nama_barang', Gudang::where('id', $state)->value('nama_barang') ?? 'barang tidak ditemukan'))
                    ->afterStateUpdated(fn($state, $set) => $set('jenis_barang', Gudang::where('id', $state)->value('jenis_barang') ?? 'barang tidak ditemukan'))
                    ->afterStateUpdated(fn($state, $set) => $set('stok', Gudang::where('id', $state)->value('stok') ?? 'barang tidak ditemukan')),
                Forms\Components\DateTimePicker::make('tanggal_keluar')
                    ->default(now())
                    ->disabled()
                    ->withoutSeconds()
                    ->dehydrated(true),
                Forms\Components\TextInput::make('jumlah_keluar')
                    ->required()
                    ->numeric()
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        $idBarang = $get('id_barang'); // use id_barang to fetch the Gudang model
                        $gudang = Gudang::find($idBarang);
                
                        if ($gudang && $state > $gudang->stok) {
                            Notification::make()
                                ->title('Jumlah Keluar lebih besar dari stok!')
                                ->danger()
                                ->persistent()
                                ->send();
                
                            $set('jumlah_keluar', null); // clear the input or handle as needed
                        }
                    }),
                Forms\Components\Fieldset::make('Detail Barang')
                    ->schema([
                        Forms\Components\TextInput::make('kode_barang')
                            ->disabled()
                            ->reactive()
                            ->afterStateHydrated(fn($state, $set, $get) =>
                                $set('kode_barang', Gudang::where('id', $get('id_barang'))->value('kode_barang') ?? 'barang tidak ditemukan')),
                        Forms\Components\TextInput::make('nama_barang')
                            ->disabled()
                            ->reactive()
                            ->afterStateHydrated(fn($state, $set, $get) =>
                                $set('nama_barang', Gudang::where('id', $get('id_barang'))->value('nama_barang') ?? 'barang tidak ditemukan')),
                        Forms\Components\TextInput::make('jenis_barang')
                            ->disabled()
                            ->reactive()
                            ->afterStateHydrated(fn($state, $set, $get) =>
                                $set('jenis_barang', Gudang::where('id', $get('id_barang'))->value('jenis_barang') ?? 'barang tidak ditemukan')),
                        Forms\Components\TextInput::make('stok')
                            ->disabled()
                            ->reactive()
                            ->afterStateHydrated(fn($state, $set, $get) =>
                                $set('stok', Gudang::where('id', $get('id_barang'))->value('stok') ?? 'barang tidak ditemukan')),
                    ])
                    ->columnSpan('full'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable(),
                Tables\Columns\TextColumn::make('id_barang')
                    ->numeric()
                    ->sortable(),
                
                    Tables\Columns\TextColumn::make('kode_barang')
                    ->label('Kode Barang')
                    ->getStateUsing(fn($record) => Gudang::where('id', $record->id_barang)->value('kode_barang') ?? 'barang tidak ditemukan'),
                Tables\Columns\TextColumn::make('nama_barang')
                    ->label('Nama Barang')
                    ->getStateUsing(fn($record) => Gudang::where('id', $record->id_barang)->value('nama_barang') ?? 'barang tidak ditemukan'),
                Tables\Columns\TextColumn::make('jenis_barang')
                    ->label('Jenis Barang')
                    ->getStateUsing(fn($record) => Gudang::where('id', $record->id_barang)->value('jenis_barang') ?? 'barang tidak ditemukan'),
                
                    Tables\Columns\TextColumn::make('tanggal_keluar')
                    ->dateTime('M d, Y h:i A')
                    ->sortable(),
                Tables\Columns\TextColumn::make('jumlah_keluar')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('pdf')
                    ->label('Download PDF')
                    ->color('success')
                    ->openUrlInNewTab()
                    ->icon('heroicon-o-arrow-down-on-square')
                    ->action(function (BarangKeluar $record) {
                        return response()->streamDownload(function () use ($record) {
                            echo Pdf::loadHtml(
                                Blade::render('livewire.pdf-satuan-keluar', [
                                    'record' => $record,
                                    'kode_barang' => Gudang::where('id', $record->id_barang)->value('kode_barang') ?? 'N/A',
                                    'nama_barang' => Gudang::where('id', $record->id_barang)->value('nama_barang') ?? 'N/A',
                                    'jenis_barang' => Gudang::where('id', $record->id_barang)->value('jenis_barang') ?? 'N/A',
                                    
                                ])
                            )->stream();
                        }, 'Invoice Barang Keluar  - ' . $record->kode_barang . '.pdf');
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('Export pdf')
                        ->icon('heroicon-m-arrow-down-tray')
                        ->openUrlInNewTab()
                        ->color('success')  
                        ->deselectRecordsAfterCompletion()
                        ->action(function (Collection $records) {
                            return response()->streamDownload(function () use ($records) {
                                echo Pdf::loadHTML(
                                    Blade::render('livewire.pdf-bulk-keluar', [
                                        'records' => $records,
                                        'kode_barang' => $records->map(fn($record) => Gudang::where('id', $record->id_barang)->value('kode_barang') ?? 'barang tidak ditemukan'),
                                        'nama_barang' => $records->map(fn($record) => Gudang::where('id', $record->id_barang)->value('nama_barang') ?? 'barang tidak ditemukan'),
                                        'jenis_barang' => $records->map(fn($record) => Gudang::where('id', $record->id_barang)->value('jenis_barang') ?? 'barang tidak ditemukan'),])
                                )->stream();
                            }, name: 'Invoice - Barang Keluar.pdf');
                        }),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBarangKeluars::route('/'),
            'create' => Pages\CreateBarangKeluar::route('/create'),
            'edit' => Pages\EditBarangKeluar::route('/{record}/edit'),
        ];
    }
}
