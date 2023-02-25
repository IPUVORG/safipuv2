<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Sector;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\SectorResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SectorResource\RelationManagers;

class SectorResource extends Resource
{
    protected static ?string $model = Sector::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $navigationLabel = 'Sectores';

    protected static ?string $pluralModelLabel = 'Sectores';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationGroup = 'Configuración Global';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Select::make('district_id')
                            ->relationship('district', 'name')
                            ->placeholder('Seleccione un Distrito')
                            ->required()
                            ->label('Distrito'),
                        TextInput::make('name')
                            ->required()
                            ->label('Sector')
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('Nro.'),
                TextColumn::make('district.name')->sortable()->searchable()
                    ->label('Distritos'),
                TextColumn::make('name')
                    ->label('Sectores')->sortable()->searchable(),
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
            'index' => Pages\ListSectors::route('/'),
            'create' => Pages\CreateSector::route('/create'),
            'edit' => Pages\EditSector::route('/{record}/edit'),
        ];
    }
}
