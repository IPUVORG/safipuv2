<?php

namespace App\Filament\Resources\PastorResource\Pages;

use App\Filament\Resources\PastorResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPastor extends EditRecord
{
    protected static string $resource = PastorResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
