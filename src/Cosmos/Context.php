<?php

/**
 * @package Cosmos
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Cosmos;

use DateTimeZone as Timezone;
use DecodeLabs\Veneer;
use DecodeLabs\Veneer\Plugin;
use Locale as SysLocale;

class Context
{
    #[Plugin]
    public Locale $locale;

    #[Plugin]
    public Timezone $timezone;


    /**
     * Initialize system settings
     */
    protected function __construct()
    {
        // Locale
        $this->setLocale(SysLocale::getDefault());

        // Timezone
        date_default_timezone_set('UTC');
        $this->setTimezone('UTC');
    }


    /**
     * Set locale
     *
     * @return $this
     */
    public function setLocale(
        string|Locale $locale
    ): static {
        if (!$locale instanceof Locale) {
            $locale = new Locale($locale);
        }

        SysLocale::setDefault((string)$locale);
        Veneer::replacePlugin($this, 'locale', $locale);
        return $this;
    }

    /**
     * Get locale
     */
    public function getLocale(): Locale
    {
        return $this->locale;
    }



    /**
     * Set timezone
     *
     * @return $this
     */
    public function setTimezone(
        string|Timezone $timezone
    ): static {
        if (!$timezone instanceof Timezone) {
            $timezone = new Timezone($timezone);
        }

        $this->timezone = $timezone;

        return $this;
    }
}
