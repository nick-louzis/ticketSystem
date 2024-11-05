<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CivilResource\Pages;
use App\Filament\Resources\CivilResource\RelationManagers;
use App\Models\Civil;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CivilResource extends Resource
{
    protected static ?string $model = Civil::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->label("Ονοματεπώνυμο")->required(),
                TextInput::make('email')->label("Email")->required(),
                TextInput::make('number')->label("Τηλέφωνο")->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCivils::route('/'),
            'create' => Pages\CreateCivil::route('/create'),
            'edit' => Pages\EditCivil::route('/{record}/edit'),
        ];
    }
}
