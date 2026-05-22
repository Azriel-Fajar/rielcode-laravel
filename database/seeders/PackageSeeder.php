<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    public function run(): void
    {
        $packages = [
            [
                'slug'                  => 'landing',
                'package_name'          => 'Student Plan',
                'blurb'                 => 'Perfect for students and personal projects. Does not include free hosting or domain.',
                'idr_price'             => 499000,
                'us_price'              => 30.00,
                'original_idr'          => 998000,
                'original_us'           => 59.00,
                'delivery_days_min'     => 2,
                'delivery_days_max'     => 3,
                'includes_free_hosting' => false,
                'includes_free_domain'  => false,
                'is_popular'            => false,
                'badge_color'           => 'green',
                'features_json'         => [
                    '1 page website (single page)',
                    'Responsive design',
                    'Contact form + CTA section',
                    'Basic SEO setup',
                    'Social media + WhatsApp integration',
                    '1x minor revision',
                ],
                'is_visible'            => true,
                'sort_order'            => 1,
            ],
            [
                'slug'                  => 'starter',
                'package_name'          => 'Starter Plan',
                'blurb'                 => 'A clean, focused landing page to launch your idea.',
                'idr_price'             => 999000,
                'us_price'              => 59.00,
                'original_idr'          => 1998000,
                'original_us'           => 118.00,
                'delivery_days_min'     => 3,
                'delivery_days_max'     => 5,
                'includes_free_hosting' => true,
                'includes_free_domain'  => true,
                'is_popular'            => false,
                'badge_color'           => 'blue',
                'features_json'         => [
                    'Landing page website (1 page)',
                    'Responsive layout',
                    'Modern and clean design',
                    'Social media links integration',
                    'Basic SEO setup',
                    '1 Design revision',
                ],
                'is_visible'            => true,
                'sort_order'            => 2,
            ],
            [
                'slug'                  => 'pro',
                'package_name'          => 'Pro Plan',
                'blurb'                 => 'A multi-page business site built to grow.',
                'idr_price'             => 2499000,
                'us_price'              => 148.00,
                'original_idr'          => 4998000,
                'original_us'           => 296.00,
                'delivery_days_min'     => 7,
                'delivery_days_max'     => 10,
                'includes_free_hosting' => true,
                'includes_free_domain'  => true,
                'is_popular'            => true,
                'badge_color'           => 'blue',
                'features_json'         => [
                    'All in Starter, plus:',
                    'Up to 5 custom pages',
                    'Custom UI/UX design request',
                    'Content Management System (CMS)',
                    'Advanced SEO setup',
                    '2 Design revisions',
                    '1 month of technical support',
                ],
                'is_visible'            => true,
                'sort_order'            => 3,
            ],
            [
                'slug'                  => 'business',
                'package_name'          => 'Premium Plan',
                'blurb'                 => 'Full-scale platform with e-commerce and admin tooling.',
                'idr_price'             => 4999000,
                'us_price'              => 295.00,
                'original_idr'          => 9998000,
                'original_us'           => 589.00,
                'delivery_days_min'     => 10,
                'delivery_days_max'     => 14,
                'includes_free_hosting' => true,
                'includes_free_domain'  => true,
                'is_popular'            => false,
                'badge_color'           => 'amber',
                'features_json'         => [
                    'All in Pro, plus:',
                    'Up to 10 custom pages',
                    'AI Chatbot Integration',
                    'Custom UI/UX design request',
                    'Advanced custom-coded Admin Panel',
                    'Complete SEO setup',
                    '5 design revisions',
                    '2 months of technical support',
                    'Performance optimization',
                ],
                'is_visible'            => true,
                'sort_order'            => 4,
            ],
            [
                'slug'                  => 'custom',
                'package_name'          => 'Custom Plan',
                'blurb'                 => 'Build your own plan, only pay for what you actually need.',
                'idr_price'             => 500000,
                'us_price'              => 30.00,
                'original_idr'          => null,
                'original_us'           => null,
                'delivery_days_min'     => 7,
                'delivery_days_max'     => 30,
                'includes_free_hosting' => false,
                'includes_free_domain'  => false,
                'is_popular'            => false,
                'badge_color'           => 'gray',
                'features_json'         => [
                    'Any number of pages',
                    'Chatbot integration',
                    'Login / member system',
                    'CMS / Admin Panel',
                    'E-Commerce',
                    'Maintenance (per month)',
                    'Priority delivery',
                    'Free hosting and domain from IDR 1jt',
                ],
                'is_visible'            => true,
                'sort_order'            => 5,
            ],
        ];

        foreach ($packages as $pkg) {
            Package::updateOrCreate(
                ['slug' => $pkg['slug']],
                $pkg
            );
        }
    }
}
