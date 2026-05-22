<?php

namespace App\Filament\Resources\TestimonialInviteResource\Pages;

use App\Filament\Resources\TestimonialInviteResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTestimonialInvites extends ListRecords
{
    protected static string $resource = TestimonialInviteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
