<?php

namespace App\Filament\Resources\HouseHolds;

use App\Filament\Resources\HouseHolds\Pages\ListHouseHolds;
use App\Filament\Resources\HouseHolds\Schemas\HouseHoldForm;
use App\Filament\Resources\HouseHolds\Tables\HouseHoldsTable;
use App\Models\HouseHold;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class HouseHoldResource extends Resource
{
    protected static ?string $model = HouseHold::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHomeModern;

    protected static ?string $recordTitleAttribute = 'HouseHolds';

    public static function form(Schema $schema): Schema
    {
        return HouseHoldForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return HouseHoldsTable::configure($table);
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
            'index' => ListHouseHolds::route('/'),

        ];
    }
}
