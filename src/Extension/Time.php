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
     * @return ($date is null ? null : TReturn)
     */
    public static function format(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        string $format,
        DateTimeZone|string|Stringable|bool|null $timezone = true
    ): mixed;

    /**
     * @return ($date is null ? null : TReturn)
     */
    public static function formatDate(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        string $format
    ): mixed;

    /**
     * @return ($date is null ? null : TReturn)
     */
    public static function pattern(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        string $pattern,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed;

    /**
     * @return ($date is null ? null : TReturn)
     */
    public static function locale(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        string|int|bool|null $dateSize = true,
        string|int|bool|null $timeSize = true,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed;

    /**
     * @return ($date is null ? null : TReturn)
     */
    public static function fullDateTime(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed;

    /**
     * @return ($date is null ? null : TReturn)
     */
    public static function fullDate(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed;

    /**
     * @return ($date is null ? null : TReturn)
     */
    public static function fullTime(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed;


    /**
     * @return ($date is null ? null : TReturn)
     */
    public static function longDateTime(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed;

    /**
     * @return ($date is null ? null : TReturn)
     */
    public static function longDate(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed;

    /**
     * @return ($date is null ? null : TReturn)
     */
    public static function longTime(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed;


    /**
     * @return ($date is null ? null : TReturn)
     */
    public static function mediumDateTime(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed;

    /**
     * @return ($date is null ? null : TReturn)
     */
    public static function mediumDate(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed;

    /**
     * @return ($date is null ? null : TReturn)
     */
    public static function mediumTime(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed;


    /**
     * @return ($date is null ? null : TReturn)
     */
    public static function shortDateTime(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed;

    /**
     * @return ($date is null ? null : TReturn)
     */
    public static function shortDate(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed;

    /**
     * @return ($date is null ? null : TReturn)
     */
    public static function shortTime(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed;




    /**
     * @return ($date is null ? null : TReturn)
     */
    public static function dateTime(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed;

    /**
     * @return ($date is null ? null : TReturn)
     */
    public static function date(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed;

    /**
     * @return ($date is null ? null : TReturn)
     */
    public static function time(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        DateTimeZone|string|Stringable|bool|null $timezone = true,
        string|Locale|null $locale = null
    ): mixed;




    /**
     * @return ($date is null ? null : TReturn)
     */
    public static function since(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        ?bool $positive = null,
        ?int $parts = 1,
        string|Locale|null $locale = null
    ): mixed;

    /**
     * @return ($date is null ? null : TReturn)
     */
    public static function sinceAbs(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        ?bool $positive = null,
        ?int $parts = 1,
        string|Locale|null $locale = null
    ): mixed;

    /**
     * @return ($date is null ? null : TReturn)
     */
    public static function sinceAbbr(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        ?bool $positive = null,
        ?int $parts = 1,
        string|Locale|null $locale = null
    ): mixed;

    /**
     * @return ($date is null ? null : TReturn)
     */
    public static function until(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        ?bool $positive = null,
        ?int $parts = 1,
        string|Locale|null $locale = null
    ): mixed;

    /**
     * @return ($date is null ? null : TReturn)
     */
    public static function untilAbs(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        ?bool $positive = null,
        ?int $parts = 1,
        string|Locale|null $locale = null
    ): mixed;

    /**
     * @return ($date is null ? null : TReturn)
     */
    public static function untilAbbr(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date,
        ?bool $positive = null,
        ?int $parts = 1,
        string|Locale|null $locale = null
    ): mixed;


    /**
     * @return ($date1 is null ? null : ($date2 is null ? null : TReturn))
     */
    public static function between(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date1,
        DateTimeInterface|DateInterval|string|Stringable|int|null $date2,
        ?int $parts = 1,
        string|Locale|null $locale = null
    ): mixed;

    /**
     * @return ($date1 is null ? null : ($date2 is null ? null : TReturn))
     */
    public static function betweenAbbr(
        DateTimeInterface|DateInterval|string|Stringable|int|null $date1,
        DateTimeInterface|DateInterval|string|Stringable|int|null $date2,
        ?int $parts = 1,
        string|Locale|null $locale = null
    ): mixed;
}
