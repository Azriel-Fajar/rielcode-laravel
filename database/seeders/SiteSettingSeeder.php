<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'home.hero_image',        'group' => 'home',   'value_type' => 'image',  'label' => 'Home hero image',        'hint' => 'Optional. Shown above the hero text on the homepage.'],
            ['key' => 'studio.hero_image',      'group' => 'studio', 'value_type' => 'image',  'label' => 'Studio hero image',      'hint' => 'Main image for the Studio page hero section.'],
            ['key' => 'studio.portrait_image',  'group' => 'studio', 'value_type' => 'image',  'label' => 'Studio portrait image',  'hint' => 'Secondary portrait shown in the Studio about block.'],
            ['key' => 'studio.tagline',         'group' => 'studio', 'value_type' => 'string', 'label' => 'Studio tagline',         'hint' => 'Short line below the studio hero title.'],
            ['key' => 'home.cta_eyebrow',       'group' => 'home',   'value_type' => 'string', 'label' => 'Home CTA eyebrow',       'hint' => 'Small label above the CTA band heading.'],
        ];

        foreach ($settings as $row) {
            SiteSetting::updateOrCreate(
                ['key' => $row['key']],
                $row + ['value' => null]
            );
        }
    }
}
