<?php

/**
 * @package Cosmos
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Cosmos\Extension;

use DateInterval;
use DateTimeInterface;
use DateTimeZone;
use DecodeLabs\Cosmos\Locale;
use Stringable;

/**
 * @template TReturn
 */
interface Time
{
    /**
     * Custom format a date and wrap it
     *
     * @return ($date is null ? null : TReturn)
     */
    public function format(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        string $format,
        DateTimeZone|string|Stringable|bool|null $timezone = true
    ): mixed;

    /**
     * Custom format a date and wrap it
     *
     * @return ($date is null ? null : TReturn)
     */
    public function formatDate(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        string $format
    ): mixed;

    /**
     * Custom locale format a date with ICU and wrap it
     *
     * @return ($date is null ? null : TReturn)
     */
    public function pattern(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        string $pattern,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed;

    /**
     * Format date according to locale
     *
     * @return ($date is null ? null : TReturn)
     */
    public function locale(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        string|int|bool|null $dateSize = true,
        string|int|bool|null $timeSize = true,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed;

    /**
     * Format full date time
     *
     * @return ($date is null ? null : TReturn)
     */
    public function fullDateTime(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed;

    /**
     * Format full date
     *
     * @return ($date is null ? null : TReturn)
     */
    public function fullDate(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed;

    /**
     * Format full time
     *
     * @return ($date is null ? null : TReturn)
     */
    public function fullTime(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed;


    /**
     * Format long date time
     *
     * @return ($date is null ? null : TReturn)
     */
    public function longDateTime(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed;

    /**
     * Format long date
     *
     * @return ($date is null ? null : TReturn)
     */
    public function longDate(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed;

    /**
     * Format long time
     *
     * @return ($date is null ? null : TReturn)
     */
    public function longTime(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed;


    /**
     * Format medium date time
     *
     * @return ($date is null ? null : TReturn)
     */
    public function mediumDateTime(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed;

    /**
     * Format medium date
     *
     * @return ($date is null ? null : TReturn)
     */
    public function mediumDate(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed;

    /**
     * Format medium time
     *
     * @return ($date is null ? null : TReturn)
     */
    public function mediumTime(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed;


    /**
     * Format short date time
     *
     * @return ($date is null ? null : TReturn)
     */
    public function shortDateTime(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed;

    /**
     * Format short date
     *
     * @return ($date is null ? null : TReturn)
     */
    public function shortDate(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed;

    /**
     * Format short time
     *
     * @return ($date is null ? null : TReturn)
     */
    public function shortTime(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed;




    /**
     * Format default date time
     *
     * @return ($date is null ? null : TReturn)
     */
    public function dateTime(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed;

    /**
     * Format default date
     *
     * @return ($date is null ? null : TReturn)
     */
    public function date(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed;

    /**
     * Format default time
     *
     * @return ($date is null ? null : TReturn)
     */
    public function time(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed;




    /**
     * Format interval since date
     *
     * @return ($date is null ? null : TReturn)
     */
    public function since(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        ?bool $positive = null,
        ?int $parts = 1,
        string|Locale|null $locale = null
    ): mixed;

    /**
     * Format interval since date
     *
     * @return ($date is null ? null : TReturn)
     */
    public function sinceAbs(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        ?bool $positive = null,
        ?int $parts = 1,
        string|Locale|null $locale = null
    ): mixed;

    /**
     * Format interval since date
     *
     * @return ($date is null ? null : TReturn)
     */
    public function sinceAbbr(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        ?bool $positive = null,
        ?int $parts = 1,
        string|Locale|null $locale = null
    ): mixed;

    /**
     * Format interval until date
     *
     * @return ($date is null ? null : TReturn)
     */
    public function until(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        ?bool $positive = null,
        ?int $parts = 1,
        string|Locale|null $locale = null
    ): mixed;

    /**
     * Format interval until date
     *
     * @return ($date is null ? null : TReturn)
     */
    public function untilAbs(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        ?bool $positive = null,
        ?int $parts = 1,
        string|Locale|null $locale = null
    ): mixed;

    /**
     * Format interval until date
     *
     * @return ($date is null ? null : TReturn)
     */
    public function untilAbbr(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        ?bool $positive = null,
        ?int $parts = 1,
        string|Locale|null $locale = null
    ): mixed;


    /**
     * Format interval until date
     *
     * @return ($date1 is null ? null : ($date2 is null ? null : TReturn))
     */
    public function between(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date1,
        DateTimeInterface|DateInterval|string|Stringable|int|null $date2,
        ?int $parts = 1,
        string|Locale|null $locale = null
    ): mixed;

    /**
     * Format interval until date
     *
     * @return ($date1 is null ? null : ($date2 is null ? null : TReturn))
     */
    public function betweenAbbr(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date1,
        DateTimeInterface|DateInterval|string|Stringable|int|null $date2,
        ?int $parts = 1,
        string|Locale|null $locale = null
    ): mixed;
}
