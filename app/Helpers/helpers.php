<?php

if (!function_exists('rupiah')) {
    /**
     * Format angka ke format Rupiah Indonesia
     */
    function rupiah(int|float $amount): string
    {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }
}

if (!function_exists('wa_link')) {
    /**
     * Generate link WhatsApp dengan pesan otomatis
     */
    function wa_link(string $number, string $message = ''): string
    {
        $number = preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $number));
        return 'https://wa.me/' . $number . ($message ? '?text=' . urlencode($message) : '');
    }
}