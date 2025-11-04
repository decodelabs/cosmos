<?php

/**
 * Cosmos
 * @license https://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Cosmos\Tests;

use DecodeLabs\Cosmos\Extension\Number;
use DecodeLabs\Cosmos\Extension\NumberTrait;
use DecodeLabs\Cosmos\Locale;

/**
 * @implements Number<string>
 */
class AnalyzeNumberExtension implements Number
{
    /**
     * @use NumberTrait<string>
     */
    use NumberTrait;

    public static function format(
        int|float|string|null $value,
        ?string $unit = null,
        string|Locale|null $locale = null
    ): ?string {
        return null;
    }

    public static function pattern(
        int|float|string|null $value,
        string $pattern,
        string|Locale|null $locale = null
    ): ?string {
        return null;
    }

    public static function decimal(
        int|float|string|null $value,
        ?int $precision = null,
        string|Locale|null $locale = null
    ): ?string {
        return null;
    }

    public static function currency(
        int|float|string|null $value,
        ?string $code,
        ?bool $rounded = null,
        string|Locale|null $locale = null
    ): ?string {
        return null;
    }

    public static function percent(
        int|float|string|null $value,
        float $total = 100.0,
        int $decimals = 0,
        string|Locale|null $locale = null
    ): ?string {
        return null;
    }

    public static function scientific(
        int|float|string|null $value,
        string|Locale|null $locale = null
    ): ?string {
        return null;
    }

    public static function spellout(
        int|float|string|null $value,
        string|Locale|null $locale = null
    ): ?string {
        return null;
    }

    public static function ordinal(
        int|float|string|null $value,
        string|Locale|null $locale = null
    ): ?string {
        return null;
    }

    public static function diff(
        int|float|string|null $diff,
        ?bool $invert = false,
        string|Locale|null $locale = null
    ): ?string {
        return null;
    }

    public static function fileSize(
        ?int $bytes,
        string|Locale|null $locale = null
    ): ?string {
        return null;
    }

    public static function fileSizeDec(
        ?int $bytes,
        string|Locale|null $locale = null
    ): ?string {
        return null;
    }
}
