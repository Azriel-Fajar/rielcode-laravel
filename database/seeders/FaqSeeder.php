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
                'answer'           => 'Plans start at IDR 499,000 / $30 (Student Plan — 1 page, no hosting). The Starter Plan (1 page + free hosting & domain) is IDR 999,000 / $59. The Pro Plan (up to 5 pages + CMS) is IDR 2,499,000 / $148. The Premium Plan (up to 10 pages + e-commerce + AI chatbot) is IDR 4,999,000 / $295. All prices are fixed — no hourly billing surprises.',
                'show_on_studio'   => true,
                'show_on_services' => true,
                'sort_order'       => 1,
            ],
            [
                'question'         => 'How long does a project take?',
                'answer'           => 'Student Plan: 2–3 days. Starter Plan: 3–5 days. Pro Plan: 7–10 days. Premium Plan: 10–14 days. Custom projects: 7–30 days depending on scope. Timeline depends on how quickly you provide content, feedback, and approvals.',
                'show_on_studio'   => true,
                'show_on_services' => true,
                'sort_order'       => 2,
            ],
            [
                'question'         => 'How many revisions are included?',
                'answer'           => 'Revisions vary by plan: Student Plan includes 1 revision, Starter Plan 1 revision, Pro Plan 2 revisions, and Premium Plan 5 revisions. Additional revision rounds can be added as an addon.',
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
                'answer'           => 'Rielcode can set up hosting and domain on your behalf, billed at cost plus a small setup fee. You can also bring your own hosting. The Starter, Pro, and Premium plans all include 1 year of free hosting and a free domain (Student Plan does not).',
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
