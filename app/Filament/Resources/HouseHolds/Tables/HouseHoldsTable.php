<?php

namespace App\Filament\Resources\HouseHolds\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class HouseHoldsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('household_no')
                    ->searchable(),
                TextColumn::make('household_head')
                    ->searchable(),
                TextColumn::make('purok')
                    ->searchable(),
                TextColumn::make('house_ownership')
                    ->searchable(),
                TextColumn::make('house_type')
                    ->searchable(),
                IconColumn::make('electricity')
                    ->boolean(),
                TextColumn::make('monthly_income')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('livelihood')
                    ->searchable(),
                TextColumn::make('disaster_risk')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
