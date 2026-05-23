<?php

namespace App\Filament\Resources\TestimonialInviteResource\Pages;

use App\Filament\Resources\TestimonialInviteResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateTestimonialInvite extends CreateRecord
{
    protected static string $resource = TestimonialInviteResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['token'] = Str::random(64);
        return $data;
    }
}
