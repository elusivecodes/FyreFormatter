<?php
declare(strict_types=1);

namespace Fyre\Utility;

use Closure;
use Fyre\DateTime\DateTime;
use Fyre\DB\TypeParser;
use NumberFormatter;

use function call_user_func;
use function locale_get_default;

/**
 * Formatter
 */
abstract class Formatter
{
    protected static Closure|string $defaultCurrency = 'USD';

    protected static Closure|string|null $defaultLocale = null;

    protected static Closure|string|null $defaultTimeZone = null;

    protected static array $numberFormatters = [];

    /**
     * Format a value as a currency string.
     *
     * @param array $options The formatting options.
     * @param float|int|string The value.
     * @return string The currency string.
     */
    public static function currency(float|int|string $value, array $options = []): string
    {
        $options['locale'] ??= static::getDefaultLocale();
        $options['currency'] ??= static::getDefaultCurrency();

        return static::getNumberFormatter($options['locale'], NumberFormatter::CURRENCY_ACCOUNTING)
            ->formatCurrency((float) $value, $options['currency']);
    }

    /**
     * Format a DateTime as a date string.
     *
     * @param array $options The formatting options.
     * @param DateTime The DateTime.
     * @return string The date string.
     */
    public static function date(DateTime $value, array $options = []): string
    {
        $options['format'] ??= TypeParser::use('date')->getLocaleFormat() ?? 'dd/MM/yyyy';

        return static::datetime($value, $options);
    }

    /**
     * Format a DateTime as a date/time string.
     *
     * @param array $options The formatting options.
     * @param DateTime The DateTime.
     * @return string The date/time string.
     */
    public static function datetime(DateTime $value, array $options = []): string
    {
        $options['locale'] ??= static::getDefaultLocale();
        $options['timeZone'] ??= static::getDefaultTimeZone();
        $options['format'] ??= TypeParser::use('datetime')->getLocaleFormat() ?? 'dd/MM/yyyy hh:mm a';

        if ($value->getLocale() !== $options['locale']) {
            $value = $value->setLocale($options['locale']);
        }

        if ($value->getTimeZone() !== $options['timeZone']) {
            $value = $value->setTimeZone($options['timeZone']);
        }

        return $value->format($options['format']);
    }

    /**
     * Get the default currency.
     *
     * @return string The default currency.
     */
    public static function getDefaultCurrency(): string
    {
        if (static::$defaultCurrency && static::$defaultCurrency instanceof Closure) {
            return call_user_func(static::$defaultCurrency);
        }

        return static::$defaultCurrency;
    }

    /**
     * Get the default locale.
     *
     * @return string The default locale.
     */
    public static function getDefaultLocale(): string
    {
        if (static::$defaultLocale && static::$defaultLocale instanceof Closure) {
            return call_user_func(static::$defaultLocale);
        }

        return static::$defaultLocale ?? locale_get_default();
    }

    /**
     * Get the default time zone.
     *
     * @return string The default zone.
     */
    public static function getDefaultTimeZone(): string
    {
        if (static::$defaultTimeZone && static::$defaultTimeZone instanceof Closure) {
            return call_user_func(static::$defaultTimeZone);
        }

        return static::$defaultTimeZone ?? DateTime::getDefaultTimeZone();
    }

    /**
     * Format a value as a number string.
     *
     * @param array $options The formatting options.
     * @param float|int|string The value.
     * @return string The number string.
     */
    public static function number(float|int|string $value, array $options = []): string
    {
        $options['locale'] ??= static::getDefaultLocale();

        return static::getNumberFormatter($options['locale'])
            ->format((float) $value);
    }

    /**
     * Format a value as a percent string.
     *
     * @param array $options The formatting options.
     * @param float|int|string The value.
     * @return string The percent string.
     */
    public static function percent(float|int|string $value, array $options = []): string
    {
        $options['locale'] ??= static::getDefaultLocale();

        return static::getNumberFormatter($options['locale'], NumberFormatter::PERCENT)
            ->format((float) $value);
    }

    /**
     * Set the default currency.
     *
     * @param Closure|string|null $currency The currency.
     */
    public static function setDefaultCurrency(Closure|string|null $currency): void
    {
        static::$defaultCurrency = $currency;
    }

    /**
     * Set the default locale.
     *
     * @param Closure|string|null $locale The locale.
     */
    public static function setDefaultLocale(Closure|string|null $locale): void
    {
        static::$defaultLocale = $locale;
    }

    /**
     * Set the default time zone.
     *
     * @param Closure|string|null $timeZone The time zone.
     */
    public static function setDefaultTimeZone(Closure|string|null $timeZone): void
    {
        static::$defaultTimeZone = $timeZone;
    }

    /**
     * Format a DateTime as a time string.
     *
     * @param array $options The formatting options.
     * @param DateTime The DateTime.
     * @return string The time string.
     */
    public static function time(DateTime $value, array $options = []): string
    {
        $options['format'] ??= TypeParser::use('time')->getLocaleFormat() ?? 'hh:mm a';

        return static::datetime($value, $options);
    }

    /**
     * Get a NumberFormatter for a locale.
     *
     * @param string $locale The locale.
     * @return NumberFormatter The NumberFormatter.
     */
    protected static function getNumberFormatter(string $locale, int $type = NumberFormatter::DEFAULT_STYLE): NumberFormatter
    {
        static::$numberFormatters[$locale] ??= [];

        return static::$numberFormatters[$locale][$type] ??= new NumberFormatter($locale, $type);
    }
}
