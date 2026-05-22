<?php

namespace App\Http\Controllers;

class ServicesController extends Controller
{
    public function index()
    {
        $services = $this->loadServices();
        $addons   = $this->loadAddons();
        $faqs     = $this->loadServiceFaqs();

        return view('pages.services', compact('services', 'addons', 'faqs'));
    }

    private function parseYaml(string $block): array
    {
        $front = [];
        $lines = explode("\n", trim($block));
        $i = 0;

        while ($i < count($lines)) {
            $line = $lines[$i];

            // list field: key followed by list items on next lines
            if (preg_match('/^(\w+):\s*$/', $line, $m)) {
                $key = $m[1];
                $list = [];
                $i++;
                while ($i < count($lines) && preg_match('/^\s+-\s+(.+)$/', $lines[$i], $lm)) {
                    $list[] = trim($lm[1]);
                    $i++;
                }
                $front[$key] = $list;
                continue;
            }

            // inline list: key: [a, b]
            if (preg_match('/^(\w+):\s*\[(.*)]\s*$/', $line, $m)) {
                $front[$m[1]] = array_map('trim', explode(',', $m[2]));
                $i++;
                continue;
            }

            // scalar
            if (preg_match('/^(\w+):\s*(.*)$/', $line, $m)) {
                $val = trim($m[2], '"\'');
                $front[$m[1]] = $val === 'true' ? true : ($val === 'false' ? false : $val);
                $i++;
                continue;
            }

            $i++;
        }

        return $front;
    }

    private function loadServices(): array
    {
        $dir   = resource_path('content/services');
        $files = glob($dir . '/*.md');
        $items = [];

        foreach ($files as $file) {
            if (str_starts_with(basename($file), '_')) continue;

            $raw = file_get_contents($file);
            if (!preg_match('/^---\s*\n(.*?)\n---\s*\n?(.*)$/s', $raw, $m)) continue;

            $front = $this->parseYaml($m[1]);
            if (!empty($front['isAddon'])) continue;

            $items[] = [
                'id'           => $front['id'] ?? '',
                'title'        => $front['title'] ?? '',
                'priceIdr'     => $front['priceIdr'] ?? '',
                'priceUsd'     => $front['priceUsd'] ?? '',
                'timeline'     => $front['timeline'] ?? '',
                'deliverables' => $front['deliverables'] ?? [],
                'order'        => (int) ($front['order'] ?? 99),
            ];
        }

        usort($items, fn($a, $b) => $a['order'] <=> $b['order']);
        return $items;
    }

    private function loadAddons(): array
    {
        $file = resource_path('content/services/_addons.md');
        if (!file_exists($file)) return [];

        $raw = file_get_contents($file);
        if (!preg_match('/^---\s*\n(.*?)\n---\s*\n?/s', $raw, $m)) return [];

        // addons is a YAML list of objects: - item: ... / price: ...
        preg_match_all('/- item:\s*(.+)\n\s+price:\s*(.+)/', $m[1], $rows);
        $addons = [];
        foreach ($rows[1] as $idx => $item) {
            $addons[] = ['item' => trim($item), 'price' => trim($rows[2][$idx])];
        }
        return $addons;
    }

    private function loadServiceFaqs(): array
    {
        $dir   = resource_path('content/faq');
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

            if (empty($front['showOnServices'])) continue;

            $items[] = [
                'q'     => $front['question'] ?? '',
                'a'     => trim($m[2]),
                'order' => (int) ($front['order'] ?? 99),
            ];
        }

        usort($items, fn($a, $b) => $a['order'] <=> $b['order']);
        return array_slice($items, 0, 3);
    }
}
