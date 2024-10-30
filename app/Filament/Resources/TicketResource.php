<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TicketResource\Pages;
use App\Filament\Resources\TicketResource\RelationManagers;
use App\Filament\Resources\TicketResource\RelationManagers\StepsRelationManager;
use App\Models\Ticket;
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
                        TextInput::make('name')->label("Ονοματεπώνυμο")->required(),
                        TextInput::make('phone')->label("Τηλέφωνο") ->tel()->rules('integer')->required(),
                        TextInput::make('email')->required(),
                    ])->collapsible()->columnSpan(1),

            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->label('Τίτλος'),
                TextColumn::make('name')->label('Name'),
                TextColumn::make('phone')->label('Phone'),
                TextColumn::MAKE('description')->label('Περιγραφή'),
                TextColumn::make('user.name')->label('Διαχειριστής'),
                TextColumn::make('category.title')->label('Κατηγορία')->sortable()->searchable(),

            
      
                
            ])
            ->filters([
                //
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
            StepsRelationManager::class
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
