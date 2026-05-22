<?php

namespace App\Filament\Resources\PackageAddonResource\Pages;

use App\Filament\Resources\PackageAddonResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPackageAddons extends ListRecords
{
    protected static string $resource = PackageAddonResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}
