<?php

namespace App\Support;

/**
 * Minimal vCard 3.0 builder.
 */
class VCard
{
    /**
     * Build a vCard string from a set of fields.
     *
     * @param array{full_name:string, email?:?string, phone?:?string, mobile?:?string, position?:?string, org?:?string, website?:?string} $data
     */
    public static function build(array $data): string
    {
        $fullName = trim($data['full_name'] ?? '');
        $parts    = $fullName === '' ? [''] : explode(' ', $fullName);
        $first    = $parts[0] ?? '';
        $last     = count($parts) > 1 ? implode(' ', array_slice($parts, 1)) : '';

        $lines = [
            'BEGIN:VCARD',
            'VERSION:3.0',
            'FN:' . self::esc($fullName),
            "N:" . self::esc($last) . ';' . self::esc($first) . ';;;',
        ];

        if (!empty($data['position'])) {
            $lines[] = 'TITLE:' . self::esc($data['position']);
        }
        if (!empty($data['org'])) {
            $lines[] = 'ORG:' . self::esc($data['org']);
        }
        if (!empty($data['email'])) {
            $lines[] = 'EMAIL;TYPE=WORK:' . self::esc($data['email']);
        }
        if (!empty($data['phone'])) {
            $lines[] = 'TEL;TYPE=CELL:' . self::esc($data['phone']);
        }
        if (!empty($data['mobile'])) {
            $lines[] = 'TEL;TYPE=CELL:' . self::esc($data['mobile']);
        }
        if (!empty($data['website'])) {
            $lines[] = 'URL:' . self::esc($data['website']);
        }

        $lines[] = 'END:VCARD';

        return implode("\r\n", $lines) . "\r\n";
    }

    private static function esc(string $value): string
    {
        return str_replace(["\\", "\n", ",", ";"], ["\\\\", "\\n", "\\,", "\\;"], $value);
    }
}
