<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TicketResource\Pages;
use App\Filament\Resources\TicketResource\RelationManagers;
use App\Filament\Resources\TicketResource\RelationManagers\CivilsRelationManager;
use App\Filament\Resources\TicketResource\RelationManagers\StepsRelationManager;
use App\Models\Civil;
use App\Models\Ticket;
use Barryvdh\Debugbar\Facades\Debugbar;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;



class TicketResource extends Resource
{
    protected static ?string $model = Ticket::class;

    protected static ?string $navigationIcon = 'heroicon-s-folder';

    protected static ?string $navigationGroup = "Ticket";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Προσθέστε Ticket')
                    ->description('Πρσοσθέστε τις απαραίτητες λεπτομέρειες σχετικά με το νέο Ticket')
                    ->schema([
                        TextInput::make('title')->label("Τίτλος")->required(),
                        Select::make('category_id')->label('Κατηγορία')->relationship('category', 'title')->searchable()->preload()->required(),
                        
                        DateTimePicker::make('created_at')->label('Ημερομηνία Δημιουργίας'),
                        DateTimePicker::make('endDate')->label('Ημερομηνία Ολοκλήρωσης'),
                        ToggleButtons::make('status')->label('Κατάσταση')->required()
                                        ->options([
                                            'pending' => 'Υπο εξέταση',
                                            'in progress' => 'Υπό επίλυση',
                                            'closed' => 'Επιλήθηκε'
                                        ])->default("pending")
                                        ->icons([
                                            'pending' => 'heroicon-o-pencil',
                                            'in progress' => 'heroicon-o-clock',
                                            'closed' => 'heroicon-o-check-circle',
                                        ])->inline()->columnSpanFull(),
                        MarkdownEditor::make('description')->label("Περιγραφή")->required()->columnSpanFull(),
                    ])->columnSpan(2)->columns(2),
                Section::make('Προσθέστε Πολίτη')
                    ->description('Πρσοσθέστε τα στοιχεία επικοινωνίας του πολίτη')
                    ->schema([
                       
                        Select::make('civil_id')
                        ->relationship('civil', 'email') //define the function form the ticket class and the attribute i wan to display.
                        ->required()->searchable()
                        ->getSearchResultsUsing(fn (string $search): array => Civil::where('email', 'like', "%{$search}%")
                        ->pluck('email', 'id')->toArray())
                        ->getOptionLabelUsing(fn ($value): ?string => Civil::find($value)?->email)
                      ->reactive()
                         // Make the select field reactive
                        ->afterStateUpdated(function (callable $set, $state) {
                            // Fetch the user by ID when selected and set other fields
                            $civil = Civil::find($state);
                            if ($civil) {
                                $set('name', $civil->name);
                                $set('number', $civil->number);
                                $set('email', $civil->email);
                            } else {
                                $set('name', null);
                                $set('number', null);
                             
                            }
                        })->createOptionForm([
                            TextInput::make('email')->email()->required()->label('Email')->unique(Civil::class, 'email'),
                            TextInput::make('number')->label('Phone Number'),
                            TextInput::make('name')->required()->label('Name'),
                    
                        ])->createOptionUsing(function ($data) {
                            // Create a new Civil record with provided data
                            return Civil::create([
                                'email' => $data['email'],
                                'name' => $data['name'] ?? null,
                                'number' => $data['number'] ?? null,
                                // 'ticket_id' => $data['id']?? null,
                            ])->id; // Return the ID of the newly created Civil
                        }),
                        TextInput::make('name')->label("Ονοματεπώνυμο")->readOnly()->required()
                        ->afterStateHydrated(function (callable $set, $record) {
                            if ($record && $record->civil) {
                                $set('name', $record->civil->name);
                            }
                        }),
                        TextInput::make('number')->label("Τηλέφωνο")->readOnly()->tel()->rules('integer')->required()
                        ->afterStateHydrated(function (callable $set, $record) {
                            if ($record && $record->civil) {
                                $set('number', $record->civil->number);
                            }
                        }),
                                  
                    ])->collapsible()->columnSpan(1),

            ])
           ->columns(3);
    }


    
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->label('Τίτλος'),
                TextColumn::make('description')->label('Περιγραφή'),
                TextColumn::make('user.name')->label('Διαχειριστής'),
                TextColumn::make('category.title')->label('Κατηγορία')->sortable()->searchable(),
                TextColumn::make('civil.name')->label('Civil Name'),
                TextColumn::make('civil.email')->label('Email Πολίτη'),
                TextColumn::make('civil.number')->label('Phone Number'),
            
      
                
            ])
            ->filters([
                
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            StepsRelationManager::class,
            // CivilsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTickets::route('/'),
            'create' => Pages\CreateTicket::route('/create'),
            'edit' => Pages\EditTicket::route('/{record}/edit'),
        ];
    }
}
