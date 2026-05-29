<?php

namespace App\Models\Labels\Tapes\Generic;

use App\Models\Labels\Label;

class Roll_100x150_A extends Label
{
    private const WIDTH  = 150.0;
    private const HEIGHT = 100.0;

    // Margin 5mm
    private const MARGIN = 5.0;

    // Layout
    private const QR_SIZE    = 55.0;  // QR diperkecil (sebelumnya 60)
    private const QR_ID_SIZE = 6.0;   // ID kecil bawah QR

    private const LOGO_WIDTH = 22.0;  // logo kecil

    private const TITLE_SIZE = 8.0;
    private const LABEL_SIZE = 5.0;
    private const VALUE_SIZE = 8.0;

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
    public function getSupportFields() { return 3; } // ID, ruang, tahun (sesuai setting kamu)
    public function getSupportLogo() { return true; }
    public function getSupportTitle() { return true; }

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

    private function getCompanyTitle($record): string
    {
        $company = $this->getString($record, 'company');
        return $company ?: 'UPA TIK Universitas Riau';
    }

    private function getLogoPath($record): string
    {
        try {
            if ($record->has('logo')) {
                $logo = (string) $record->get('logo');
                if ($logo && file_exists($logo)) return $logo;
            }
        } catch (\Throwable $e) {}

        return public_path('img/logo-unri.png');
    }

    // QR pakai URL default hardware/{id} (sesuai dropdown kamu)
    private function getDefaultHardwareUrl(string $assetTag): string
    {
        $base = 'http://103.10.169.168';
        return rtrim($base, '/') . '/hardware/' . urlencode($assetTag);
    }

    public function write($pdf, $record)
    {
        $pa = $this->getPrintableArea();

        // =========================
        // Vertical centering (turunin ke tengah)
        // =========================
        $leftBlockHeight = self::QR_SIZE + self::QR_ID_SIZE;
        $freeSpace = $pa->h - $leftBlockHeight;
        $vOffset = ($freeSpace > 0) ? ($freeSpace / 2) : 0;

        $x = $pa->x1;
        $y = $pa->y1 + $vOffset;

        $assetTag = $this->getString($record, 'tag');

        // =========================
        // KIRI: QR + ID bawah QR
        // =========================
        if ($assetTag) {
            static::write2DBarcode(
                $pdf,
                $this->getDefaultHardwareUrl($assetTag),
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

        // =========================
        // KANAN: teks + logo
        // =========================
        $textX = $x + self::QR_SIZE + 10;
        $textY = $y;

        $usableWidth = ($pa->x2 - $textX) - self::LOGO_WIDTH - 5;
        if ($usableWidth < 10) $usableWidth = 10;

        // Title (company)
        static::writeText(
            $pdf,
            $this->getCompanyTitle($record),
            $textX,
            $textY,
            'freesans',
            'B',
            self::TITLE_SIZE,
            'L',
            $usableWidth,
            10,
            true,
            0
        );

        // Logo kanan atas sejajar title
        $logoPath = $this->getLogoPath($record);
        if ($logoPath && file_exists($logoPath)) {
            static::writeImage(
                $pdf,
                $logoPath,
                $pa->x2 - self::LOGO_WIDTH,
                $textY,
                self::LOGO_WIDTH,
                self::LOGO_WIDTH,
                'L',
                'T',
                300,
                true,
                false,
                0
            );
        }

        $textY += 12;

        // =========================
        // ID juga tampil di atas ruang
        // =========================
        static::writeText(
            $pdf,
            'ID',
            $textX,
            $textY,
            'freesans',
            '',
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
            'freemono',
            'B',
            self::VALUE_SIZE,
            'L',
            $usableWidth,
            8,
            true,
            0
        );
        $textY += 10;

        // =========================
        // Fields otomatis dari setting (skip ID)
        // =========================
        $fields = [];
        try {
            foreach ($record->get('fields') as $f) {
                $label = strtolower(trim((string)($f['label'] ?? '')));
                $value = trim((string)($f['value'] ?? ''));

                if (!$label || !$value) continue;
                if ($label === 'id') continue;

                $fields[] = ['label' => $label, 'value' => $value];
            }
        } catch (\Throwable $e) {}

        foreach ($fields as $field) {
            static::writeText(
                $pdf,
                $field['label'],
                $textX,
                $textY,
                'freesans',
                '',
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
                $field['value'],
                $textX,
                $textY,
                'freemono',
                'B',
                self::VALUE_SIZE,
                'L',
                $usableWidth,
                8,
                true,
                0
            );
            $textY += 10;
        }
    }
}
