<?php

namespace App\Filament\Resources\HouseHolds\Widgets;

use App\Models\HouseHold;
use App\Models\Resident;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class HouseholdStatsWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Households', HouseHold::count())
                ->description('Registered households')
                ->descriptionIcon('heroicon-m-home')
                ->color('success'),

            Stat::make('Total Residents', Resident::count() + HouseHold::count())
                ->description('Total population')
                ->descriptionIcon('heroicon-m-users')
                ->color('info'),

            Stat::make('Average Family Size',
                HouseHold::count() > 0
                    ? number_format((Resident::count() + HouseHold::count()) / HouseHold::count(), 1)
                    : '0'
            )
                ->description('Members per household')
                ->descriptionIcon('heroicon-m-calculator')
                ->color('warning'),
        ];
    }
}
