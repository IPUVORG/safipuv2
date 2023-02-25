<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\District;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\DistrictResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\DistrictResource\RelationManagers;

class DistrictResource extends Resource
{
    protected static ?string $model = District::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $navigationLabel = 'Distritos';

    protected static ?string $pluralModelLabel = 'Distritos';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationGroup = 'Configuración Global';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Select::make('region_id')
                            ->relationship('region', 'name')
                            ->placeholder('Seleccione una Región')
                            ->label('Región'),
                        TextInput::make('name')
                            ->required()
                            ->label('Distrito')
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('Nro.'),
                TextColumn::make('region.name')->sortable()->searchable()
                    ->label('Regiones'),
                TextColumn::make('name')->sortable()->searchable()
                    ->label('Distritos'),
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
            'index' => Pages\ListDistricts::route('/'),
            'create' => Pages\CreateDistrict::route('/create'),
            'edit' => Pages\EditDistrict::route('/{record}/edit'),
        ];
    }
}
