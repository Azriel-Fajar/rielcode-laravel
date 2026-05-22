<?php

namespace App\Filament\Resources\TestimonialInviteResource\Pages;

use App\Filament\Resources\TestimonialInviteResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTestimonialInvite extends EditRecord
{
    protected static string $resource = TestimonialInviteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
