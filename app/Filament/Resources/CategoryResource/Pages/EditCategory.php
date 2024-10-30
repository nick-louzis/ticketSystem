<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCategory extends EditRecord
{
    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        if(auth()->user()->isAdmin=== 1) {
            return [
                Actions\DeleteAction::make(),
            ];
        } else{
            return[];
        };
    }
}
