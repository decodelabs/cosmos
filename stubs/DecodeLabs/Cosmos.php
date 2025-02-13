<?php
/**
 * This is a stub file for IDE compatibility only.
 * It should not be included in your projects.
 */
namespace DecodeLabs;

use DecodeLabs\Veneer\Proxy as Proxy;
use DecodeLabs\Veneer\ProxyTrait as ProxyTrait;
use DecodeLabs\Cosmos\Context as Inst;
use DecodeLabs\Cosmos\Locale as LocalePlugin;
use DateTimeZone as TimezonePlugin;
use DecodeLabs\Veneer\Plugin\Wrapper as PluginWrapper;

class Cosmos implements Proxy
{
    use ProxyTrait;

    public const Veneer = 'DecodeLabs\\Cosmos';
    public const VeneerTarget = Inst::class;

    protected static Inst $_veneerInstance;
    public static LocalePlugin $locale;
    /** @var TimezonePlugin|PluginWrapper<TimezonePlugin> $timezone */
    public static TimezonePlugin|PluginWrapper $timezone;

    public static function setLocale(LocalePlugin|string $locale): Inst {
        return static::$_veneerInstance->setLocale(...func_get_args());
    }
    public static function getLocale(): LocalePlugin {
        return static::$_veneerInstance->getLocale();
    }
    public static function normalizeLocale(LocalePlugin|string|null $locale = NULL): LocalePlugin {
        return static::$_veneerInstance->normalizeLocale(...func_get_args());
    }
    public static function normalizeLocaleString(LocalePlugin|string|null $locale = NULL): string {
        return static::$_veneerInstance->normalizeLocaleString(...func_get_args());
    }
    public static function setTimezone(TimezonePlugin|string $timezone): Inst {
        return static::$_veneerInstance->setTimezone(...func_get_args());
    }
    public static function getTimezone(): TimezonePlugin {
        return static::$_veneerInstance->getTimezone();
    }
    public static function normalizeTimezone(TimezonePlugin|string|null $timezone): TimezonePlugin {
        return static::$_veneerInstance->normalizeTimezone(...func_get_args());
    }
    public static function normalizeTimezoneString(TimezonePlugin|string|null $timezone): string {
        return static::$_veneerInstance->normalizeTimezoneString(...func_get_args());
    }
};
