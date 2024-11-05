<?php

namespace App\Filament\Resources\CivilResource\Pages;

use App\Filament\Resources\CivilResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCivil extends EditRecord
{
    protected static string $resource = CivilResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
