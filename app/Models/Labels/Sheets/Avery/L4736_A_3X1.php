<?php

namespace App\Models\Labels\Sheets\Avery;

class L4736_A_3x1 extends L4736
{
    // Layout label kecil: QR kiri, teks kanan (2 baris)
    private const QR_SIZE = 8.0;   // mm
    private const GAP     = 0.8;   // mm jarak QR ke teks

    private const LINE1_SIZE = 2.6; // baris 1
    private const LINE2_SIZE = 2.6; // baris 2
    private const LINE_H     = 3.4; // tinggi baris

    public function getUnit() { return 'mm'; }

    public function getLabelMarginTop()    { return 0.06; }
    public function getLabelMarginBottom() { return 0.06; }
    public function getLabelMarginLeft()   { return 0.06; }
    public function getLabelMarginRight()  { return 0.06; }

    public function getSupportAssetTag() { return true; }
    public function getSupport1DBarcode() { return false; }
    public function getSupport2DBarcode() { return true; }

    public function getSupportFields() { return 0; }
    public function getSupportLogo()   { return false; }
    public function getSupportTitle()  { return false; }

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

    private function formatTagTwoLines(string $tag): array
    {
        $tag = trim($tag);
        if ($tag === '') {
            return ['', ''];
        }

        // split by '-' dan rapikan
        $parts = array_values(array_filter(array_map('trim', explode('-', $tag)), fn($p) => $p !== ''));

        // kalau format normal UNRI-UTBK-2026-00001
        if (count($parts) >= 3) {
            $line1 = $parts[0] . '-' . $parts[1];
            $line2 = implode('-', array_slice($parts, 2));
            return [$line1, $line2];
        }

        // fallback: kalau cuma 1-2 segmen, tampilkan saja di baris 1
        if (count($parts) === 2) {
            return [$parts[0] . '-' . $parts[1], ''];
        }

        return [$tag, ''];
    }

    public function write($pdf, $record)
    {
        $pa = $this->getLabelPrintableArea();

        $x = $pa->x1;
        $y = $pa->y1;
        $w = $pa->w;
        $h = $pa->h;

        // QR size jangan lebih besar dari tinggi label
        $qr = min(self::QR_SIZE, $h);
        $qrY = $y + max(0, ($h - $qr) / 2);

        // ===== QR kiri =====
        if ($record->has('barcode2d')) {
            static::write2DBarcode(
                $pdf,
                $record->get('barcode2d')->content,
                $record->get('barcode2d')->type,
                $x,
                $qrY,
                $qr,
                $qr
            );
        }

        // ===== Text kanan =====
        $textX = $x + $qr + self::GAP;
        $textW = $w - ($qr + self::GAP);
        if ($textW < 6) {
            return; // terlalu sempit
        }

        $tag = $this->getString($record, 'tag');
        [$line1, $line2] = $this->formatTagTwoLines($tag);

        // bikin text agak center vertikal untuk 2 baris
        $totalTextH = self::LINE_H * 2;
        $textStartY = $y + max(0, ($h - $totalTextH) / 2);

        // Baris 1: UNRI-UTBK
        static::writeText(
            $pdf,
            $line1,
            $textX,
            $textStartY,
            'freesans',
            'B',
            self::LINE1_SIZE,
            'L',
            $textW,
            self::LINE_H,
            true,
            0
        );

        // Baris 2: 2026-***
        static::writeText(
            $pdf,
            $line2,
            $textX,
            $textStartY + self::LINE_H,
            'freesans',
            'B',
            self::LINE2_SIZE,
            'L',
            $textW,
            self::LINE_H,
            true,
            0
        );
    }
}