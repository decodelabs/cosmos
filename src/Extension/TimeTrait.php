<?php

/**
 * Cosmos
 * @license https://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Cosmos\Extension;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use Carbon\CarbonInterval;
use DateInterval;
use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use DecodeLabs\Cosmos\Locale;
use DecodeLabs\Exceptional;
use DecodeLabs\Kairos\TimeZone;
use IntlDateFormatter;
use Stringable;

/**
 * @template TReturn
 * @phpstan-require-implements Time
 */
trait TimeTrait
{
    /**
     * @param-out DateTimeInterface|null $date
     */
    protected static function formatRawIcuDate(
        DateTimeInterface|DateInterval|string|Stringable|int|null &$date,
        string $pattern,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): ?string {
        if (!$date = static::prepare($date, $timezone, true)) {
            return null;
        }

        $formatter = new IntlDateFormatter(
            Locale::stringFrom($locale),
            static::normalizeLocaleSize('full'),
            static::normalizeLocaleSize('full'),
            $date->getTimezone(),
            null,
            $pattern
        );

        return (string)$formatter->format($date);
    }


    /**
     * @param-out DateTimeInterface|null $date
     */
    protected static function formatRawLocaleDate(
        DateTimeInterface|DateInterval|string|Stringable|int|null &$date,
        string|int|bool|null $dateSize = true,
        string|int|bool|null $timeSize = true,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null &$locale = null,
        ?string &$wrapFormat = null
    ): ?string {
        $dateSize = static::normalizeLocaleSize($dateSize);
        $timeSize = static::normalizeLocaleSize($timeSize);

        $hasDate = $dateSize !== IntlDateFormatter::NONE;
        $hasTime = ($timeSize !== IntlDateFormatter::NONE) && ($timezone !== false);

        if (
            !$hasDate &&
            !$hasTime
        ) {
            return null;
        }

        if (
            $hasDate &&
            $hasTime
        ) {
            $wrapFormat = DateTimeInterface::W3C;
        } elseif ($hasTime) {
            $wrapFormat = 'H:i:s';
        } else {
            $wrapFormat = 'Y-m-d';
        }

        if (!$date = static::prepare($date, $timezone, $hasTime)) {
            return null;
        }

        $formatter = new IntlDateFormatter(
            Locale::stringFrom($locale),
            $dateSize,
            $timeSize,
            $date->getTimezone()
        );

        return (string)$formatter->format($date);
    }

    /**
     * @return TReturn|null
     */
    public static function fullDateTime(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed {
        return static::locale($date, 'full', 'full', $timezone, $locale);
    }

    /**
     * @return TReturn|null
     */
    public static function fullDate(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed {
        return static::locale($date, 'full', false, $timezone, $locale);
    }

    /**
     * @return TReturn|null
     */
    public static function fullTime(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed {
        return static::locale($date, false, 'full', $timezone, $locale);
    }


    /**
     * @return TReturn|null
     */
    public static function longDateTime(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed {
        return static::locale($date, 'long', 'long', $timezone, $locale);
    }

    /**
     * @return TReturn|null
     */
    public static function longDate(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed {
        return static::locale($date, 'long', false, $timezone, $locale);
    }

    /**
     * @return TReturn|null
     */
    public static function longTime(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed {
        return static::locale($date, false, 'long', $timezone, $locale);
    }


    /**
     * @return TReturn|null
     */
    public static function mediumDateTime(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed {
        return static::locale($date, 'medium', 'medium', $timezone, $locale);
    }

    /**
     * @return TReturn|null
     */
    public static function mediumDate(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed {
        return static::locale($date, 'medium', false, $timezone, $locale);
    }

    /**
     * @return TReturn|null
     */
    public static function mediumTime(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed {
        return static::locale($date, false, 'medium', $timezone, $locale);
    }


    /**
     * @return TReturn|null
     */
    public static function shortDateTime(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed {
        return static::locale($date, 'short', 'short', $timezone, $locale);
    }

    /**
     * @return TReturn|null
     */
    public static function shortDate(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed {
        return static::locale($date, 'short', false, $timezone, $locale);
    }

    /**
     * @return TReturn|null
     */
    public static function shortTime(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed {
        return static::locale($date, false, 'short', $timezone, $locale);
    }




    /**
     * @return TReturn|null
     */
    public static function dateTime(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed {
        return static::locale($date, 'medium', 'medium', $timezone, $locale);
    }

    /**
     * @return TReturn|null
     */
    public static function date(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed {
        return static::locale($date, 'medium', false, $timezone, $locale);
    }

    /**
     * @return TReturn|null
     */
    public static function time(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed {
        return static::locale($date, false, 'short', $timezone, $locale);
    }





    /**
     * @return TReturn|null
     */
    public static function since(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        ?bool $positive = null,
        ?int $parts = 1,
        string|Locale|null $locale = null
    ): mixed {
        return static::formatNowInterval($date, false, $parts, false, false, $positive, $locale);
    }

    /**
     * @return TReturn|null
     */
    public static function sinceAbs(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        ?bool $positive = null,
        ?int $parts = 1,
        string|Locale|null $locale = null
    ): mixed {
        return static::formatNowInterval($date, false, $parts, false, true, $positive, $locale);
    }

    /**
     * @return TReturn|null
     */
    public static function sinceAbbr(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        ?bool $positive = null,
        ?int $parts = 1,
        string|Locale|null $locale = null
    ): mixed {
        return static::formatNowInterval($date, false, $parts, true, true, $positive, $locale);
    }

    /**
     * @return TReturn|null
     */
    public static function until(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        ?bool $positive = null,
        ?int $parts = 1,
        string|Locale|null $locale = null
    ): mixed {
        return static::formatNowInterval($date, true, $parts, false, false, $positive, $locale);
    }

    /**
     * @return TReturn|null
     */
    public static function untilAbs(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        ?bool $positive = null,
        ?int $parts = 1,
        string|Locale|null $locale = null
    ): mixed {
        return static::formatNowInterval($date, true, $parts, false, true, $positive, $locale);
    }

    /**
     * @return TReturn|null
     */
    public static function untilAbbr(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        ?bool $positive = null,
        ?int $parts = 1,
        string|Locale|null $locale = null
    ): mixed {
        return static::formatNowInterval($date, true, $parts, true, true, $positive, $locale);
    }



    /**
     * @return TReturn|null
     */
    protected static function formatNowInterval(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        bool $invert,
        ?int $parts,
        bool $short = false,
        bool $absolute = false,
        ?bool $positive = false,
        string|Locale|null $locale = null
    ): mixed {
        return static::formatRawNowInterval($date, $interval, $invert, $parts, $short, $absolute, $positive, $locale);
    }


    /**
     * @param-out DateTimeInterface|null $date
     */
    protected static function formatRawNowInterval(
        DateTimeInterface|DateInterval|string|Stringable|int|null &$date,
        ?DateInterval &$interval,
        bool $invert,
        ?int $parts,
        bool $short = false,
        bool $absolute = false,
        ?bool $positive = false,
        string|Locale|null $locale = null
    ): ?string {
        static::checkCarbon();

        if ($date instanceof DateInterval) {
            $interval = CarbonInterval::instance($date);
            $interval->invert = (int)!$interval->invert;
            $date = static::normalizeDate($date);
        } else {
            if (!$date = static::normalizeDate($date)) {
                return null;
            }

            if (null === ($now = static::normalizeDate('now'))) {
                throw Exceptional::UnexpectedValue(
                    message: 'Unable to create now date'
                );
            }

            if (null === ($interval = CarbonInterval::make($date->diff($now)))) {
                throw Exceptional::UnexpectedValue(
                    message: 'Unable to create interval'
                );
            }
        }

        $locale = Locale::stringFrom($locale);
        $interval->locale($locale);
        $inverted = $interval->invert;

        if ($invert) {
            if ($inverted) {
                $absolute = true;
            }

            $inverted = !$inverted;
        }

        return
            ($inverted && $absolute ? '-' : '') .
            $interval->forHumans([
                'short' => $short,
                'join' => true,
                'parts' => $parts,
                'options' => CarbonInterface::JUST_NOW | CarbonInterface::ONE_DAY_WORDS | CarbonInterface::ROUND,
                'syntax' => $absolute ? CarbonInterface::DIFF_ABSOLUTE : CarbonInterface::DIFF_RELATIVE_TO_NOW
            ]);
    }




    /**
     * @return TReturn|null
     */
    public static function between(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date1,
        DateTimeInterface|DateInterval|string|Stringable|int|null $date2,
        ?int $parts = 1,
        string|Locale|null $locale = null
    ): mixed {
        return static::formatBetweenInterval($date1, $date2, $parts, false, $locale);
    }

    /**
     * @return TReturn|null
     */
    public static function betweenAbbr(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date1,
        DateTimeInterface|DateInterval|string|Stringable|int|null $date2,
        ?int $parts = 1,
        string|Locale|null $locale = null
    ): mixed {
        return static::formatBetweenInterval($date1, $date2, $parts, true, $locale);
    }

    /**
     * @return TReturn|null
     */
    protected static function formatBetweenInterval(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date1,
        DateTimeInterface|DateInterval|string|Stringable|int|null $date2,
        ?int $parts = 1,
        bool $short = false,
        string|Locale|null $locale = null
    ): mixed {
        return static::formatRawBetweenInterval($date1, $date2, $interval, $parts, $short, $locale);
    }

    /**
     * @param-out DateTimeInterface|null $date1
     * @param-out DateTimeInterface|null $date2
     */
    protected static function formatRawBetweenInterval(
        DateTimeInterface|DateInterval|string|Stringable|int|null &$date1,
        DateTimeInterface|DateInterval|string|Stringable|int|null &$date2,
        ?DateInterval &$interval,
        ?int $parts = 1,
        bool $short = false,
        string|Locale|null &$locale = null
    ): ?string {
        static::checkCarbon();

        if (!$date1 = static::normalizeDate($date1)) {
            return null;
        }

        if (!$date2 = static::normalizeDate($date2)) {
            return null;
        }

        if (null === ($interval = CarbonInterval::make($date1->diff($date2)))) {
            throw Exceptional::UnexpectedValue(
                message: 'Unable to create interval'
            );
        }

        $locale = Locale::stringFrom($locale);
        $interval->locale($locale);

        return
            ($interval->invert ? '-' : '') .
            $interval->forHumans([
                'short' => $short,
                'join' => true,
                'parts' => $parts,
                'options' => CarbonInterface::JUST_NOW | CarbonInterface::ONE_DAY_WORDS | CarbonInterface::ROUND,
                'syntax' => CarbonInterface::DIFF_ABSOLUTE
            ]);
    }




    protected static function prepare(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        bool $includeTime = true
    ): ?DateTime {
        if (null === ($date = static::normalizeDate($date))) {
            return null;
        }

        if ($timezone === false) {
            $timezone = null;
            //$includeTime = false;
        }

        if ($timezone !== null) {
            $date = clone $date;

            if ($timezone = static::normalizeTimezone($timezone)) {
                $date->setTimezone($timezone);
            }
        }

        return $date;
    }


    protected static function normalizeDate(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date
    ): ?DateTime {
        if ($date === null) {
            return null;
        } elseif ($date instanceof DateTimeImmutable) {
            return DateTime::createFromInterface($date);
        } elseif ($date instanceof DateTime) {
            return $date;
        }

        if ($date instanceof DateInterval) {
            $int = $date;

            if (null === ($now = static::normalizeDate('now'))) {
                throw Exceptional::UnexpectedValue(
                    message: 'Unable to create now date'
                );
            }

            return $now->add($int);
        }

        $timestamp = null;

        if (is_numeric($date)) {
            $timestamp = $date;
            $date = 'now';
        }

        $date = new DateTime((string)$date);

        if ($timestamp !== null) {
            $date->setTimestamp((int)$timestamp);
        }

        return $date;
    }

    protected static function normalizeTimezone(
        DateTimeZone|string|Stringable|bool|null $timezone
    ): ?DateTimeZone {
        if (
            $timezone === false ||
            $timezone === null
        ) {
            return null;
        }

        if ($timezone === true) {
            $timezone = TimeZone::getActive();
        }

        if ($timezone instanceof DateTimeZone) {
            return $timezone;
        }

        return new DateTimeZone((string)$timezone);
    }

    protected static function normalizeLocaleSize(
        string|int|bool|null $size
    ): int {
        if (
            $size === false ||
            $size === null
        ) {
            return IntlDateFormatter::NONE;
        }

        if ($size === true) {
            return IntlDateFormatter::LONG;
        }

        switch ($size) {
            case 'full':
                return IntlDateFormatter::FULL;

            case 'long':
                return IntlDateFormatter::LONG;

            case 'medium':
                return IntlDateFormatter::MEDIUM;

            case 'short':
                return IntlDateFormatter::SHORT;

            case IntlDateFormatter::FULL:
            case IntlDateFormatter::LONG:
            case IntlDateFormatter::MEDIUM:
            case IntlDateFormatter::SHORT:
                return (int)$size;

            default:
                throw Exceptional::InvalidArgument(
                    message: 'Invalid locale formatter size: ' . $size
                );
        }
    }

    protected static function checkCarbon(): void
    {
        if (!class_exists(Carbon::class)) {
            throw Exceptional::ComponentUnavailable(
                message: 'nesbot/carbon is required for formatting intervals'
            );
        }
    }
}
