<?php

namespace App\Support;

/**
 * Cardifys avatar generator — faithful port of the brand avatar styles.
 * Renders deterministic initials avatars as inline SVG (no assets).
 */
class Avatar
{
    private const PURPLE      = '#B884FF';
    private const PURPLE_DEEP = '#854ECE';
    private const DARK        = '#0A0E14';

    public const DEFAULT_STYLE = 'dark-white';

    /** Selectable styles: key => human label. */
    public const STYLES = [
        'dark-white'   => 'Anel',
        'dark-duo'     => 'Duotone',
        'dark-glow'    => 'Brilho',
        'purple-solid' => 'Gradiente',
    ];

    /** Sequence counter so gradient/glow ids never collide within a page. */
    private static int $seq = 0;

    public static function isValidStyle(?string $style): bool
    {
        return $style !== null && array_key_exists($style, self::STYLES);
    }

    /**
     * Initials: single word → first letter; otherwise first + last initials.
     */
    public static function initials(string $name): string
    {
        $parts = array_values(array_filter(preg_split('/\s+/', trim($name)) ?: []));

        if (count($parts) === 0) {
            return '?';
        }
        if (count($parts) === 1) {
            return mb_strtoupper(mb_substr($parts[0], 0, 1));
        }

        return mb_strtoupper(mb_substr($parts[0], 0, 1) . mb_substr(end($parts), 0, 1));
    }

    /**
     * Build the avatar SVG markup for a name + style.
     */
    public static function svg(string $name, ?string $style = null, int $size = 96): string
    {
        $style   = self::isValidStyle($style) ? $style : self::DEFAULT_STYLE;
        $letters = self::initials($name);
        $r       = $size / 2;
        $fontSize = mb_strlen($letters) === 1 ? $size * 0.42 : $size * 0.36;
        $uid      = 'a' . (++self::$seq);
        $ringW    = max(1, $size * 0.01);
        $whiteW   = max(1, $size * 0.006);

        // Letters — duotone splits first letter white, second purple.
        if ($style === 'dark-duo' && mb_strlen($letters) === 2) {
            $inner = '<tspan fill="white">' . e(mb_substr($letters, 0, 1)) . '</tspan>'
                   . '<tspan fill="' . self::PURPLE . '">' . e(mb_substr($letters, 1, 1)) . '</tspan>';
        } else {
            $inner = '<tspan fill="white">' . e($letters) . '</tspan>';
        }

        // Vertical centering: dy≈0.34em (half the uppercase cap-height) is far
        // more consistent across renderers than dominant-baseline="central".
        $text = '<text x="50%" y="50%" dy="0.34em" text-anchor="middle" '
              . 'font-family="Geist, Arial, sans-serif" font-weight="700" font-size="' . $fontSize . '">'
              . $inner . '</text>';

        $ring = '<circle cx="' . $r . '" cy="' . $r . '" r="' . ($r - $ringW) . '" fill="none" '
              . 'stroke="' . self::PURPLE . '" stroke-opacity="0.22" stroke-width="' . $ringW . '"/>';

        $open = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 ' . $size . ' ' . $size . '" '
              . 'width="' . $size . '" height="' . $size . '" style="border-radius:50%;display:block;">';

        if ($style === 'purple-solid') {
            return $open
                . '<defs><linearGradient id="g' . $uid . '" x1="0" y1="0" x2="1" y2="1">'
                . '<stop offset="0%" stop-color="' . self::PURPLE . '"/>'
                . '<stop offset="100%" stop-color="' . self::PURPLE_DEEP . '"/></linearGradient></defs>'
                . '<circle cx="' . $r . '" cy="' . $r . '" r="' . $r . '" fill="url(#g' . $uid . ')"/>'
                . '<circle cx="' . $r . '" cy="' . $r . '" r="' . ($r - $whiteW) . '" fill="none" '
                . 'stroke="white" stroke-opacity="0.12" stroke-width="' . $whiteW . '"/>'
                . $text . '</svg>';
        }

        if ($style === 'dark-glow') {
            return $open
                . '<defs><radialGradient id="glow' . $uid . '" cx="50%" cy="46%" r="55%">'
                . '<stop offset="0%" stop-color="' . self::PURPLE . '" stop-opacity="0.55"/>'
                . '<stop offset="100%" stop-color="' . self::PURPLE . '" stop-opacity="0"/></radialGradient></defs>'
                . '<circle cx="' . $r . '" cy="' . $r . '" r="' . $r . '" fill="' . self::DARK . '"/>'
                . '<circle cx="' . $r . '" cy="' . $r . '" r="' . $r . '" fill="url(#glow' . $uid . ')"/>'
                . $ring . $text . '</svg>';
        }

        // dark-white / dark-duo — dark background + purple ring.
        return $open
            . '<circle cx="' . $r . '" cy="' . $r . '" r="' . $r . '" fill="' . self::DARK . '"/>'
            . $ring . $text . '</svg>';
    }
}
