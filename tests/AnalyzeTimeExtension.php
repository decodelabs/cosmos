<?php

/**
 * Cosmos
 * @license https://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Cosmos\Tests;

use DateInterval;
use DateTimeInterface;
use DateTimeZone;
use DecodeLabs\Cosmos\Extension\Time;
use DecodeLabs\Cosmos\Extension\TimeTrait;
use DecodeLabs\Cosmos\Locale;
use Stringable;

/**
 * @implements Time<string>
 */
class AnalyzeTimeExtension implements Time
{
    /**
     * @use TimeTrait<string>
     */
    use TimeTrait;

    public static function format(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        string $format,
        DateTimeZone|string|Stringable|bool|null $timezone = true
    ): ?string {
        return null;
    }

    public static function formatDate(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        string $format
    ): ?string {
        return null;
    }

    public static function pattern(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        string $pattern,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): ?string {
        return null;
    }

    public static function locale(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        string|int|bool|null $dateSize = true,
        string|int|bool|null $timeSize = true,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): ?string {
        return null;
    }
}
