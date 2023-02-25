<?php

namespace App\Filament\Resources\RegionstateResource\Pages;

use App\Filament\Resources\RegionstateResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRegionstate extends EditRecord
{
    protected static string $resource = RegionstateResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
