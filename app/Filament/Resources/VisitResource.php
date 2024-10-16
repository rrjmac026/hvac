<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VisitResource\Pages;
use App\Models\Visit;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;

class VisitResource extends Resource
{
    protected static ?string $model = Visit::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    // protected static ?string $navigationLabel = 'Visit';
    protected static ?string $navigationGroup = 'Management';

    public static function form(Forms\Form $form): Forms\Form
        {
            return $form
                ->schema([
                    Forms\Components\Select::make('client_id')
                        ->relationship('client', 'name')
                        // ->searchable()
                        ->required(),
                    Forms\Components\Select::make('appointment_id')
                        ->relationship('appointment', 'id') // Use appointment relationship if available
                        // ->searchable()
                        ->required(),
                    Forms\Components\Select::make('pet_id')
                        ->relationship('pet', 'name')
                        // ->searchable()
                        ->required(),
                    Forms\Components\DateTimePicker::make('visit_date')
                        ->required(),
                    Forms\Components\Select::make('status')
                        ->options([
                            'scheduled' => 'Scheduled',
                            'completed' => 'Completed',
                            'canceled' => 'Canceled',
                        ])
                        ->default('scheduled')
                        ->required(),
                    Forms\Components\Textarea::make('diagnosis')
                        ->nullable(),
                    Forms\Components\Textarea::make('treatment')
                        ->nullable(),
                    Forms\Components\Textarea::make('notes')
                        ->nullable(),
                ]);
        }

    
        public static function table(Tables\Table $table): Tables\Table
        {
            return $table
                ->columns([
                    Tables\Columns\TextColumn::make('client.name')->label('Client'),
                    Tables\Columns\TextColumn::make('appointment.id')->label('Appointment ID'), // Use 'id' if that's the identifier
                    Tables\Columns\TextColumn::make('pet.name')->label('Pet'),
                    Tables\Columns\TextColumn::make('visit_date')->dateTime(),
                    Tables\Columns\TextColumn::make('status'),
                    Tables\Columns\TextColumn::make('diagnosis')->label('Diagnosis'),
                    Tables\Columns\TextColumn::make('treatment')->label('Treatment'),
                    Tables\Columns\TextColumn::make('created_at')->dateTime(),
                ])
                ->filters([
                    // Add any filters if necessary
                ])
                ->actions([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])
                ->bulkActions([
                    Tables\Actions\DeleteBulkAction::make(),
                ]);
                
        }

    
        public static function getPages(): array
        {
            return [
                'index' => Pages\ListVisits::route('/'),
                'create' => Pages\CreateVisit::route('/create'),
                'edit' => Pages\EditVisit::route('/{record}/edit'),
            ];
        }
    }
    