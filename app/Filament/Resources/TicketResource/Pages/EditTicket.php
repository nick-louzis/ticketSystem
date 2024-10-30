<?php

namespace App\Filament\Resources\TicketResource\Pages;

use App\Filament\Resources\TicketResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTicket extends EditRecord
{
    protected static string $resource = TicketResource::class;

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
