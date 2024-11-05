<?php

namespace App\Filament\Resources\TicketResource\Pages;

use App\Filament\Resources\TicketResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Contracts\Database\Eloquent\Builder;

class ListTickets extends ListRecords
{
    protected static string $resource = TicketResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs() : array {
        return[
            "Όλα" => Tab::make(),
            "Υπό εξέταση" => Tab::make()->modifyQueryUsing(function( $query) {
                $query->where('status', 'pending');
            }),
            "Υπό επίλυση" => Tab::make()->modifyQueryUsing(function( $query) {
                $query->where('status', 'in progress');
            }),
            "Επιλήθηκαν" => Tab::make()->modifyQueryUsing(function( $query) {
                $query->where('status', 'closed');
            })
        ];
    }
}
