<?php

/**
 * @package Cosmos
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Cosmos\Tests;

use DecodeLabs\Cosmos\Extension\Number;
use DecodeLabs\Cosmos\Extension\NumberTrait;
use DecodeLabs\Cosmos\Locale;

class AnalyzeNumberExtension implements Number
{
    use NumberTrait;

    public function format(
        int|float|string|null $value,
        ?string $unit = null,
        string|Locale|null $locale = null
    ): ?string {
        return null;
    }

    public function pattern(
        int|float|string|null $value,
        string $pattern,
        string|Locale|null $locale = null
    ): ?string {
        return null;
    }

    public function decimal(
        int|float|string|null $value,
        ?int $precision = null,
        string|Locale|null $locale = null
    ): ?string {
        return null;
    }

    public function currency(
        int|float|string|null $value,
        ?string $code,
        ?bool $rounded = null,
        string|Locale|null $locale = null
    ): ?string {
        return null;
    }

    public function percent(
        int|float|string|null $value,
        float $total = 100.0,
        int $decimals = 0,
        string|Locale|null $locale = null
    ): ?string {
        return null;
    }

    public function scientific(
        int|float|string|null $value,
        string|Locale|null $locale = null
    ): ?string {
        return null;
    }

    public function spellout(
        int|float|string|null $value,
        string|Locale|null $locale = null
    ): ?string {
        return null;
    }

    public function ordinal(
        int|float|string|null $value,
        string|Locale|null $locale = null
    ): ?string {
        return null;
    }

    public function diff(
        int|float|string|null $diff,
        ?bool $invert = false,
        string|Locale|null $locale = null
    ): ?string {
        return null;
    }

    public function fileSize(
        ?int $bytes,
        string|Locale|null $locale = null
    ): ?string {
        return null;
    }

    public function fileSizeDec(
        ?int $bytes,
        string|Locale|null $locale = null
    ): ?string {
        return null;
    }
}
