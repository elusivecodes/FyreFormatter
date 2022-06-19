<?php
declare(strict_types=1);

namespace Fyre\Formatter;

use
    Fyre\DateTime\DateTime,
    Fyre\DateTime\DateTimeInterface,
    Fyre\DB\TypeParser,
    Locale,
    NumberFormatter;
/**
 * Formatter
 */
abstract class Formatter
{

    protected static string|null $defaultLocale = null;

    protected static string|null $defaultTimeZone = null;

    protected static string $defaultCurrency = 'USD';

    protected static array $numberFormatters = [];

    /**
     * Format a value as a currency string.
     * @param string|int|float The value.
     * @param array $options The formatting options.
     * @return string The currency string.
     */
    public static function currency(string|int|float $value, array $options = []): string
    {
        $options['locale'] ??= static::getDefaultLocale();
        $options['currency'] ??= static::getDefaultCurrency();

        return static::getNumberFormatter($options['locale'], NumberFormatter::CURRENCY_ACCOUNTING)
            ->formatCurrency((float) $value, $options['currency']);
    }

    /**
     * Format a DateTime as a date string.
     * @param DateTimeInterface The DateTime.
     * @param array $options The formatting options.
     * @return string The date string.
     */
    public static function date(DateTimeInterface $value, array $options = []): string
    {
        $options['format'] ??= TypeParser::getType('date')->getLocaleFormat();
        $options['format'] ??= 'dd/MM/yyyy';

        return static::datetime($value, $options);
    }

    /**
     * Format a DateTime as a date/time string.
     * @param DateTimeInterface The DateTime.
     * @param array $options The formatting options.
     * @return string The date/time string.
     */
    public static function datetime(DateTimeInterface $value, array $options = []): string
    {
        $options['locale'] ??= static::getDefaultLocale();
        $options['timeZone'] ??= static::getDefaultTimeZone();
        $options['format'] ??= TypeParser::getType('datetime')->getLocaleFormat();
        $options['format'] ??= 'dd/MM/yyyy hh:mm a';

        return $value->clone()
            ->setLocale($options['locale'])
            ->setTimeZone($options['timeZone'])
            ->format($options['format']);
    }

    /**
     * Get the default currency.
     * @return string The default currency.
     */
    public static function getDefaultCurrency(): string
    {
        return static::$defaultCurrency;
    }

    /**
     * Get the default locale.
     * @return string The default locale.
     */
    public static function getDefaultLocale(): string
    {
        return static::$defaultLocale ??= Locale::getDefault();
    }

    /**
     * Get the default time zone.
     * @return string The default zone.
     */
    public static function getDefaultTimeZone(): string
    {
        return static::$defaultTimeZone ??= DateTime::now()->getTimeZone();
    }

    /**
     * Format a value as a number string.
     * @param string|int|float The value.
     * @param array $options The formatting options.
     * @return string The number string.
     */
    public static function number(string|int|float $value, array $options = []): string
    {
        $options['locale'] ??= static::getDefaultLocale();

        return static::getNumberFormatter($options['locale'])
            ->format((float) $value);
    }

    /**
     * Format a value as a percent string.
     * @param string|int|float The value.
     * @param array $options The formatting options.
     * @return string The percent string.
     */
    public static function percent(string|int|float $value, array $options = []): string
    {
        $options['locale'] ??= static::getDefaultLocale();

        return static::getNumberFormatter($options['locale'], NumberFormatter::PERCENT)
            ->format((float) $value);
    }

    /**
     * Set the default currency.
     * @param string $currency The currency.
     */
    public static function setDefaultCurrency(string $currency): void
    {
        static::$defaultCurrency = $currency;
    }

    /**
     * Set the default locale.
     * @param string $locale The locale.
     */
    public static function setDefaultLocale(string $locale): void
    {
        Locale::setDefault($locale);
        static::$defaultLocale = $locale;
    }

    /**
     * Set the default time zone.
     * @param string $timeZone The time zone.
     */
    public static function setDefaultTimeZone(string $timeZone): void
    {
        static::$defaultTimeZone = $timeZone;
    }

    /**
     * Format a DateTime as a time string.
     * @param DateTimeInterface The DateTime.
     * @param array $options The formatting options.
     * @return string The time string.
     */
    public static function time(DateTimeInterface $value, array $options = []): string
    {
        $options['format'] ??= TypeParser::getType('time')->getLocaleFormat();
        $options['format'] ??= 'hh:mm a';

        return static::datetime($value, $options);
    }

    /**
     * Get a NumberFormatter for a locale.
     * @param string $locale The locale.
     * @return NumberFormatter The NumberFormatter.
     */
    protected static function getNumberFormatter(string $locale, int $type = NumberFormatter::DEFAULT_STYLE): NumberFormatter
    {
        static::$numberFormatters[$locale] ??= [];
        return static::$numberFormatters[$locale][$type] ??= new NumberFormatter($locale, $type);
    }

}
