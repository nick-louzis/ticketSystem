<?php

namespace App\Filament\Resources\TicketResource\Pages;

use App\Filament\Resources\TicketResource;
use App\Models\Civil;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use App\Models\User;
use Filament\Forms\Form;

class CreateTicket extends CreateRecord
{
    protected static string $resource = TicketResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array{
       $data['user_id'] = auth()->user()->id;
       return $data;
    }



// public function form(Form $form): Form
// {
//     return $form
//         ->schema([
//             TextInput::make('title')
//                 ->required()
//                 ->label('Ticket Title'),
//             Textarea::make('description')
//                 ->required()
//                 ->label('Ticket Description'),
//             Select::make('civil_id')
//                 ->label('Civil')
//                 ->searchable()
//                 ->getSearchResultsUsing(fn (string $query) => Civil::where('email', 'like', "%{$query}%")
//                     ->pluck('email', 'id'))
//                 ->getOptionLabelUsing(fn ($value) => User::find($value)?->email)
//                 ->createOptionForm([
//                     TextInput::make('name')->required()->label('Name'),
//                     TextInput::make('email')->email()->required()->label('Email')->unique(User::class, 'email'),
//                     TextInput::make('number')->label('Phone Number')
//                 ]),
//         ]);
// }

}
