<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Regionstate;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\RegionstateResource\Pages;
use App\Filament\Resources\RegionstateResource\RelationManagers;

class RegionstateResource extends Resource
{
    protected static ?string $model = Regionstate::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $navigationLabel = 'Región y Estados';

    protected static ?string $pluralModelLabel = 'Región y Estados';

    protected static ?int $navigationSort = 5;

    protected static ?string $navigationGroup = 'Configuración Global';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Select::make('region_id')
                            ->relationship('region', 'name')
                            ->required()
                            ->placeholder('Seleccione una Región')
                            ->label('Región'),
                        TextInput::make('name')
                            ->required()
                            ->label('Estado')
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
                    ->label('Estados'),
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
            'index' => Pages\ListRegionstates::route('/'),
            'create' => Pages\CreateRegionstate::route('/create'),
            'edit' => Pages\EditRegionstate::route('/{record}/edit'),
        ];
    }
}
