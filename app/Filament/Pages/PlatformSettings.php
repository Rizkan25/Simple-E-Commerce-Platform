<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use App\Models\PlatformSetting;

class PlatformSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static string|\UnitEnum|null $navigationGroup = 'Layanan Pelanggan'; // Group it there for now or new group
    protected static ?string $title = 'Pengaturan Platform';
    protected string $view = 'filament.pages.platform-settings';

    public ?array $commissionData = [];
    public ?array $bankData = [];

    public function mount(): void
    {
        $commission = PlatformSetting::firstOrCreate(
            ['key' => 'commission_percentage'],
            ['value' => '5']
        );
        
        $bankName = PlatformSetting::firstOrCreate(['key' => 'platform_bank_name'], ['value' => 'BCA']);
        $bankAccount = PlatformSetting::firstOrCreate(['key' => 'platform_bank_account'], ['value' => '1234567890']);
        $bankOwner = PlatformSetting::firstOrCreate(['key' => 'platform_bank_owner'], ['value' => 'PT Solusi Marketplace Digital']);

        $this->commissionForm->fill([
            'commission_percentage' => $commission->value,
        ]);

        $this->bankForm->fill([
            'platform_bank_name' => $bankName->value,
            'platform_bank_account' => $bankAccount->value,
            'platform_bank_owner' => $bankOwner->value,
        ]);
    }

    protected function getForms(): array
    {
        return [
            'commissionForm',
            'bankForm',
        ];
    }

    public function commissionForm(Schema $form): Schema
    {
        return $form
            ->schema([
                TextInput::make('commission_percentage')
                    ->label('Persentase Komisi (%)')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(100)
                    ->step(0.01)
                    ->required()
                    ->extraAttributes(['style' => 'max-width: 150px;']),
            ])
            ->statePath('commissionData');
    }

    public function bankForm(Schema $form): Schema
    {
        return $form
            ->schema([
                \Filament\Forms\Components\Select::make('platform_bank_name')
                    ->label('Nama Bank')
                    ->options([
                        'BCA' => 'BCA',
                        'Bank Mandiri' => 'Bank Mandiri',
                        'BNI' => 'BNI',
                        'BRI' => 'BRI',
                        'BSI' => 'BSI',
                        'CIMB Niaga' => 'CIMB Niaga',
                        'Permata Bank' => 'Permata Bank',
                        'Bank Danamon' => 'Bank Danamon',
                        'BTN' => 'BTN',
                        'Bank Jago' => 'Bank Jago',
                        'SeaBank' => 'SeaBank',
                        'Bank Neo Commerce' => 'Bank Neo Commerce',
                    ])
                    ->searchable()
                    ->required()
                    ->markAsRequired(false),
                TextInput::make('platform_bank_account')
                    ->label('Nomor Rekening')
                    ->required()
                    ->markAsRequired(false)
                    ->placeholder('Masukkan nomor rekening')
                    ->rules([
                        fn ($get): \Closure => function (string $attribute, $value, \Closure $fail) use ($get) {
                            $rule = new \App\Rules\ValidBankAccountLength($get('platform_bank_name'));
                            $rule->validate($attribute, $value, $fail);
                        },
                    ]),
                TextInput::make('platform_bank_owner')
                    ->label('Atas Nama')
                    ->required()
                    ->markAsRequired(false)
                    ->placeholder('Nama pemilik rekening'),
            ])
            ->statePath('bankData');
    }

    public function saveCommission(): void
    {
        $data = $this->commissionForm->getState();

        PlatformSetting::updateOrCreate(
            ['key' => 'commission_percentage'],
            ['value' => $data['commission_percentage']]
        );

        Notification::make()
            ->title('Pengaturan komisi berhasil disimpan')
            ->success()
            ->send();
    }

    public function saveBank(): void
    {
        $data = $this->bankForm->getState();

        PlatformSetting::updateOrCreate(
            ['key' => 'platform_bank_name'],
            ['value' => $data['platform_bank_name']]
        );
        PlatformSetting::updateOrCreate(
            ['key' => 'platform_bank_account'],
            ['value' => $data['platform_bank_account']]
        );
        PlatformSetting::updateOrCreate(
            ['key' => 'platform_bank_owner'],
            ['value' => $data['platform_bank_owner']]
        );

        Notification::make()
            ->title('Pengaturan rekening bank berhasil disimpan')
            ->success()
            ->send();
    }
}
