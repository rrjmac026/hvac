<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientResource\Pages;
use App\Models\Client;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\Builder;

class ClientResource extends Resource
{
    protected static ?string $model = Client::class;
    protected static ?string $navigationIcon = 'heroicon-s-users';
    protected static ?string $recordTitleAttribute = 'name';

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return $record->name;        
    }

    public static function getGlobalSearchableAttributes(): array
    {
        // Only client name is searchable globally; pet names are handled in the query
        return ['name'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Name' => $record->name,
            // List all pet names associated with the client
            'Pets' => $record->pets->pluck('name')->implode(', ') 
        ];
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()
            ->with(['pets']) // Eager load pets to avoid N+1 query issue
            ->where(function ($query) {
                // Search clients by their name
                $query->where('name', 'like', '%' . request()->input('search') . '%')
                      // Include pets' names in the search
                      ->orWhereHas('pets', function ($query) {
                          $query->where('name', 'like', '%' . request()->input('search') . '%');
                      });
            });
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\TextInput::make('email')->email()->required(),
                Forms\Components\TextInput::make('phone')->tel()->required(),
                Forms\Components\TextInput::make('address')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->sortable()->searchable(),
                TextColumn::make('email')->sortable()->searchable(),
                TextColumn::make('phone')->sortable()->searchable(),
                TextColumn::make('address')->sortable()->searchable(),

                TextColumn::make('invoices_sum_amount')
                    ->label('Total Invoiced')
                    ->sum('invoices', 'amount') 
                    ->sortable(),

                TextColumn::make('invoices_paid_count')
                    ->label('Invoices Paid')
                    ->getStateUsing(function (Client $record) {
                        return $record->invoices()->where('status', 'paid')->count();
                    })
                    ->sortable(),
            ])
            ->filters([])
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClients::route('/'),
            'create' => Pages\CreateClient::route('/create'),
            'edit' => Pages\EditClient::route('/{record}/edit'),
        ];
    }
}
