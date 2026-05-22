<?php

namespace App\Http\Controllers;

class StudioController extends Controller
{
    public function index()
    {
        $faqs = $this->loadFaqs();
        return view('pages.studio', compact('faqs'));
    }

    private function loadFaqs(): array
    {
        $dir = resource_path('content/faq');
        $files = glob($dir . '/*.md');
        $items = [];

        foreach ($files as $file) {
            $raw = file_get_contents($file);
            if (!preg_match('/^---\s*\n(.*?)\n---\s*\n(.*)$/s', $raw, $m)) continue;

            $front = [];
            foreach (explode("\n", trim($m[1])) as $line) {
                if (preg_match('/^(\w+):\s*(.+)$/', $line, $lm)) {
                    $front[$lm[1]] = trim($lm[2]);
                }
            }

            $items[] = [
                'q' => $front['question'] ?? '',
                'a' => trim($m[2]),
                'order' => (int) ($front['order'] ?? 99),
            ];
        }

        usort($items, fn($a, $b) => $a['order'] <=> $b['order']);
        return $items;
    }
}
