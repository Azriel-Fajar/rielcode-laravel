<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            [
                'question'         => 'How much does a Rielcode website cost?',
                'answer'           => 'Landing pages start at IDR 4,000,000 / $260. Custom multi-page sites run IDR 8 to 12M / $520 to $780. E-commerce from IDR 15M+ / $980+. All quotes are fixed-price, no hourly billing surprises.',
                'show_on_studio'   => true,
                'show_on_services' => true,
                'sort_order'       => 1,
            ],
            [
                'question'         => 'How long does a project take?',
                'answer'           => 'Landing pages: 1 to 2 weeks. Custom sites: 3 to 4 weeks. E-commerce: 4 to 6 weeks. Timeline depends on how quickly you provide content, feedback, and approvals.',
                'show_on_studio'   => true,
                'show_on_services' => true,
                'sort_order'       => 2,
            ],
            [
                'question'         => 'How many revisions are included?',
                'answer'           => 'Two rounds of design revisions per page. Additional rounds are billed at a flat rate agreed up front.',
                'show_on_studio'   => true,
                'show_on_services' => true,
                'sort_order'       => 3,
            ],
            [
                'question'         => 'Can I pay in IDR or USD?',
                'answer'           => 'Yes. Local clients pay in IDR via bank transfer. International clients pay in USD via international bank transfer or supported online payment methods.',
                'show_on_studio'   => true,
                'show_on_services' => false,
                'sort_order'       => 4,
            ],
            [
                'question'         => 'Do you provide hosting and domain?',
                'answer'           => 'Rielcode can set up hosting and domain on your behalf, billed at cost plus a small setup fee. You can also bring your own hosting. Most paid packages include 1 year of free hosting and domain.',
                'show_on_studio'   => true,
                'show_on_services' => false,
                'sort_order'       => 5,
            ],
            [
                'question'         => 'What happens after the site launches?',
                'answer'           => 'Every project includes 14 days of post-launch bug fixes. Ongoing support is available as a monthly retainer or pay-per-task.',
                'show_on_studio'   => true,
                'show_on_services' => false,
                'sort_order'       => 6,
            ],
            [
                'question'         => 'Do you work with international clients?',
                'answer'           => 'Yes, most of the pipeline is international. Communication is async via WhatsApp and email, project docs in English.',
                'show_on_studio'   => true,
                'show_on_services' => false,
                'sort_order'       => 7,
            ],
            [
                'question'         => 'What is your availability?',
                'answer'           => 'Currently taking limited projects. Use the contact form to check Q3 availability. First-come, first-served for project slots.',
                'show_on_studio'   => true,
                'show_on_services' => false,
                'sort_order'       => 8,
            ],
        ];

        foreach ($faqs as $row) {
            Faq::updateOrCreate(
                ['question' => $row['question']],
                $row + ['is_visible' => true]
            );
        }
    }
}
