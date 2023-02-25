<?php

namespace App\Filament\Resources\PastorResource\Pages;

use App\Filament\Resources\PastorResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPastors extends ListRecords
{
    protected static string $resource = PastorResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
