<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VaccinationResource\Pages;
use App\Models\Vaccination;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables\Table; 
use Filament\Tables; 
use Filament\Tables\Columns\TextColumn;
use Carbon\Carbon;

class VaccinationResource extends Resource
{
    protected static ?string $model = Vaccination::class;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard';
    protected static ?string $navigationGroup = 'Medical Records';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('pet_id')
                    ->label('Pet')
                    ->relationship('pet', 'name') 
                    ->required(),
                Forms\Components\TextInput::make('vaccine_name')
                    ->label('Vaccine Name')
                    ->required(),
                Forms\Components\DatePicker::make('dose_date') 
                    ->label('Vaccination Date')
                    ->required()
                    ->afterStateUpdated(function ($state, callable $set) {
                        // Automatically calculate next due date based on dose_date and interval
                        if ($state) {
                            $nextDueDate = Carbon::parse($state)->addYear();
                            $set('next_due_date', $nextDueDate->toDateString());
                        }
                    }),
                Forms\Components\DatePicker::make('next_due_date')
                    ->label('Next Due Date')
                    ->required(),
                Forms\Components\Textarea::make('notes')
                    ->label('Notes')
                    ->rows(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('pet.name')
                    ->label('Pet Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('vaccine_name')
                    ->label('Vaccine Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('dose_date') 
                    ->label('Vaccination Date')
                    ->date(),
                TextColumn::make('next_due_date')
                    ->label('Next Due Date')
                    ->date(),
                TextColumn::make('notes')
                    ->label('Notes')
                    ->limit(30),
            ])
            ->filters([
                // Add filters if needed
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Define any relationships here if needed
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVaccinations::route('/'),
            'create' => Pages\CreateVaccination::route('/create'),
            'edit' => Pages\EditVaccination::route('/{record}/edit'),
        ];
    }
}
