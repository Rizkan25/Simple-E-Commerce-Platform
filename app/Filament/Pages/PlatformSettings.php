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

    public ?array $data = [];

    public function mount(): void
    {
        $commission = PlatformSetting::firstOrCreate(
            ['key' => 'commission_percentage'],
            ['value' => '5']
        );

        $this->form->fill([
            'commission_percentage' => $commission->value,
        ]);
    }

    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Section::make('Keuntungan & Komisi')
                    ->description('Atur komisi otomatis yang akan dipotong dari penjual pada setiap transaksi yang berhasil.')
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
                    ->columnSpan(1)
            ])
            ->columns(2)
            ->statePath('data');
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Simpan Pengaturan')
                ->submit('save'),
        ];
    }

    public function save(): void
    {
        $data = $this->form->getState();

        PlatformSetting::updateOrCreate(
            ['key' => 'commission_percentage'],
            ['value' => $data['commission_percentage']]
        );

        Notification::make()
            ->title('Pengaturan berhasil disimpan')
            ->success()
            ->send();
    }
}
