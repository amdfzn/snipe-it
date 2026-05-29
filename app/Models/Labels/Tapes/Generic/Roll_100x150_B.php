<?php

namespace App\Models\Labels\Tapes\Generic;

use App\Models\Labels\Label;

class Roll_100x150_B extends Label
{
    private const WIDTH  = 150.0; // mm (landscape)
    private const HEIGHT = 100.0; // mm
    private const MARGIN = 5.0;   // mm (all sides)

    // Layout
    private const QR_SIZE    = 65.0; // bigger than previous
    private const QR_ID_SIZE = 6.0;

    // Typography
    private const COMPANY_TEXT = 'UPA TIK';
    private const COMPANY_SIZE = 12.0;
    private const LABEL_SIZE   = 5.0;
    private const VALUE_SIZE   = 8.5;

    public function getUnit()
    {
        return 'mm';
    }

    public function getWidth()
    {
        return self::WIDTH;
    }

    public function getHeight()
    {
        return self::HEIGHT;
    }

    public function getMarginTop()
    {
        return self::MARGIN;
    }

    public function getMarginBottom()
    {
        return self::MARGIN;
    }

    public function getMarginLeft()
    {
        return self::MARGIN;
    }

    public function getMarginRight()
    {
        return self::MARGIN;
    }

    public function getSupportAssetTag()
    {
        return true;
    }

    public function getSupport1DBarcode()
    {
        return false;
    }

    public function getSupport2DBarcode()
    {
        return true;
    }

    public function getSupportFields()
    {
        return 3; // ID, ruang, tahun (sesuai setting kamu)
    }

    public function getSupportLogo()
    {
        return false; // tanpa logo
    }

    public function getSupportTitle()
    {
        return false; // title kita tulis manual: UPA TIK
    }

    public function preparePDF($pdf)
    {
        // no-op
    }

    private function getString($record, string $key): string
    {
        try {
            if ($record->has($key)) {
                return (string) $record->get($key);
            }
        } catch (\Throwable $e) {}
        return '';
    }

    private function yearOnly(string $value): string
    {
        $value = trim($value);
        if ($value === '') return '';

        // If format like 2023-01-01 or 2023/01/01
        $ts = strtotime($value);
        if ($ts !== false) {
            return date('Y', $ts);
        }

        // fallback: ambil 4 digit pertama yang keliatan
        if (preg_match('/\b(19|20)\d{2}\b/', $value, $m)) {
            return $m[0];
        }

        return $value;
    }

    private function getHardwareUrl(string $assetTag): string
    {
        $base = rtrim(config('app.url'), '/');
        return $base . '/hardware/' . urlencode($assetTag);
    }

    public function write($pdf, $record)
    {
        $pa = $this->getPrintableArea();

        // === Center vertical based on left block (QR + ID under QR) ===
        $leftBlockHeight = self::QR_SIZE + self::QR_ID_SIZE;
        $freeSpace = $pa->h - $leftBlockHeight;
        $vOffset = ($freeSpace > 0) ? ($freeSpace / 2) : 0;

        $x = $pa->x1;
        $y = $pa->y1 + $vOffset;

        $assetTag = $this->getString($record, 'tag');

        /*
         * =========================
         * LEFT: QR + ID under QR
         * =========================
         */
        if ($assetTag) {
            static::write2DBarcode(
                $pdf,
                $this->getHardwareUrl($assetTag),
                'QRCODE',
                $x, $y,
                self::QR_SIZE, self::QR_SIZE
            );

            static::writeText(
                $pdf,
                $assetTag,
                $x,
                $y + self::QR_SIZE,
                'freemono', 'b',
                self::QR_ID_SIZE,
                'C',
                self::QR_SIZE,
                self::QR_ID_SIZE,
                true, 0
            );
        }

        /*
         * =========================
         * RIGHT: UPA TIK + fields
         * =========================
         */
        $textX = $x + self::QR_SIZE + 8;
        $textY = $y;

        $usableWidth = $pa->x2 - $textX;
        if ($usableWidth < 10) $usableWidth = 10;

        // Company (bigger)
        static::writeText(
            $pdf,
            self::COMPANY_TEXT,
            $textX,
            $textY,
            'freesans', 'B',
            self::COMPANY_SIZE,
            'L',
            $usableWidth,
            12,
            true,
            0
        );

        $textY += 14;

        // ID label + value
        static::writeText(
            $pdf,
            'ID',
            $textX,
            $textY,
            'freesans', '',
            self::LABEL_SIZE,
            'L',
            $usableWidth,
            6,
            true,
            0
        );
        $textY += 5;

        static::writeText(
            $pdf,
            $assetTag ?: '-',
            $textX,
            $textY,
            'freemono', 'B',
            self::VALUE_SIZE,
            'L',
            $usableWidth,
            8,
            true,
            0
        );
        $textY += 10;

        // Other fields: ruang, tahun
        try {
            foreach ($record->get('fields') as $f) {
                $label = strtolower(trim((string)($f['label'] ?? '')));
                $value = trim((string)($f['value'] ?? ''));

                if ($label === '' || $value === '') continue;
                if ($label === 'id') continue;

                if ($label === 'tahun') {
                    $value = $this->yearOnly($value);
                }

                // label
                static::writeText(
                    $pdf,
                    $label,
                    $textX,
                    $textY,
                    'freesans', '',
                    self::LABEL_SIZE,
                    'L',
                    $usableWidth,
                    6,
                    true,
                    0
                );
                $textY += 5;

                // value
                static::writeText(
                    $pdf,
                    $value,
                    $textX,
                    $textY,
                    'freemono', 'B',
                    self::VALUE_SIZE,
                    'L',
                    $usableWidth,
                    8,
                    true,
                    0
                );
                $textY += 10;
            }
        } catch (\Throwable $e) {
            // ignore
        }
    }
}
