<?php

namespace App\Filament\Resources\Residents\Schemas;

use App\Models\HouseHold;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Carbon;

class ResidentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema

            ->components([

                Select::make('house_hold_id')
                    ->label('Household')
                    ->options(HouseHold::pluck('household_head', 'id'))
                    ->searchable()
                    ->preload()
                    ->live()
                    ->afterStateUpdated(function (Set $set, $state) {
                        if ($state) {
                            $household = HouseHold::find($state);
                            if ($household) {
                                $set('household_no', $household->household_no); // ✅ save to DB
                            }
                        }
                    })
                    ->required(),

                TextInput::make('household_no')
                    ->label('Household Number')
                    ->disabled()
                    ->dehydrated(true) // ✅ now it will save into residents table
                    ->columnSpan(1),

                TextInput::make('firstname')
                    ->required()
                    ->columnSpan(1),

                TextInput::make('middlename')
                    ->columnSpan(1),

                TextInput::make('lastname')
                    ->required()
                    ->columnSpan(1),

                TextInput::make('alias')
                    ->columnSpan(1),

                DatePicker::make('birthday')
                    ->required()
                    ->live()
                    ->afterStateUpdated(function (Set $set, $state) {
                        if ($state) {
                            $birthDate = Carbon::parse($state);
                            $age = $birthDate->diffInYears(Carbon::now()); // ✅ integer
                            $set('age', (int) $age);
                        }
                    })
                    ->columnSpan(1),

                TextInput::make('age')
                    ->required()
                    ->numeric()
                    ->disabled() // Auto-calculated
                    ->dehydrated(true) // ✅ ensures age is saved to DB
                    ->columnSpan(1),
                Select::make('gender')
                    ->options([
                        'Male' => 'Male',
                        'Female' => 'Female',
                    ])
                    ->required()
                    ->columnSpan(1),

                Select::make('civil_status')
                    ->options([
                        'Single' => 'Single',
                        'Divorced' => 'Divorced',
                        'Married' => 'Married',
                    ])
                    ->required()
                    ->columnSpan(1),

                Select::make('voter_status')
                    ->options([
                        'Registered' => 'Registered',
                        'Not Registered' => 'Not Registered', // Fixed typo
                    ])
                    ->required()
                    ->columnSpan(1),

                TextInput::make('birth_of_place')
                    ->label('Place of Birth')
                    ->columnSpan(1),

                TextInput::make('citizenship')
                    ->required()
                    ->default('Filipino')
                    ->columnSpan(1),

                TextInput::make('mobile_no')
                    ->label('Mobile Number')
                    ->tel()
                    ->columnSpan(1),

                TextInput::make('height')
                    ->numeric()
                    ->suffix('cm')
                    ->columnSpan(1),

                TextInput::make('weight')
                    ->numeric()
                    ->suffix('kg')
                    ->columnSpan(1),

                TextInput::make('email')
                    ->label('Email Address')
                    ->email()
                    ->columnSpan(1),

                TextInput::make('father')
                    ->label('Father\'s Name')
                    ->columnSpan(1),

                TextInput::make('mother')
                    ->label('Mother\'s Name')
                    ->columnSpan(1),

            ]);
    }
}
