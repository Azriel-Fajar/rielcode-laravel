<?php

namespace Database\Seeders;

use App\Models\PackageAddon;
use Illuminate\Database\Seeder;

class PackageAddonSeeder extends Seeder
{
    public function run(): void
    {
        // Custom Domain Setup + Extra Revision Round + WhatsApp Business Integration are no longer offered.
        PackageAddon::whereIn('name', ['Custom Domain Setup', 'Extra Revision Round', 'WhatsApp Business Integration'])->delete();

        // Backfill slugs on pre-slug legacy rows so updateOrCreate matches them
        // instead of creating duplicates.
        $legacySlugByName = [
            'Extra Page'                       => 'extra-page',
            'Maintenance and Updates'          => 'maintenance',
            'Priority Delivery'                => 'priority',
            'AI Chatbot Integration'           => 'chatbot',
            'Advanced SEO Package'             => 'seo',
            'Advanced SEO'                     => 'seo',
            'Blog / News Section'              => 'blog',
            'Google Analytics + Search Console' => 'analytics',
        ];
        foreach ($legacySlugByName as $name => $slug) {
            PackageAddon::whereNull('slug')->where('name', $name)->update(['slug' => $slug]);
        }

        $addons = [
            [
                'slug'        => 'extra-page',
                'name'        => 'Extra Page',
                'description' => 'Add an additional fully-designed page beyond your plan.',
                'price_idr'   => 85000,
                'price_usd'   => 5.00,
                'type'        => 'per_page',
                'tiers'       => null,
                'sort_order'  => 1,
            ],
            [
                'slug'        => 'maintenance',
                'name'        => 'Maintenance Support',
                'description' => 'Monthly bug fixes, content updates, performance monitoring.',
                'price_idr'   => 300000,
                'price_usd'   => 18.00,
                'type'        => 'monthly',
                'tiers'       => null,
                'sort_order'  => 2,
            ],
            [
                'slug'        => 'priority',
                'name'        => 'Priority Delivery',
                'description' => '50% faster turnaround',
                'price_idr'   => 400000,
                'price_usd'   => 24.00,
                'type'        => 'one_time',
                'tiers'       => null,
                'sort_order'  => 3,
            ],
            [
                'slug'        => 'chatbot',
                'name'        => 'AI Chatbot',
                'description' => 'AI-powered chat widget on your site',
                'price_idr'   => 1500000,
                'price_usd'   => 87.00,
                'type'        => 'one_time',
                'tiers'       => null,
                'sort_order'  => 4,
            ],
            [
                'slug'        => 'login',
                'name'        => 'Login / Member System',
                'description' => 'User registration, login & profile pages',
                'price_idr'   => 550000,
                'price_usd'   => 33.00,
                'type'        => 'one_time',
                'tiers'       => null,
                'sort_order'  => 5,
            ],
            [
                'slug'        => 'cms',
                'name'        => 'CMS / Admin Panel',
                'description' => 'Manage your content from a dashboard',
                'price_idr'   => 0,
                'price_usd'   => 0,
                'type'        => 'one_time',
                'tiers'       => [
                    ['name' => 'Basic',    'info' => 'Text & image content editor',  'price_idr' => 800000,  'price_usd' => 48.00],
                    ['name' => 'Standard', 'info' => '+ Media library & user roles',  'price_idr' => 1200000, 'price_usd' => 72.00],
                    ['name' => 'Advanced', 'info' => '+ Custom modules & API access',  'price_idr' => 1600000, 'price_usd' => 96.00],
                ],
                'sort_order'  => 6,
            ],
            [
                'slug'        => 'ecom',
                'name'        => 'E-Commerce',
                'description' => 'Product catalog, cart & order management',
                'price_idr'   => 0,
                'price_usd'   => 0,
                'type'        => 'one_time',
                'tiers'       => [
                    ['name' => 'Basic',    'info' => 'Product catalog, cart & checkout',     'price_idr' => 1000000, 'price_usd' => 58.00],
                    ['name' => 'Standard', 'info' => '+ Payment gateway & order tracking',   'price_idr' => 1500000, 'price_usd' => 87.00],
                    ['name' => 'Advanced', 'info' => '+ Multi-category, coupons & analytics', 'price_idr' => 2000000, 'price_usd' => 116.00],
                ],
                'sort_order'  => 7,
            ],
            [
                'slug'        => 'seo',
                'name'        => 'Advanced SEO',
                'description' => 'Full meta, schema markup & sitemap setup',
                'price_idr'   => 300000,
                'price_usd'   => 18.00,
                'type'        => 'one_time',
                'tiers'       => null,
                'sort_order'  => 8,
            ],
            [
                'slug'        => 'blog',
                'name'        => 'Blog / News Section',
                'description' => 'Self-managed blog with categories, tags, and a simple editor.',
                'price_idr'   => 500000,
                'price_usd'   => 30.00,
                'type'        => 'one_time',
                'tiers'       => null,
                'sort_order'  => 9,
            ],
            [
                'slug'        => 'analytics',
                'name'        => 'Google Analytics + Search Console',
                'description' => 'Tracking setup, conversion goals, search performance reports.',
                'price_idr'   => 200000,
                'price_usd'   => 12.00,
                'type'        => 'one_time',
                'tiers'       => null,
                'sort_order'  => 10,
            ],
        ];

        foreach ($addons as $row) {
            PackageAddon::updateOrCreate(
                ['slug' => $row['slug']],
                $row + ['is_visible' => true]
            );
        }
    }
}
