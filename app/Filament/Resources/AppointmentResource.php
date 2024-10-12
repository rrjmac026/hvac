<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AppointmentResource\Pages;
use App\Models\Appointment;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;

class AppointmentResource extends Resource
{
    protected static ?string $model = Appointment::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $navigationLabel = 'Appointments';
    protected static ?string $navigationGroup = 'Management';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('client_id')
                    ->relationship('client', 'name') // Assuming 'name' is a field in Client model
                    ->required(),
                Forms\Components\Select::make('pet_id')
                    ->relationship('pet', 'name') // Assuming 'name' is a field in Pet model
                    ->required(),
                Forms\Components\DateTimePicker::make('appointment_date')
                    ->required(),
                Forms\Components\Select::make('status')
                    ->options([
                        'scheduled' => 'Scheduled',
                        'completed' => 'Completed',
                        'canceled' => 'Canceled',
                    ])
                    ->default('scheduled')
                    ->required(),
                Forms\Components\Textarea::make('notes')
                    ->nullable(),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id') // Add this line to show the ID
                    ->label('ID')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('client.name')->label('Client')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pet.name')->label('Pet')
                    ->searchable(),
                Tables\Columns\TextColumn::make('appointment_date')->dateTime(),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('created_at')->dateTime(),
            ])
            ->filters([
                // Add any filters you want here
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
            'index' => Pages\ListAppointments::route('/'),
            'create' => Pages\CreateAppointment::route('/create'),
            'edit' => Pages\EditAppointment::route('/{record}/edit'),
        ];
    }
}
