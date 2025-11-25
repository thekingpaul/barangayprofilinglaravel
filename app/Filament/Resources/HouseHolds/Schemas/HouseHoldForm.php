<?php

namespace App\Filament\Resources\HouseHolds\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class HouseHoldForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('household_no')
                    ->numeric()
                    ->required()
                    ->unique(ignorable: fn ($record) => $record),
                TextInput::make('household_head'),
                Select::make('purok')
                    ->options([
                        '1a' => '1a',
                        '1b' => '1b',
                        '2a' => '2a',
                        '2b' => '2b',
                        '3a' => '3a',
                        '3b' => '3b',
                        '4a' => '4a',
                        '4b' => '4b',
                    ])
                    ->required(),

                Select::make('house_ownership')
                    ->required()
                    ->options([
                        'Owned' => 'Owned',
                        'Rented' => 'Rented',
                        'Shared' => 'Shared',
                        'Informal' => 'Settler',
                    ]),

                Select::make('house_type')
                    ->required()
                    ->options([
                        'Concrete' => 'Concrete',
                        'Semi-Concrete' => 'Semi-Concrete',
                        'Light Materials' => 'Light Materials',
                    ]),

                Select::make('monthly_income')
                    ->options([
                        '0-1000' => '₱0 - ₱1,000',
                        '1001-2000' => '₱1,001 - ₱2,000',
                        '2001-3000' => '₱2,001 - ₱3,000',
                        '3001-5000' => '₱3,001 - ₱5,000',
                        '5001-10000' => '₱5,001 - ₱10,000',
                        '10001-15000' => '₱10,001 - �15,000',
                        '15001-25000' => '₱15,001 - ₱25,000',
                        '25001-50000' => '₱25,001 - ₱50,000',
                        '50001-100000' => '₱50,001 - ₱100,000',
                        '100000+' => 'Above ₱100,000',
                    ]),
                Select::make('livelihood')
                    ->options([
                        'None' => 'None',
                        'Crop Farming' => 'Crop Farming',
                        'Live stock raising' => 'Live stock raising',
                        'Fishing' => 'Fishing',
                    ]),

                TextInput::make('address')
                    ->default('Sayon, Tagbina, SDS'),
                Select::make('beneficiaries')
                    ->options([
                        '4Ps' => '4Ps',
                        'PhilHealth' => 'PhilHealth',
                    ]),

                Select::make('disaster_risk')
                    ->options([
                        'Frequent Earthquake' => 'Frequent Earthquake',
                        'Volcanic Eruptions' => 'Volcanic Eruptions',
                        'Typhoons' => 'Typhoons',
                        'Floods' => 'Floods',
                        'Tsunami' => 'Tsunami',
                    ]),
                Toggle::make('electricity')
                    ->label('Has Electricity')
                    ->required(),

            ]);
    }
}
