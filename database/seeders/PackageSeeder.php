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
                'slug' => 'landing',
                'package_name' => 'Student Plan',
                'blurb' => 'Perfect for students and personal projects. Does not include free hosting or domain.',
                'idr_price' => 499000,
                'us_price' => 30.00,
                'original_idr' => 998000,
                'original_us' => 59.00,
                'delivery_days_min' => 2,
                'delivery_days_max' => 3,
                'includes_free_hosting' => false,
                'includes_free_domain' => false,
                'is_popular' => false,
                'badge_color' => 'green',
                'features_json' => [
                    'sections' => [
                        [
                            'title' => 'Domain',
                            'items' => [
                                ['label' => 'Free .com / .net / .org', 'included' => false],
                                ['label' => 'Free .id / .my.id', 'included' => false],
                                ['label' => 'Free .co.id', 'included' => false],
                            ],
                        ],
                        [
                            'title' => 'Hosting & SSL',
                            'items' => [
                                ['label' => 'Free hosting 1 year', 'included' => false],
                                ['label' => 'Free SSL certificate', 'included' => true],
                                ['label' => 'Daily backup', 'included' => false],
                            ],
                        ],
                        [
                            'title' => 'Security',
                            'items' => [
                                ['label' => 'Firewall protection', 'included' => false],
                                ['label' => 'Malware scan', 'included' => false],
                            ],
                        ],
                        [
                            'title' => 'Pages & CMS',
                            'items' => [
                                ['label' => '1 page', 'included' => true],
                                ['label' => 'Up to 5 custom pages', 'included' => false],
                                ['label' => 'Up to 10 custom pages', 'included' => false],
                                ['label' => 'CMS / Admin panel', 'included' => false],
                                ['label' => 'AI chatbot', 'included' => false],
                                ['label' => 'E-commerce', 'included' => false],
                            ],
                        ],
                        [
                            'title' => 'SEO & Performance',
                            'items' => [
                                ['label' => 'Basic on-page SEO', 'included' => true],
                                ['label' => 'Advanced SEO', 'included' => false],
                                ['label' => 'Performance optimization', 'included' => false],
                            ],
                        ],
                        [
                            'title' => 'Support',
                            'items' => [
                                ['label' => '1 design revision', 'included' => true],
                                ['label' => '2 design revisions', 'included' => false],
                                ['label' => '5 design revisions', 'included' => false],
                                ['label' => '1 month support', 'included' => false],
                                ['label' => '2 months support', 'included' => false],
                            ],
                        ],
                    ],
                ],
                'included_addons' => [],
                'is_visible' => true,
                'sort_order' => 1,
            ],
            [
                'slug' => 'starter',
                'package_name' => 'Starter Plan',
                'blurb' => 'A clean, focused landing page to launch your idea.',
                'idr_price' => 999000,
                'us_price' => 59.00,
                'original_idr' => 1998000,
                'original_us' => 118.00,
                'delivery_days_min' => 3,
                'delivery_days_max' => 5,
                'includes_free_hosting' => true,
                'includes_free_domain' => true,
                'is_popular' => false,
                'badge_color' => 'blue',
                'features_json' => [
                    'sections' => [
                        [
                            'title' => 'Domain',
                            'items' => [
                                ['label' => 'Free .com / .net / .org', 'included' => true],
                                ['label' => 'Free .id / .my.id', 'included' => false],
                                ['label' => 'Free .co.id', 'included' => false],
                            ],
                        ],
                        [
                            'title' => 'Hosting & SSL',
                            'items' => [
                                ['label' => 'Free hosting 1 year', 'included' => true],
                                ['label' => 'Free SSL certificate', 'included' => true],
                                ['label' => 'Daily backup', 'included' => false],
                            ],
                        ],
                        [
                            'title' => 'Security',
                            'items' => [
                                ['label' => 'Firewall protection', 'included' => true],
                                ['label' => 'Malware scan', 'included' => false],
                            ],
                        ],
                        [
                            'title' => 'Pages & CMS',
                            'items' => [
                                ['label' => '1 page', 'included' => true],
                                ['label' => 'Up to 5 custom pages', 'included' => false],
                                ['label' => 'Up to 10 custom pages', 'included' => false],
                                ['label' => 'CMS / Admin panel', 'included' => false],
                                ['label' => 'AI chatbot', 'included' => false],
                                ['label' => 'E-commerce', 'included' => false],
                            ],
                        ],
                        [
                            'title' => 'SEO & Performance',
                            'items' => [
                                ['label' => 'Basic on-page SEO', 'included' => true],
                                ['label' => 'Advanced SEO', 'included' => false],
                                ['label' => 'Performance optimization', 'included' => false],
                            ],
                        ],
                        [
                            'title' => 'Support',
                            'items' => [
                                ['label' => '1 design revision', 'included' => true],
                                ['label' => '2 design revisions', 'included' => false],
                                ['label' => '5 design revisions', 'included' => false],
                                ['label' => '1 month support', 'included' => false],
                                ['label' => '2 months support', 'included' => false],
                            ],
                        ],
                    ],
                ],
                'included_addons' => [],
                'is_visible' => true,
                'sort_order' => 2,
            ],
            [
                'slug' => 'pro',
                'package_name' => 'Pro Plan',
                'blurb' => 'A multi-page business site built to grow.',
                'idr_price' => 2499000,
                'us_price' => 148.00,
                'original_idr' => 4998000,
                'original_us' => 296.00,
                'delivery_days_min' => 7,
                'delivery_days_max' => 10,
                'includes_free_hosting' => true,
                'includes_free_domain' => true,
                'is_popular' => true,
                'badge_color' => 'blue',
                'features_json' => [
                    'sections' => [
                        [
                            'title' => 'Domain',
                            'items' => [
                                ['label' => 'Free .com / .net / .org', 'included' => true],
                                ['label' => 'Free .id / .my.id', 'included' => true],
                                ['label' => 'Free .co.id', 'included' => false],
                            ],
                        ],
                        [
                            'title' => 'Hosting & SSL',
                            'items' => [
                                ['label' => 'Free hosting 1 year', 'included' => true],
                                ['label' => 'Free SSL certificate', 'included' => true],
                                ['label' => 'Daily backup', 'included' => true],
                            ],
                        ],
                        [
                            'title' => 'Security',
                            'items' => [
                                ['label' => 'Firewall protection', 'included' => true],
                                ['label' => 'Malware scan', 'included' => true],
                            ],
                        ],
                        [
                            'title' => 'Pages & CMS',
                            'items' => [
                                ['label' => '1 page', 'included' => false],
                                ['label' => 'Up to 5 custom pages', 'included' => true],
                                ['label' => 'Up to 10 custom pages', 'included' => false],
                                ['label' => 'CMS / Admin panel', 'included' => true],
                                ['label' => 'AI chatbot', 'included' => false],
                                ['label' => 'E-commerce', 'included' => false],
                            ],
                        ],
                        [
                            'title' => 'SEO & Performance',
                            'items' => [
                                ['label' => 'Basic on-page SEO', 'included' => true],
                                ['label' => 'Advanced SEO', 'included' => true],
                                ['label' => 'Performance optimization', 'included' => false],
                            ],
                        ],
                        [
                            'title' => 'Support',
                            'items' => [
                                ['label' => '1 design revision', 'included' => false],
                                ['label' => '2 design revisions', 'included' => true],
                                ['label' => '5 design revisions', 'included' => false],
                                ['label' => '1 month support', 'included' => true],
                                ['label' => '2 months support', 'included' => false],
                            ],
                        ],
                    ],
                ],
                'included_addons' => ['seo'],
                'included_tiers' => ['cms' => 'Basic'],
                'is_visible' => true,
                'sort_order' => 3,
            ],
            [
                'slug' => 'business',
                'package_name' => 'Premium Plan',
                'blurb' => 'Full-scale platform with e-commerce and admin tooling.',
                'idr_price' => 4999000,
                'us_price' => 295.00,
                'original_idr' => 9998000,
                'original_us' => 589.00,
                'delivery_days_min' => 10,
                'delivery_days_max' => 14,
                'includes_free_hosting' => true,
                'includes_free_domain' => true,
                'is_popular' => false,
                'badge_color' => 'amber',
                'features_json' => [
                    'sections' => [
                        [
                            'title' => 'Domain',
                            'items' => [
                                ['label' => 'Free .com / .net / .org', 'included' => true],
                                ['label' => 'Free .id / .my.id', 'included' => true],
                                ['label' => 'Free .co.id', 'included' => true],
                            ],
                        ],
                        [
                            'title' => 'Hosting & SSL',
                            'items' => [
                                ['label' => 'Free hosting 1 year', 'included' => true],
                                ['label' => 'Free SSL certificate', 'included' => true],
                                ['label' => 'Daily backup', 'included' => true],
                            ],
                        ],
                        [
                            'title' => 'Security',
                            'items' => [
                                ['label' => 'Firewall protection', 'included' => true],
                                ['label' => 'Malware scan', 'included' => true],
                            ],
                        ],
                        [
                            'title' => 'Pages & CMS',
                            'items' => [
                                ['label' => '1 page', 'included' => false],
                                ['label' => 'Up to 5 custom pages', 'included' => false],
                                ['label' => 'Up to 10 custom pages', 'included' => true],
                                ['label' => 'CMS / Admin panel', 'included' => true],
                                ['label' => 'AI chatbot', 'included' => true],
                                ['label' => 'E-commerce', 'included' => true],
                            ],
                        ],
                        [
                            'title' => 'SEO & Performance',
                            'items' => [
                                ['label' => 'Basic on-page SEO', 'included' => true],
                                ['label' => 'Advanced SEO', 'included' => true],
                                ['label' => 'Performance optimization', 'included' => true],
                            ],
                        ],
                        [
                            'title' => 'Support',
                            'items' => [
                                ['label' => '1 design revision', 'included' => false],
                                ['label' => '2 design revisions', 'included' => false],
                                ['label' => '5 design revisions', 'included' => true],
                                ['label' => '1 month support', 'included' => false],
                                ['label' => '2 months support', 'included' => true],
                            ],
                        ],
                    ],
                ],
                'included_addons' => ['seo', 'chatbot'],
                'included_tiers' => ['cms' => 'Standard', 'ecom' => 'Basic'],
                'is_visible' => true,
                'sort_order' => 4,
            ],
            [
                'slug' => 'custom',
                'package_name' => 'Custom Plan',
                'blurb' => 'Starting from IDR 500k. Pay only for what you actually need.',
                'idr_price' => 500000,
                'us_price' => 30.00,
                'original_idr' => null,
                'original_us' => null,
                'delivery_days_min' => 7,
                'delivery_days_max' => 30,
                'includes_free_hosting' => false,
                'includes_free_domain' => false,
                'is_popular' => false,
                'badge_color' => 'gray',
                'features_json' => [
                    'sections' => [
                        [
                            'title' => 'Domain',
                            'items' => [
                                ['label' => 'Free .com / .net / .org', 'included' => true],
                                ['label' => 'Free .id / .my.id', 'included' => true],
                                ['label' => 'Free .co.id', 'included' => true],
                            ],
                        ],
                        [
                            'title' => 'Hosting & SSL',
                            'items' => [
                                ['label' => 'Free hosting 1 year', 'included' => true],
                                ['label' => 'Free SSL certificate', 'included' => true],
                                ['label' => 'Daily backup', 'included' => true],
                            ],
                        ],
                        [
                            'title' => 'Security',
                            'items' => [
                                ['label' => 'Firewall protection', 'included' => true],
                                ['label' => 'Malware scan', 'included' => true],
                            ],
                        ],
                        [
                            'title' => 'Pages & CMS',
                            'items' => [
                                ['label' => '1 page', 'included' => true],
                                ['label' => 'Up to 5 custom pages', 'included' => true],
                                ['label' => 'Up to 10 custom pages', 'included' => true],
                                ['label' => 'CMS / Admin panel', 'included' => true],
                                ['label' => 'AI chatbot', 'included' => true],
                                ['label' => 'E-commerce', 'included' => true],
                            ],
                        ],
                        [
                            'title' => 'SEO & Performance',
                            'items' => [
                                ['label' => 'Basic on-page SEO', 'included' => true],
                                ['label' => 'Advanced SEO', 'included' => true],
                                ['label' => 'Performance optimization', 'included' => true],
                            ],
                        ],
                        [
                            'title' => 'Support',
                            'items' => [
                                ['label' => '1 design revision', 'included' => true],
                                ['label' => '2 design revisions', 'included' => true],
                                ['label' => '5 design revisions', 'included' => true],
                                ['label' => '1 month support', 'included' => true],
                                ['label' => '2 months support', 'included' => true],
                            ],
                        ],
                    ],
                ],
                'included_addons' => [],
                'is_visible' => true,
                'sort_order' => 5,
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
