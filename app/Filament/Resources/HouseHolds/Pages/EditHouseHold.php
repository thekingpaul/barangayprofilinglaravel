<?php

namespace App\Filament\Resources\HouseHolds\Pages;

use App\Filament\Resources\HouseHolds\HouseHoldResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditHouseHold extends EditRecord
{
    protected static string $resource = HouseHoldResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
