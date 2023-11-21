<?php

namespace App\Filament\Resources\ChargeResource\Pages;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Components\Tab;
use App\Filament\Resources\ChargeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCharges extends ListRecords
{
    protected static string $resource = ChargeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    public function getTabs(): array
    {
        return [

            'Cobranças' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $this->searchCobrancas($query)),
            'Dividas' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $this->searchDividas($query)),
        ];
    }



    private function searchCobrancas(Builder $query): Builder {
        return $query->where('created_by',auth()->user()->id);

    }

    private function searchDividas(Builder $query): Builder {
        return  $query->whereHas('users', function ($query)  {
            $query->where('table_users_chargeds.user_id', '=', auth()->user()->id);
        });
    }
}
