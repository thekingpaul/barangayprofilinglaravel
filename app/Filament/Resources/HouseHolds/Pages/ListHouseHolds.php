<?php

namespace App\Filament\Resources\HouseHolds\Pages;

use App\Filament\Resources\HouseHolds\HouseHoldResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListHouseHolds extends ListRecords
{
    protected static string $resource = HouseHoldResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
