# Cosmos — Package Specification

> **Cluster:** `core`
> **Language:** `php`
> **Milestone:** `m3`
> **Repo:** `https://github.com/decodelabs/cosmos`
> **Role:** Internationalisation

This document describes the purpose, contracts, and design of **Cosmos** within the Decode Labs ecosystem.

It is aimed at:

- Developers **using** Cosmos in their own applications or libraries.
- Contributors **maintaining or extending** Cosmos.
- Tools and AI assistants that need to reason about its behaviour.

---

## 1. Overview

### 1.1 Purpose

Cosmos provides a simple interface to handle typical internationalisation (i18n) and localisation (l10n) tasks in PHP applications. It offers locale management, number formatting, and date/time formatting with locale-aware output. The package wraps PHP's `intl` extension functionality and provides extension interfaces for number and time formatting that can be implemented by other packages.

### 1.2 Non-Goals

Cosmos does **not**:

- Provide message translation or gettext functionality — it only handles formatting
- Handle pluralization rules or message formatting — that's handled by translation libraries
- Provide locale data or translations — it relies on PHP's intl extension data
- Handle currency conversion or exchange rates — it only formats currency values
- Provide timezone data or calculations — it uses Kairos for timezone handling
- Handle date parsing or validation — it focuses on formatting
- Provide locale detection or negotiation — it provides locale matching utilities

---

## 2. Role in the Ecosystem

### 2.1 Cluster & Positioning

- **Cluster:** `core` (see Chorus taxonomy)
- Cosmos is a core utility package that provides internationalisation capabilities for the Decode Labs ecosystem. It sits in the core cluster alongside other fundamental utilities. It depends on Exceptional, Kairos, and Nuance, and is used by packages like Dictum and Tagged for locale-aware formatting.

### 2.2 Typical Usage Contexts

Typical places Cosmos appears:

- Number formatting (decimals, currency, percentages)
- Date and time formatting
- Locale-aware display formatting
- Internationalised user interfaces
- Multi-language application formatting
- Currency display
- File size formatting
- Relative time formatting ("2 hours ago", "in 3 days")

Cosmos is intended to be used whenever code needs locale-aware formatting of numbers, dates, times, or other locale-sensitive data.

---

## 3. Public Surface

> This section focuses on the conceptual API, not every symbol.

### 3.1 Key Types

The primary public types are:

- `DecodeLabs\Cosmos\Locale`
  Locale representation class. Wraps PHP's `Locale` class and provides locale information extraction (language, region, script, variants, keywords). Implements `Dumpable` for debugging.

- `DecodeLabs\Cosmos\Extension\Number`
  Interface for number formatting extensions. Defines methods for formatting numbers in various styles (decimal, currency, percent, scientific, spellout, ordinal, etc.). Implementations use `NumberTrait` for common functionality.

- `DecodeLabs\Cosmos\Extension\NumberTrait`
  Trait providing number formatting implementation using PHP's `NumberFormatter`. Used by packages implementing the `Number` interface.

- `DecodeLabs\Cosmos\Extension\Time`
  Interface for date/time formatting extensions. Defines methods for formatting dates and times in various styles (full, long, medium, short) and relative formats (since, until, between). Implementations use `TimeTrait` for common functionality.

- `DecodeLabs\Cosmos\Extension\TimeTrait`
  Trait providing date/time formatting implementation using PHP's `IntlDateFormatter` and Carbon. Used by packages implementing the `Time` interface.

### 3.2 Main Entry Points

The main usage pattern is through the `Locale` class and extension interfaces:

```php
use DecodeLabs\Cosmos\Locale;

$locale = Locale::from('en_GB');
$language = $locale->language; // 'en'
$region = $locale->region; // 'GB'
```

Extension interfaces are typically implemented by other packages (e.g., Tagged) that provide formatting methods.

---

## 4. Dependencies

### 4.1 Decode Labs

- `decodelabs/exceptional` (required)
  Used for exception handling when locale operations fail.

- `decodelabs/kairos` (required)
  Used for timezone handling in date/time formatting. Provides `TimeZone::getActive()` for active timezone detection.

- `decodelabs/nuance` (required)
  Used for debugging and inspection via `Dumpable` interface on `Locale`.

### 4.2 External

- `ext-intl` (required)
  PHP's internationalisation extension. Required for `Locale`, `NumberFormatter`, and `IntlDateFormatter` functionality.

- `nesbot/carbon` (required)
  Used for date interval formatting in `TimeTrait`. Required for relative time formatting methods (`since`, `until`, `between`).

### 4.3 Optional Integrations

- None

---

## 5. Behaviour & Contracts

### 5.1 Invariants

- Locale strings are canonicalized using PHP's `Locale::canonicalize()`
- Invalid locale strings throw exceptions during construction
- Locale information is extracted from canonical locale string
- Number formatting uses PHP's `NumberFormatter` with locale-specific rules
- Date/time formatting uses PHP's `IntlDateFormatter` with locale-specific rules
- Relative time formatting requires Carbon for interval calculations
- Timezone handling uses Kairos for active timezone detection
- All formatting methods return `null` if input is `null`

### 5.2 Input & Output Contracts

**Locale Operations:**
- `from(string|Locale|null $locale): static` — Creates locale from string or returns existing
- `stringFrom(string|Locale|null $locale): string` — Gets locale string
- `getDefault(): static` — Gets system default locale
- `setDefault(string|Locale $locale): void` — Sets system default locale
- `compose(array $subtags): static` — Composes locale from subtags
- `getName(?string|Locale $displayLocale): string` — Gets locale display name
- `getLanguage(): string` — Gets language code
- `getLanguageName(?string|Locale $displayLocale): string` — Gets language display name
- `getRegion(): ?string` — Gets region code
- `getRegionName(?string|Locale $displayLocale): ?string` — Gets region display name
- `getScript(): ?string` — Gets script code
- `getScriptName(?string|Locale $displayLocale): ?string` — Gets script display name
- `getVariants(): array` — Gets variant codes
- `getVariantName(?string|Locale $displayLocale): ?string` — Gets variant display name
- `getKeywords(): array` — Gets locale keywords
- `eq(string|Locale $locale): bool` — Checks exact equality
- `matches(string|Locale $locale): bool` — Checks if locales match (filter)
- `bestMatch(array $options, ?string|Locale $default): ?static` — Finds best matching locale

**Number Formatting (via Extension Interface):**
- `format(int|float|string|null $value, ?string $unit, ?string|Locale $locale): mixed` — General number formatting
- `pattern(int|float|string|null $value, string $pattern, ?string|Locale $locale): mixed` — Pattern-based formatting
- `decimal(int|float|string|null $value, ?int $precision, ?string|Locale $locale): mixed` — Decimal formatting
- `currency(int|float|string|null $value, ?string $code, ?bool $rounded, ?string|Locale $locale): mixed` — Currency formatting
- `percent(int|float|string|null $value, float $total, int $decimals, ?string|Locale $locale): mixed` — Percentage formatting
- `scientific(int|float|string|null $value, ?string|Locale $locale): mixed` — Scientific notation
- `spellout(int|float|string|null $value, ?string|Locale $locale): mixed` — Spelled-out numbers
- `ordinal(int|float|string|null $value, ?string|Locale $locale): mixed` — Ordinal numbers
- `diff(int|float|string|null $diff, ?bool $invert, ?string|Locale $locale): mixed` — Difference formatting
- `fileSize(?int $bytes, ?string|Locale $locale): mixed` — File size formatting (binary)
- `fileSizeDec(?int $bytes, ?string|Locale $locale): mixed` — File size formatting (decimal)
- `counter(int|float|string|null $counter, bool $allowZero, ?string|Locale $locale): mixed` — Counter formatting (k, m, b abbreviations)

**Time Formatting (via Extension Interface):**
- `format(DateTimeInterface|DateInterval|string|Stringable|int|null $date, string $format, ?DateTimeZone|string|Stringable|bool $timezone): mixed` — Custom format
- `formatDate(DateTimeInterface|DateInterval|string|Stringable|int|null $date, string $format): mixed` — Date-only format
- `pattern(DateTimeInterface|DateInterval|string|Stringable|int|null $date, string $pattern, ?DateTimeZone|string|Stringable|bool $timezone, ?string|Locale $locale): mixed` — ICU pattern format
- `locale(DateTimeInterface|DateInterval|string|Stringable|int|null $date, ?string|int|bool $dateSize, ?string|int|bool $timeSize, ?DateTimeZone|string|Stringable|bool $timezone, ?string|Locale $locale): mixed` — Locale-aware format
- `fullDateTime`, `fullDate`, `fullTime` — Full format variants
- `longDateTime`, `longDate`, `longTime` — Long format variants
- `mediumDateTime`, `mediumDate`, `mediumTime` — Medium format variants
- `shortDateTime`, `shortDate`, `shortTime` — Short format variants
- `dateTime`, `date`, `time` — Default format variants
- `since`, `sinceAbs`, `sinceAbbr` — Relative time from now
- `until`, `untilAbs`, `untilAbbr` — Relative time until now
- `between`, `betweenAbbr` — Time difference between two dates

### 5.3 Locale Matching

- `matches()` uses PHP's `Locale::filterMatches()` to check if locales are compatible
- `bestMatch()` uses PHP's `Locale::lookup()` to find best matching locale from options
- Matching considers language, region, script, and variant components

### 5.4 Number Formatting

- Uses PHP's `NumberFormatter` with various format types (DECIMAL, CURRENCY, PERCENT, etc.)
- Currency formatting supports currency codes (defaults to GBP)
- File size formatting uses binary (1024) or decimal (1000) units
- Counter formatting abbreviates large numbers (k, m, b)

### 5.5 Time Formatting

- Uses PHP's `IntlDateFormatter` for locale-aware formatting
- Supports full, long, medium, short format sizes
- Relative time formatting uses Carbon's `forHumans()` method
- Timezone handling supports `true` (active timezone), `false` (no timezone), or specific timezone
- Date normalization handles DateTime, DateTimeImmutable, DateInterval, strings, and timestamps

---

## 6. Error Handling

- Invalid locale strings throw `Exceptional::InvalidArgument` during construction
- Locale composition failures throw `Exceptional::InvalidArgument`
- Locale information extraction failures throw `Exceptional::Runtime`
- Number formatting failures throw `Exceptional::Runtime` (INTL errors)
- Date formatting failures throw `Exceptional::Runtime` (INTL errors)
- Missing Carbon dependency throws `Exceptional::ComponentUnavailable` for interval formatting
- Invalid format sizes throw `Exceptional::InvalidArgument`
- All formatting methods return `null` if input is `null` (graceful degradation)

---

## 7. Configuration & Extensibility

- Locale default can be set globally via `Locale::setDefault()`
- Number and time formatting are provided via extension interfaces that other packages can implement
- `NumberTrait` and `TimeTrait` provide common implementation patterns
- Custom formatting can be implemented by creating new extension interfaces
- Locale matching and lookup use PHP's intl extension algorithms

---

## 8. Interactions with Other Packages

### 8.1 Exceptional

Cosmos uses Exceptional for all exception handling, providing consistent error reporting across the ecosystem.

### 8.2 Kairos

Cosmos uses Kairos for timezone handling. `TimeTrait` uses `TimeZone::getActive()` to get the active timezone when `$timezone === true`.

### 8.3 Nuance

Cosmos implements Nuance's `Dumpable` interface on `Locale`, allowing locales to be inspected and debugged using Nuance's debugging tools.

### 8.4 Carbon

Cosmos uses Carbon (via `nesbot/carbon`) for date interval formatting. Relative time methods (`since`, `until`, `between`) require Carbon to be available and use `CarbonInterval::forHumans()` for formatting.

### 8.5 PHP intl Extension

Cosmos relies heavily on PHP's `intl` extension:
- `Locale` class for locale operations
- `NumberFormatter` for number formatting
- `IntlDateFormatter` for date/time formatting

---

## 9. Usage Examples

### 9.1 Locale Operations

```php
use DecodeLabs\Cosmos\Locale;

$locale = Locale::from('en_GB');
$language = $locale->language; // 'en'
$region = $locale->region; // 'GB'
$name = $locale->getName(); // 'English (United Kingdom)'

// Best match
$best = $locale->bestMatch(['en_US', 'fr_FR', 'de_DE'], 'en_US');
```

### 9.2 Number Formatting (via Extension)

```php
// Assuming a package implements Number interface
use MyPackage\Formatter;

$formatted = Formatter::decimal(1234.56, 2, 'en_GB'); // '1,234.56'
$currency = Formatter::currency(99.99, 'USD', false, 'en_US'); // '$99.99'
$percent = Formatter::percent(25, 100, 0, 'en_GB'); // '25%'
$fileSize = Formatter::fileSize(1048576, 'en_GB'); // '1.00 MB'
$counter = Formatter::counter(1500, false, 'en_GB'); // '1.5k'
```

### 9.3 Time Formatting (via Extension)

```php
// Assuming a package implements Time interface
use MyPackage\Formatter;

$date = new DateTime('2025-05-16 14:30:00');
$formatted = Formatter::fullDateTime($date, true, 'en_GB');
// 'Thursday, 16 May 2025 at 14:30:00 British Summer Time'

$relative = Formatter::since($date, null, 1, 'en_GB');
// '2 hours ago'

$between = Formatter::between($date1, $date2, 2, 'en_GB');
// '3 days 2 hours'
```

### 9.4 Locale Matching

```php
use DecodeLabs\Cosmos\Locale;

$locale = Locale::from('en_GB');
$matches = $locale->matches('en_US'); // true (same language)
$exact = $locale->eq('en_GB'); // true
$exact = $locale->eq('en_US'); // false
```

---

## 10. Implementation Notes (for Contributors)

### 10.1 Locale Canonicalization

Locales are canonicalized using PHP's `Locale::canonicalize()`:
- Invalid locales return `null` and throw exceptions
- Canonical form is stored internally
- All locale operations use canonical form

### 10.2 Extension Interface Pattern

Number and Time formatting are provided via extension interfaces:
- Packages implement the interface
- Traits provide common implementation
- Methods return `null` for `null` input
- Methods use generic return types (`TReturn`) for flexibility

### 10.3 Number Formatting

Number formatting uses PHP's `NumberFormatter`:
- Format type determines formatter type (DECIMAL, CURRENCY, etc.)
- Locale determines formatting rules
- Errors are checked via `intl_is_failure()`
- Output is normalized and validated

### 10.4 Time Formatting

Time formatting uses PHP's `IntlDateFormatter`:
- Format size determines formatter constants (FULL, LONG, MEDIUM, SHORT)
- Locale determines formatting rules
- Timezone can be `true` (active), `false` (none), or specific timezone
- Date normalization handles various input types

### 10.5 Relative Time Formatting

Relative time formatting uses Carbon:
- Dates are converted to Carbon instances
- Intervals are calculated using `diff()`
- `forHumans()` provides locale-aware relative formatting
- Supports absolute, relative, and abbreviated formats

### 10.6 File Size Formatting

File size formatting:
- Binary: divides by 1024 (KB, MB, GB, TB, PB)
- Decimal: divides by 1000 (KB, MB, GB, TB, PB)
- Units are hardcoded in trait
- Precision is 2 decimal places

### 10.7 Counter Formatting

Counter formatting abbreviates large numbers:
- > 999,999,999: billions (b)
- > 999,999: millions (m)
- > 9,999: thousands (k, rounded)
- > 999: thousands (k, 1 decimal)
- Otherwise: normal formatting
- Zero returns `null` unless `$allowZero` is true

---

## 11. Testing & Quality

- **Code Quality Score:** 2/5
- **README Quality Score:** 2/5
- **Documentation Score:** 0/5 (this spec)
- **Test Coverage Score:** 0/5

See `composer.json` for supported PHP versions.

---

## 12. Roadmap & Future Ideas

- Add message translation support
- Add pluralization rules
- Improve documentation and usage examples
- Add test coverage
- Consider adding more formatting options
- Consider adding locale data utilities
- Consider adding locale detection utilities

---

## 13. References

- [Exceptional Package](https://github.com/decodelabs/exceptional) — Exception handling
- [Kairos Package](https://github.com/decodelabs/kairos) — Timezone handling
- [Nuance Package](https://github.com/decodelabs/nuance) — Debugging tools
- [Carbon Package](https://github.com/briannesbitt/Carbon) — Date interval formatting
- [PHP intl Extension](https://www.php.net/manual/en/book.intl.php) — Internationalisation support
- [ICU Documentation](http://site.icu-project.org/) — International Components for Unicode
- [Chorus Package Index](../../../chorus/config/packages.json) — Ecosystem metadata

