<?php

namespace App\Filament\Resources\ChargeResource\Pages;

use App\Filament\Resources\ChargeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCharge extends EditRecord
{
    protected static string $resource = ChargeResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['paid_charge'] = $this->getRecord()->paid_charge;

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $record =  $this->getRecord();
        $chargePay = $record->users()->where('user_id', auth()->user()->id)->first();

        if($chargePay) {
            $chargePay->pivot->update(['paid' => $data['paid_charge']]);
        }

        return $data;
    }
}
