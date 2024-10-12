<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MedicalRecordResource\Pages;
use App\Models\MedicalRecord;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables\Table; // Correct namespace for Table
use Filament\Tables;

class MedicalRecordResource extends Resource
{
    protected static ?string $model = MedicalRecord::class;
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
                Forms\Components\DatePicker::make('date')
                    ->label('Date')
                    ->required(),
                Forms\Components\Textarea::make('treatment')
                    ->label('Treatment')
                    ->rows(3),
                Forms\Components\Textarea::make('surgery')
                    ->label('Surgery')
                    ->rows(3),
                Forms\Components\Textarea::make('medication')
                    ->label('Medication')
                    ->rows(3),
                Forms\Components\Textarea::make('lab_results')
                    ->label('Lab Results')
                    ->rows(3),

                Forms\Components\DatePicker::make('next_appointment_date')
                    ->label('Next Appointment Date')
                    ->required(),

            ]);
    }

    public static function table(Table $table): Table // Ensure this matches
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('pet.name')
                    ->label('Pet Name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date')
                    ->label('Date')
                    ->date(),
                Tables\Columns\TextColumn::make('treatment')
                    ->label('Treatment')
                    ->limit(30),
                Tables\Columns\TextColumn::make('surgery')
                    ->label('Surgery')
                    ->limit(30),
                Tables\Columns\TextColumn::make('medication')
                    ->label('Medication')
                    ->limit(30),
                Tables\Columns\TextColumn::make('lab_results')
                    ->label('Lab Results')
                    ->limit(30),
            ])
            ->filters([
                // Add filters if necessary
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Define any related resources here if needed
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMedicalRecords::route('/'),
            'create' => Pages\CreateMedicalRecord::route('/create'),
            'edit' => Pages\EditMedicalRecord::route('/{record}/edit'),
        ];
    }
}