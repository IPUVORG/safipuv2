<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\City;
use Filament\Tables;
use App\Models\Blood;
use App\Models\Genre;
use App\Models\State;
use App\Models\Study;
use App\Models\Pastor;
use App\Models\Region;
use App\Models\Sector;
use App\Models\Marital;
use App\Models\Vinculo;
use App\Models\District;
use App\Models\Nationality;
use App\Models\Regionstate;
use Illuminate\Support\Str;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PastorResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PastorResource\RelationManagers;
use League\CommonMark\Extension\CommonMark\Node\Inline\Link;

class PastorResource extends Resource
{
    protected static ?string $model = Pastor::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $navigationLabel = 'Pastores';

    protected static ?string $pluralModelLabel = 'Pastores';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationGroup = 'Módulo de Secretaría';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->schema([
                        Card::make()
                            ->schema([
                                FileUpload::make('profile_photo_path')
                                    ->image()
                                    ->label('Foto del pastor')
                            ])->columns(['sm' => 3,]),

                        Card::make()
                            ->schema([
                                TextInput::make('name')
                                    ->label('Nombres')
                                    ->required()
                                    ->maxLength(45),

                                TextInput::make('lastname')
                                    ->label('Apellidos')
                                    ->required()
                                    ->maxLength(45),

                                Select::make('genre_id')
                                    ->options(Genre::all()->pluck('name', 'id'))
                                    ->placeholder('Seleccione...')
                                    ->required()
                                    ->label('Género'),

                                Select::make('nationality_id')
                                    //->relationship('nationality', 'name')
                                    ->options(Nationality::all()->pluck('name', 'id'))
                                    ->placeholder('Seleccione...')
                                    ->required()
                                    ->label('Nacionalidad'),

                                TextInput::make('cardNumber')
                                    ->label('Cédula')
                                    ->rule('numeric')
                                    ->required()
                                    ->reactive()
                                    ->unique(ignoreRecord: true)
                                    ->afterStateUpdated(function (\Closure $set, $state) {
                                        $set('email', Str::slug($state));
                                    }),

                                DatePicker::make('birthdate')
                                    ->label('Fecha de nacimiento')
                                    ->required(),
                                TextInput::make('placedate')
                                    ->label('Lugar de nacimiento')
                                    ->required()
                                    ->maxLength(25),
                                Select::make('marital_id')
                                    ->options(Marital::all()->pluck('name', 'id'))
                                    ->placeholder('Seleccione...')
                                    ->required()
                                    ->label('Estado Civil'),

                            ])->columns(['md' => 2,]),

                        Card::make()
                            ->schema([
                                Select::make('blood_id')
                                    ->options(Blood::all()->pluck('name', 'id'))
                                    ->placeholder('Seleccione...')
                                    ->required()
                                    ->label('Tipo de Sangre'),

                                Select::make('study_id')
                                    ->options(Study::all()->pluck('name', 'id'))
                                    ->placeholder('Seleccione...')
                                    ->required()
                                    ->label('Nivel Académico'),

                                TextInput::make('school')
                                    ->label('Carrera')
                                    ->maxLength(19),
                                DatePicker::make('baptismdate')
                                    ->label('Fecha de bautismo'),
                                TextInput::make('baptizerman')
                                    ->label('¿Quién le bautizó?')
                                    ->maxLength(27),
                                TextInput::make('phonehome')
                                ->label('Teléfono Residencial')
                                    ->mask(fn (TextInput\Mask $mask) => $mask->pattern('(0000) 000-0000')),
                                TextInput::make('phonemovil')
                                    ->label('Teléfono Celular')
                                    ->mask(fn (TextInput\Mask $mask) => $mask->pattern('(0000) 000-0000')),
                                TextInput::make('email')
                                    ->label('Correo electrónico')
                                    ->placeholder('Correo automático')
                                    //->mask(fn (TextInput\Mask $mask) => $mask->pattern('00000000'))
                                    ->suffix('@ipuv.org')
                                    //->required()
                                    ->disabled()
                                    ->unique(ignoreRecord: true),
                                    //->maxLength(8),
                                Select::make('house_id')
                                    ->relationship('house', 'name')
                                    ->placeholder('Seleccione...')
                                    ->required()
                                    ->label('Tipo de Vivienda'),

                                Toggle::make('ivss')
                                    ->label('¿Es cotizante del Seguro Social?'),

                                Toggle::make('lph')
                                    ->label('¿Es cotizante de L.P.H.'),

                                Toggle::make('otherwork')
                                    ->label('¿Ejerce otra labor?'),

                                TextInput::make('work')
                                    ->label('¿Cuál?')
                                    ->maxLength(27)
                                    ->placeholder('Rellenar solo si el Pastor ejerce otra labor...')
                                    ->columnSpan([
                                        'md' => 2,
                                    ]),

                                TextInput::make('rifNumber')
                                    ->label('Rif.')
                                    ->mask(fn (TextInput\Mask $mask) => $mask->pattern('000000000'))
                                    ->unique(ignoreRecord: true),

                                DatePicker::make('startdate')
                                    ->label('Fecha de inicio en el Ministerio')
                                    ->required(),

                                Select::make('region_id')->required()
                                    ->label('Región')
                                    ->placeholder('Seleccione...')
                                    ->options(Region::all()->pluck('name', 'id')->toArray())
                                    ->reactive()
                                    ->afterStateUpdated(fn (callable $set) => $set('district_id', null)),

                                Select::make('district_id')->required()
                                    ->label('Distrito')
                                    ->placeholder('Seleccione...')
                                    ->options(function (callable $get){
                                        $region = Region::find($get('region_id'));
                                        if(!$region){
                                            return District::all()->pluck('name', 'id');
                                        }
                                        return $region->districts->pluck('name', 'id');
                                    })
                                    ->reactive()
                                    ->afterStateUpdated(fn (callable $set) => $set('sector_id', null)),

                                Select::make('sector_id')->required()
                                    ->label('Sector')
                                    ->placeholder('Seleccione...')
                                    ->options(function (callable $get){
                                        $district = District::find($get('district_id'));
                                        if(!$district){
                                            return Sector::all()->pluck('name', 'id');
                                        }
                                        return $district->sectors->pluck('name', 'id');
                                    })
                                    ->reactive(),

                                Select::make('state_id')->required()
                                    ->label('Estado')
                                    ->placeholder('Seleccione...')
                                    ->options(State::all()->pluck('name', 'id')->toArray())
                                    ->reactive()
                                    ->afterStateUpdated(fn (callable $set) => $set('city_id', null)),


                                Select::make('city_id')->required()
                                    ->label('Municipio')
                                    ->placeholder('Seleccione...')
                                    ->options(function (callable $get){
                                        $state = State::find($get('state_id'));
                                        if(!$state){
                                            return City::all()->pluck('name', 'id');
                                        }
                                        return $state->cities->pluck('name', 'id');
                                    })
                                    ->reactive(),

                                TextInput::make('addresspastor')
                                    ->label('Dirección donde vive el pastor')
                                    ->required()
                                    ->maxLength(65)
                                    ->columnSpan([
                                        'md' => 3,
                                    ]),
                            ])->columns(['sm' => 4,]),

                    ])->columnSpan('full')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('profile_photo_path')->width(50)->height(50),

                TextColumn::make('id')
                    ->label('Nro.'),
                TextColumn::make('name')->sortable()->searchable()
                    ->label('Nombres'),
                TextColumn::make('lastname')->sortable()->searchable()
                    ->label('Apellidos'),
                TextColumn::make('cardNumber')->sortable()->searchable()
                    ->label('Cédula'),
                TextColumn::make('region.name')->sortable()->searchable()
                    ->label('Región'),
                TextColumn::make('district.name')->sortable()->searchable()
                    ->label('Distrito'),
                TextColumn::make('sector.name')->sortable()->searchable()
                    ->label('Sector'),
                TextColumn::make('state.name')->sortable()->searchable()
                    ->label('Estado'),
                TextColumn::make('city.name')->sortable()->searchable()
                    ->label('Municipio'),
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
            'index' => Pages\ListPastors::route('/'),
            'create' => Pages\CreatePastor::route('/create'),
            'edit' => Pages\EditPastor::route('/{record}/edit'),
        ];
    }
}
