<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Region;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\RegionResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\RegionResource\RelationManagers;
use Filament\Tables\Columns\TextColumn;

class RegionResource extends Resource
{
    protected static ?string $model = Region::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $navigationLabel = 'Regiones';

    protected static ?string $pluralModelLabel = 'Regiones';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationGroup = 'Configuración Global';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        TextInput::make('name')
                        ->required()
                        ->label('Región')
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('Nro.'),
                TextColumn::make('name')->sortable()->searchable()
                    ->label('Regiones'),
                TextColumn::make('created_at')
                    ->label('Fecha de Registro')
                    ->dateTime(),


            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListRegions::route('/'),
            'create' => Pages\CreateRegion::route('/create'),
            'edit' => Pages\EditRegion::route('/{record}/edit'),
        ];
    }
}
