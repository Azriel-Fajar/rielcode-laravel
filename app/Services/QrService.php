<?php

namespace App\Services;

use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrService
{
    public function png(string $data, int $size = 200): string
    {
        return QrCode::format('png')->size($size)->generate($data);
    }

    public function base64(string $data, int $size = 200): string
    {
        $png = $this->png($data, $size);

        return 'data:image/png;base64,'.base64_encode($png);
    }
}
