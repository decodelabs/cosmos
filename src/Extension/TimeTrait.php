<?php

/**
 * @package Cosmos
 * @license http://opensource.org/licenses/MIT
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
use DecodeLabs\Cosmos;
use DecodeLabs\Cosmos\Locale;
use DecodeLabs\Exceptional;
use IntlDateFormatter;
use Stringable;

/**
 * @template TReturn
 * @phpstan-require-implements Time
 */
trait TimeTrait
{
    /**
     * Format raw ICU date
     *
     * @param-out DateTimeInterface|null $date
     */
    protected function formatRawIcuDate(
        DateTimeInterface|DateInterval|string|Stringable|int|null &$date,
        string $pattern,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): ?string {
        if (!$date = $this->prepare($date, $timezone, true)) {
            return null;
        }

        $formatter = new IntlDateFormatter(
            Cosmos::normalizeLocaleString($locale),
            $this->normalizeLocaleSize('full'),
            $this->normalizeLocaleSize('full'),
            $date->getTimezone(),
            null,
            $pattern
        );

        return (string)$formatter->format($date);
    }


    /**
     * Format raw locale date
     *
     * @param-out DateTimeInterface|null $date
     */
    protected function formatRawLocaleDate(
        DateTimeInterface|DateInterval|string|Stringable|int|null &$date,
        string|int|bool|null $dateSize = true,
        string|int|bool|null $timeSize = true,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null &$locale = null,
        ?string &$wrapFormat = null
    ): ?string {
        $dateSize = $this->normalizeLocaleSize($dateSize);
        $timeSize = $this->normalizeLocaleSize($timeSize);

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

        if (!$date = $this->prepare($date, $timezone, $hasTime)) {
            return null;
        }

        $formatter = new IntlDateFormatter(
            Cosmos::normalizeLocaleString($locale),
            $dateSize,
            $timeSize,
            $date->getTimezone()
        );

        return (string)$formatter->format($date);
    }

    /**
     * @return TReturn|null
     */
    public function fullDateTime(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed {
        return $this->locale($date, 'full', 'full', $timezone, $locale);
    }

    /**
     * @return TReturn|null
     */
    public function fullDate(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed {
        return $this->locale($date, 'full', false, $timezone, $locale);
    }

    /**
     * @return TReturn|null
     */
    public function fullTime(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed {
        return $this->locale($date, false, 'full', $timezone, $locale);
    }


    /**
     * @return TReturn|null
     */
    public function longDateTime(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed {
        return $this->locale($date, 'long', 'long', $timezone, $locale);
    }

    /**
     * @return TReturn|null
     */
    public function longDate(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed {
        return $this->locale($date, 'long', false, $timezone, $locale);
    }

    /**
     * @return TReturn|null
     */
    public function longTime(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed {
        return $this->locale($date, false, 'long', $timezone, $locale);
    }


    /**
     * @return TReturn|null
     */
    public function mediumDateTime(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed {
        return $this->locale($date, 'medium', 'medium', $timezone, $locale);
    }

    /**
     * @return TReturn|null
     */
    public function mediumDate(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed {
        return $this->locale($date, 'medium', false, $timezone, $locale);
    }

    /**
     * @return TReturn|null
     */
    public function mediumTime(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed {
        return $this->locale($date, false, 'medium', $timezone, $locale);
    }


    /**
     * @return TReturn|null
     */
    public function shortDateTime(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed {
        return $this->locale($date, 'short', 'short', $timezone, $locale);
    }

    /**
     * @return TReturn|null
     */
    public function shortDate(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed {
        return $this->locale($date, 'short', false, $timezone, $locale);
    }

    /**
     * @return TReturn|null
     */
    public function shortTime(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed {
        return $this->locale($date, false, 'short', $timezone, $locale);
    }




    /**
     * @return TReturn|null
     */
    public function dateTime(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed {
        return $this->locale($date, 'medium', 'medium', $timezone, $locale);
    }

    /**
     * @return TReturn|null
     */
    public function date(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed {
        return $this->locale($date, 'medium', false, $timezone, $locale);
    }

    /**
     * @return TReturn|null
     */
    public function time(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed {
        return $this->locale($date, false, 'short', $timezone, $locale);
    }





    /**
     * Format interval since date
     *
     * @return TReturn|null
     */
    public function since(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        ?bool $positive = null,
        ?int $parts = 1,
        string|Locale|null $locale = null
    ): mixed {
        return $this->formatNowInterval($date, false, $parts, false, false, $positive, $locale);
    }

    /**
     * Format interval since date
     *
     * @return TReturn|null
     */
    public function sinceAbs(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        ?bool $positive = null,
        ?int $parts = 1,
        string|Locale|null $locale = null
    ): mixed {
        return $this->formatNowInterval($date, false, $parts, false, true, $positive, $locale);
    }

    /**
     * Format interval since date
     *
     * @return TReturn|null
     */
    public function sinceAbbr(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        ?bool $positive = null,
        ?int $parts = 1,
        string|Locale|null $locale = null
    ): mixed {
        return $this->formatNowInterval($date, false, $parts, true, true, $positive, $locale);
    }

    /**
     * Format interval until date
     *
     * @return TReturn|null
     */
    public function until(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        ?bool $positive = null,
        ?int $parts = 1,
        string|Locale|null $locale = null
    ): mixed {
        return $this->formatNowInterval($date, true, $parts, false, false, $positive, $locale);
    }

    /**
     * Format interval until date
     *
     * @return TReturn|null
     */
    public function untilAbs(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        ?bool $positive = null,
        ?int $parts = 1,
        string|Locale|null $locale = null
    ): mixed {
        return $this->formatNowInterval($date, true, $parts, false, true, $positive, $locale);
    }

    /**
     * Format interval until date
     *
     * @return TReturn|null
     */
    public function untilAbbr(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        ?bool $positive = null,
        ?int $parts = 1,
        string|Locale|null $locale = null
    ): mixed {
        return $this->formatNowInterval($date, true, $parts, true, true, $positive, $locale);
    }



    /**
     * Format interval
     *
     * @return TReturn|null
     */
    protected function formatNowInterval(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        bool $invert,
        ?int $parts,
        bool $short = false,
        bool $absolute = false,
        ?bool $positive = false,
        string|Locale|null $locale = null
    ): mixed {
        return $this->formatRawNowInterval($date, $interval, $invert, $parts, $short, $absolute, $positive, $locale);
    }


    /**
     * Format interval
     *
     * @param-out DateTimeInterface|null $date
     */
    protected function formatRawNowInterval(
        DateTimeInterface|DateInterval|string|Stringable|int|null &$date,
        ?DateInterval &$interval,
        bool $invert,
        ?int $parts,
        bool $short = false,
        bool $absolute = false,
        ?bool $positive = false,
        string|Locale|null $locale = null
    ): ?string {
        $this->checkCarbon();

        if ($date instanceof DateInterval) {
            $interval = CarbonInterval::instance($date);
            $interval->invert = (int)!$interval->invert;
            $date = $this->normalizeDate($date);
        } else {
            if (!$date = $this->normalizeDate($date)) {
                return null;
            }

            if (null === ($now = $this->normalizeDate('now'))) {
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

        $locale = Cosmos::normalizeLocaleString($locale);
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
     * Format interval until date
     *
     * @return TReturn|null
     */
    public function between(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date1,
        DateTimeInterface|DateInterval|string|Stringable|int|null $date2,
        ?int $parts = 1,
        string|Locale|null $locale = null
    ): mixed {
        return $this->formatBetweenInterval($date1, $date2, $parts, false, $locale);
    }

    /**
     * Format interval until date
     *
     * @return TReturn|null
     */
    public function betweenAbbr(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date1,
        DateTimeInterface|DateInterval|string|Stringable|int|null $date2,
        ?int $parts = 1,
        string|Locale|null $locale = null
    ): mixed {
        return $this->formatBetweenInterval($date1, $date2, $parts, true, $locale);
    }

    /**
     * Format interval until date
     *
     * @return TReturn|null
     */
    protected function formatBetweenInterval(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date1,
        DateTimeInterface|DateInterval|string|Stringable|int|null $date2,
        ?int $parts = 1,
        bool $short = false,
        string|Locale|null $locale = null
    ): mixed {
        return $this->formatRawBetweenInterval($date1, $date2, $interval, $parts, $short, $locale);
    }

    /**
     * Format interval until date
     *
     * @param-out DateTimeInterface|null $date1
     * @param-out DateTimeInterface|null $date2
     */
    protected function formatRawBetweenInterval(
        DateTimeInterface|DateInterval|string|Stringable|int|null &$date1,
        DateTimeInterface|DateInterval|string|Stringable|int|null &$date2,
        ?DateInterval &$interval,
        ?int $parts = 1,
        bool $short = false,
        string|Locale|null &$locale = null
    ): ?string {
        $this->checkCarbon();

        if (!$date1 = $this->normalizeDate($date1)) {
            return null;
        }

        if (!$date2 = $this->normalizeDate($date2)) {
            return null;
        }

        if (null === ($interval = CarbonInterval::make($date1->diff($date2)))) {
            throw Exceptional::UnexpectedValue(
                message: 'Unable to create interval'
            );
        }

        $locale = Cosmos::normalizeLocaleString($locale);
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




    /**
     * Prepare date for formatting
     */
    protected function prepare(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        bool $includeTime = true
    ): ?DateTime {
        if (null === ($date = $this->normalizeDate($date))) {
            return null;
        }

        if ($timezone === false) {
            $timezone = null;
            //$includeTime = false;
        }

        if ($timezone !== null) {
            $date = clone $date;

            if ($timezone = $this->normalizeTimezone($timezone)) {
                $date->setTimezone($timezone);
            }
        }

        return $date;
    }


    /**
     * Normalize a date input
     */
    protected function normalizeDate(
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

            if (null === ($now = $this->normalizeDate('now'))) {
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

    /**
     * Normalize timezone
     */
    protected function normalizeTimezone(
        DateTimeZone|string|Stringable|bool|null $timezone
    ): ?DateTimeZone {
        if (
            $timezone === false ||
            $timezone === null
        ) {
            return null;
        }

        if ($timezone === true) {
            $timezone = Cosmos::getTimezone();
        }

        if ($timezone instanceof DateTimeZone) {
            return $timezone;
        }

        return new DateTimeZone((string)$timezone);
    }

    /**
     * Normalize locale format size
     */
    protected function normalizeLocaleSize(
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

    /**
     * Check Carbon installed
     */
    protected function checkCarbon(): void
    {
        if (!class_exists(Carbon::class)) {
            throw Exceptional::ComponentUnavailable(
                message: 'nesbot/carbon is required for formatting intervals'
            );
        }
    }
}
