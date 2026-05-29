<?php

namespace App\Models\Labels\Tapes\Generic;

use App\Models\Labels\Label;

class Roll_50x20 extends Label
{
    private const WIDTH  = 50.0;
    private const HEIGHT = 20.0;

    private const MARGIN = 2.0;

    // QR
    private const QR_SIZE = 16.0;

    // Typography
    private const TITLE_TEXT = 'UPA TIK';
    private const TITLE_SIZE = 7.0;
    private const ID_SIZE    = 7.5;

    public function getUnit() { return 'mm'; }
    public function getWidth() { return self::WIDTH; }
    public function getHeight() { return self::HEIGHT; }

    public function getMarginTop() { return self::MARGIN; }
    public function getMarginBottom() { return self::MARGIN; }
    public function getMarginLeft() { return self::MARGIN; }
    public function getMarginRight() { return self::MARGIN; }

    public function getSupportAssetTag() { return true; }
    public function getSupport1DBarcode() { return false; }
    public function getSupport2DBarcode() { return true; }

    public function getSupportFields() { return 0; }
    public function getSupportLogo() { return false; }
    public function getSupportTitle() { return false; }

    public function preparePDF($pdf) {}

    private function getString($record, string $key): string
    {
        try {
            if ($record->has($key)) {
                return (string) $record->get($key);
            }
        } catch (\Throwable $e) {}
        return '';
    }

    private function getHardwareUrl(string $assetTag): string
    {
        $base = rtrim(config('app.url'), '/');
        return $base . '/hardware/' . urlencode($assetTag);
    }

    public function write($pdf, $record)
    {
        $pa = $this->getPrintableArea();

        $x = $pa->x1;

        // ✅ QR tetap di posisi normal
        $qrY = $pa->y1;

        // ✅ teks saja yang dinaikkan
        $textYBase = $pa->y1 - 1.5;

        $assetTag = $this->getString($record, 'tag');

        // ===== LEFT: QR =====
        if ($assetTag) {
            static::write2DBarcode(
                $pdf,
                $this->getHardwareUrl($assetTag),
                'QRCODE',
                $x,
                $qrY,
                self::QR_SIZE,
                self::QR_SIZE
            );
        }

        // ===== RIGHT: TEXT =====
        $textX = $x + self::QR_SIZE + 2;
        $textWidth = $pa->x2 - $textX;

        // posisi teks (naik)
        $titleY = $textYBase + 1;
        $idY    = $titleY + 7;

        // UPA TIK
        static::writeText(
            $pdf,
            self::TITLE_TEXT,
            $textX,
            $titleY,
            'freesans',
            'B',
            self::TITLE_SIZE,
            'L',
            $textWidth,
            8,
            true,
            0
        );

        // ID Barang
        static::writeText(
            $pdf,
            $assetTag ?: '-',
            $textX,
            $idY,
            'freemono',
            'B',
            self::ID_SIZE,
            'L',
            $textWidth,
            8,
            true,
            0
        );
    }
}
