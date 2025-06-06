<?php

/**
 * @package Cosmos
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Cosmos;

use DecodeLabs\Exceptional;
use DecodeLabs\Nuance\Dumpable;
use DecodeLabs\Nuance\Entity\NativeObject as NuanceEntity;
use Locale as SysLocale;

class Locale implements Dumpable
{
    public protected(set) string $canonical;

    public string $name {
        get => $this->getName();
    }

    public string $language {
        get => $this->getLanguage();
    }

    public string $languageName {
        get => $this->getLanguageName();
    }

    public ?string $region {
        get => $this->getRegion();
    }

    public ?string $regionName {
        get => $this->getRegionName();
    }

    public ?string $script {
        get => $this->getScript();
    }

    public ?string $scriptName {
        get => $this->getScriptName();
    }

    /**
     * @var list<string>
     */
    public array $variants {
        get => $this->getVariants();
    }

    public ?string $variantName {
        get => $this->getVariantName();
    }

    /**
     * @var array<string,string>
     */
    public array $keywords {
        get => $this->getKeywords();
    }


    /**
     * Composer locale
     *
     * @param array<string, string> $subtags
     */
    public static function compose(
        array $subtags
    ): static {
        /** @phpstan-ignore-next-line */
        if (false === ($locale = SysLocale::composeLocale($subtags))) {
            throw Exceptional::InvalidArguemnt(
                message: 'Unable to composer locale with provided subtags',
                data: $subtags
            );
        }

        return new static($locale);
    }

    /**
     * Init with string representation
     */
    final public function __construct(
        string $locale
    ) {
        if (null === ($canonical = SysLocale::canonicalize($locale))) {
            throw Exceptional::InvalidArguemnt(
                message: 'Invalid locale string: ' . $locale
            );
        }

        $this->canonical = $canonical;
    }


    /**
     * Get current display name
     */
    public function getName(
        ?string $inLocale = null
    ): string {
        return SysLocale::getDisplayName($this->canonical, $inLocale);
    }


    /**
     * Get current language
     */
    public function getLanguage(): string
    {
        if (null === ($output = SysLocale::getPrimaryLanguage($this->canonical))) {
            throw Exceptional::Runtime(
                message: 'Unable to extract language from locale: ' . $this->canonical
            );
        }

        return $output;
    }

    /**
     * Get current language display name
     */
    public function getLanguageName(
        ?string $inLocale = null
    ): string {
        // Docs mismatch
        // @phpstan-ignore-next-line
        if (false === ($output = SysLocale::getDisplayLanguage($this->canonical, $inLocale))) {
            throw Exceptional::Runtime(
                message: 'Unable to extract language from locale: ' . $this->canonical
            );
        }

        return $output;
    }


    /**
     * Get current region
     */
    public function getRegion(): ?string
    {
        $output = SysLocale::getRegion($this->canonical);

        if (!strlen((string)$output)) {
            $output = null;
        }

        return $output;
    }

    /**
     * Get current region display name
     */
    public function getRegionName(
        ?string $inLocale = null
    ): ?string {
        // Docs mismatch
        // @phpstan-ignore-next-line
        if (false === ($output = SysLocale::getDisplayRegion($this->canonical, $inLocale))) {
            $output = null;
        }

        return $output;
    }


    /**
     * Get current script
     */
    public function getScript(): ?string
    {
        $output = SysLocale::getScript($this->canonical);

        if (!strlen((string)$output)) {
            $output = null;
        }

        return $output;
    }

    /**
     * Get current script display name
     */
    public function getScriptName(
        ?string $inLocale = null
    ): ?string {
        $output = SysLocale::getDisplayScript($this->canonical, $inLocale);

        if (!strlen($output)) {
            $output = null;
        }

        return $output;
    }


    /**
     * Get current variants
     *
     * @return list<string>
     */
    public function getVariants(): array
    {
        $output = SysLocale::getAllVariants($this->canonical);

        if (empty($output)) {
            $output = [];
        }

        /** @var list<string> */
        return $output;
    }

    /**
     * Get current script variant name
     */
    public function getVariantName(
        ?string $inLocale = null
    ): ?string {
        $output = SysLocale::getDisplayVariant($this->canonical, $inLocale);

        if (!strlen((string)$output)) {
            $output = null;
        }

        return $output;
    }


    /**
     * Get keywords
     *
     * @return array<string,string>
     */
    public function getKeywords(): array
    {
        $output = SysLocale::getKeywords($this->canonical);

        if (!$output) {
            return [];
        }

        /** @var array<string,string> */
        return (array)$output;
    }


    /**
     * Convert to string
     */
    public function __toString(): string
    {
        return $this->canonical;
    }


    /**
     * Equals another locale exactly
     */
    public function eq(
        string|Locale $locale
    ): bool {
        if (!$locale instanceof Locale) {
            $locale = new Locale($locale);
        }

        return (string)$locale === $this->canonical;
    }

    /**
     * Matches another locale
     */
    public function matches(
        string|Locale $locale
    ): bool {
        return (bool)SysLocale::filterMatches(
            $this->canonical,
            (string)$locale,
            true
        );
    }

    /**
     * Lookup best match in list
     *
     * @param array<string|Locale> $options
     */
    public function bestMatch(
        array $options,
        string|Locale|null $default = null
    ): ?static {
        foreach ($options as $i => $option) {
            if (!$option instanceof Locale) {
                $option = new Locale($option);
            }

            $options[$i] = (string)$option;
        }

        if (is_string($default)) {
            $default = new Locale($default);
        }
        if ($default !== null) {
            $default = (string)$default;
        }

        $output = SysLocale::lookup($options, $this->canonical, false, $default);

        if ($output === null) {
            $output = $default;
        }

        if ($output !== null) {
            $output = new static($output);
        }

        return $output;
    }


    public function toNuanceEntity(): NuanceEntity
    {
        $entity = new NuanceEntity($this);
        $entity->itemName = $this->canonical;

        $entity->meta = [
            'language' => $this->getLanguageName() . ' : ' . $this->getLanguage(),
            'region' => ($region = $this->getRegionName()) !== null ? $region . ' : ' . $this->getRegion() : null,
            'script' => ($script = $this->getScriptName()) !== null ? $script . ' : ' . $this->getScript() : null,
            'variants' => $this->getVariants(),
            'variantName' => $this->getVariantName(),
            'keywords' => $this->getKeywords()
        ];

        return $entity;
    }
}
