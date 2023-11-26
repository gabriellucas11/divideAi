<?php

namespace App\Filament\Resources;
use Filament\Forms\Components\Toggle;
use App\Filament\Resources\ChargeResource\Pages;
use App\Filament\Resources\ChargeResource\RelationManagers;
use App\Models\Charge;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ChargeResource extends Resource
{
    protected static ?string $model = Charge::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('users')
                    ->relationship(name: 'users', titleAttribute: 'name')
                    ->searchable()
                    ->multiple()
                    ->preload()
                    ->visibleOn('create')
                    ->required(),

                Toggle::make('paid_charge')
                    ->onColor('success')
                    ->visibleOn('edit')
                    ->offColor('danger')
                    ->hidden(fn ($record) => !$record?->users()->where('user_id', auth()->user()->id)->first()?->exists())
                    ->label('Pago'),

                Toggle::make('paid_owner')
                    ->onColor('success')
                    ->visibleOn('edit')
                    ->offColor('danger')
                    ->hidden(fn ($record) => auth()->user()->id != $record?->created_by)
                    ->label('Pago pelo criador'),

                Forms\Components\TextInput::make('value')
                    ->required()
                    ->numeric() -> label('valor'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('users.email')
                    ->numeric()
                    ->sortable()
                ->label('Cobrados'),
                Tables\Columns\TextColumn::make('value')
                    ->numeric()
                    ->sortable()
                ->label('Valor'),
                Tables\Columns\IconColumn::make('full_paid')
                    ->boolean()
                    ->label('Completamente pago'),
                Tables\Columns\IconColumn::make('paid_owner')
                    ->boolean()
                    ->label('Pago pelo criador'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListCharges::route('/'),
            'create' => Pages\CreateCharge::route('/create'),
            'edit' => Pages\EditCharge::route('/{record}/edit'),
        ];
    }
}
