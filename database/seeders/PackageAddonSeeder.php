<?php

namespace Database\Seeders;

use App\Models\PackageAddon;
use Illuminate\Database\Seeder;

class PackageAddonSeeder extends Seeder
{
    public function run(): void
    {
        $addons = [
            [
                'name'        => 'Extra Page',
                'description' => 'Add an additional fully-designed page beyond your plan.',
                'price_idr'   => 250000,
                'price_usd'   => 15.00,
                'type'        => 'per_page',
                'sort_order'  => 1,
            ],
            [
                'name'        => 'Blog / News Section',
                'description' => 'Self-managed blog with categories, tags, and a simple editor.',
                'price_idr'   => 500000,
                'price_usd'   => 30.00,
                'type'        => 'one_time',
                'sort_order'  => 2,
            ],
            [
                'name'        => 'Advanced SEO Package',
                'description' => 'Schema markup, sitemap, keyword research, on-page SEO tuning.',
                'price_idr'   => 400000,
                'price_usd'   => 24.00,
                'type'        => 'one_time',
                'sort_order'  => 3,
            ],
            [
                'name'        => 'Google Analytics + Search Console',
                'description' => 'Tracking setup, conversion goals, search performance reports.',
                'price_idr'   => 200000,
                'price_usd'   => 12.00,
                'type'        => 'one_time',
                'sort_order'  => 4,
            ],
            [
                'name'        => 'AI Chatbot Integration',
                'description' => 'OpenAI-powered chatbot trained on your brand and FAQ.',
                'price_idr'   => 750000,
                'price_usd'   => 45.00,
                'type'        => 'one_time',
                'sort_order'  => 5,
            ],
            [
                'name'        => 'WhatsApp Business Integration',
                'description' => 'Click-to-chat widget, auto-greeting, custom WhatsApp button.',
                'price_idr'   => 150000,
                'price_usd'   => 9.00,
                'type'        => 'one_time',
                'sort_order'  => 6,
            ],
            [
                'name'        => 'Custom Domain Setup',
                'description' => 'Domain purchase, DNS configuration, SSL, email forwarding.',
                'price_idr'   => 250000,
                'price_usd'   => 15.00,
                'type'        => 'one_time',
                'sort_order'  => 7,
            ],
            [
                'name'        => 'Maintenance and Updates',
                'description' => 'Monthly bug fixes, content updates, performance monitoring.',
                'price_idr'   => 350000,
                'price_usd'   => 21.00,
                'type'        => 'monthly',
                'sort_order'  => 8,
            ],
            [
                'name'        => 'Priority Delivery',
                'description' => 'Bump your project to the front of the queue, cut delivery time in half.',
                'price_idr'   => 500000,
                'price_usd'   => 30.00,
                'type'        => 'one_time',
                'sort_order'  => 9,
            ],
            [
                'name'        => 'Extra Revision Round',
                'description' => 'Additional round of design or content revisions beyond plan defaults.',
                'price_idr'   => 200000,
                'price_usd'   => 12.00,
                'type'        => 'one_time',
                'sort_order'  => 10,
            ],
        ];

        foreach ($addons as $row) {
            PackageAddon::updateOrCreate(
                ['name' => $row['name']],
                $row + ['is_visible' => true]
            );
        }
    }
}
