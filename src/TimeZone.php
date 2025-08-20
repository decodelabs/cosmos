<?php

/**
 * @package Cosmos
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Cosmos;

use DateTimeZone;
use IntlTimeZone;

class TimeZone extends DateTimeZone
{
    private static ?self $active = null;

    public ?TimeZoneLocation $location {
        get {
            $output = $this->getLocation();

            if (
                $output === false ||
                (
                    $output['latitude'] === 0.0 &&
                    $output['longitude'] === 0.0
                ) ||
                $output['country_code'] === '??'
            ) {
                return null;
            }

            return new TimeZoneLocation(
                $output['country_code'],
                $output['latitude'],
                $output['longitude'],
                // @phpstan-ignore-next-line
                $output['comments'] ?? null
            );
        }
    }

    public string $name {
        get => $this->getName();
    }

    public static function getDefault(): self
    {
        return new self(date_default_timezone_get());
    }

    public static function setDefault(
        string|TimeZone $timeZone
    ): void {
        if ($timeZone instanceof TimeZone) {
            $timeZone = $timeZone->name;
        }

        date_default_timezone_set($timeZone);
    }

    public static function getActive(): self
    {
        if (self::$active === null) {
            self::$active = new self(date_default_timezone_get());
        }

        return self::$active;
    }

    public static function setActive(
        string|TimeZone $timeZone
    ): void {
        if (!$timeZone instanceof TimeZone) {
            $timeZone = new self($timeZone);
        }

        self::$active = $timeZone;
    }

    public static function from(
        string|TimeZone|null $timeZone
    ): TimeZone {
        if ($timeZone === null) {
            $timeZone = date_default_timezone_get();
        }

        if (is_string($timeZone)) {
            $timeZone = static::parseString($timeZone);
        }

        return $timeZone;
    }

    public function stringFrom(
        string|TimeZone|null $timeZone
    ): string {
        return $this->from($timeZone)->name;
    }

    protected static function parseString(
        string $timeZone
    ): TimeZone {
        if (preg_match('/^[a-z]{3}$/', $timeZone)) {
            $timeZone = strtoupper($timeZone);
        } elseif (preg_match('|^([a-z\-]+)/([a-z\-]+)$|', $timeZone, $matches)) {
            $timeZone = ucfirst($matches[1]) . '/' . ucfirst($matches[2]);
        }

        /** @var string|false $canon */
        $canon = IntlTimeZone::getCanonicalID($timeZone);

        if ($canon !== false) {
            $timeZone = $canon;
        }

        return new TimeZone($timeZone);
    }
}
