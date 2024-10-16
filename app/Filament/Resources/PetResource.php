<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PetResource\Pages;
use App\Models\Pet;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;

class PetResource extends Resource
{
    protected static ?string $model = Pet::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Client and Pet Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('client_id')
                    ->relationship('client', 'name')
                    ->required(),
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\FileUpload::make('photo')
                    ->label('Pet Photo')
                    ->disk('public')
                    ->directory('pet_photos') // Define the directory for uploads
                    ->required(),
                // FileUpload::make('photo'),
                Forms\Components\TextInput::make('species')->required(),
                Forms\Components\TextInput::make('breed')->required(),
                Forms\Components\Textarea::make('medical_history')->nullable(),
                Forms\Components\Textarea::make('allergies')->nullable(),
                Forms\Components\Textarea::make('vaccinations')->nullable(),
                Forms\Components\Textarea::make('ongoing_treatments')->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('client.name')->label('Client')->sortable()->searchable(),
                TextColumn::make('name')->sortable()->searchable(),
                ImageColumn::make('photo')
                    ->label('Pet Photo')
                    ->disk('public') 
                    ->height(50), 
                TextColumn::make('species')->sortable()->searchable(),
                TextColumn::make('breed')->sortable()->searchable(),
            ])
            ->filters([
                // Define any filters you want to implement
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPets::route('/'),
            'create' => Pages\CreatePet::route('/create'),
            'edit' => Pages\EditPet::route('/{record}/edit'),
        ];
    }
}
