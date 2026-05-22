<?php

namespace App\Filament\Resources\PackageAddonResource\Pages;

use App\Filament\Resources\PackageAddonResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPackageAddon extends EditRecord
{
    protected static string $resource = PackageAddonResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }
}
