<?php

namespace App\Filament\Resources\Withdrawals\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class WithdrawalForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('amount')
                    ->required()
                    ->numeric()
                    ->disabled(),
                Select::make('status')
                    ->required()
                    ->options([
                        'PENDING' => 'PENDING',
                        'APPROVED' => 'APPROVED',
                        'REJECTED' => 'REJECTED',
                        'COMPLETED' => 'COMPLETED',
                    ])
                    ->default('PENDING'),
                TextInput::make('bank_account')
                    ->required()
                    ->disabled(),
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required()
                    ->disabled(),
            ]);
    }
}
