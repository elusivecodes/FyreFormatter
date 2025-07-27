<?php
declare(strict_types=1);

namespace Fyre\Utility;

use Fyre\Config\Config;
use Fyre\DateTime\DateTime;
use Fyre\DB\TypeParser;
use Fyre\DB\Types\DateTimeType;
use Fyre\DB\Types\DateType;
use Fyre\DB\Types\TimeType;
use Fyre\Utility\Traits\MacroTrait;
use NumberFormatter;

use function locale_get_default;

/**
 * Formatter
 */
class Formatter
{
    use MacroTrait;

    protected DateType $dateParser;

    protected DateTimeType $dateTimeParser;

    protected string $defaultCurrency = 'USD';

    protected string|null $defaultLocale = null;

    protected string|null $defaultTimeZone = null;

    protected array $numberFormatters = [];

    protected TimeType $timeParser;

    /**
     * New Formatter constructor.
     *
     * @param TypeParser $typeParser The TypeParser.
     * @param Config $config The Config.
     */
    public function __construct(TypeParser $typeParser, Config $config)
    {
        $this->dateParser = $typeParser->use('date');
        $this->dateTimeParser = $typeParser->use('datetime');
        $this->timeParser = $typeParser->use('time');

        $this->defaultCurrency = $config->get('App.defaultCurrency', 'USD');
        $this->defaultLocale = $config->get('App.defaultLocale');
        $this->defaultTimeZone = $config->get('App.defaultTimeZone');
    }

    /**
     * Format a value as a currency string.
     *
     * @param array $options The formatting options.
     * @param float|int|string The value.
     * @return string The currency string.
     */
    public function currency(float|int|string $value, array $options = []): string
    {
        $options['locale'] ??= $this->getDefaultLocale();
        $options['currency'] ??= $this->getDefaultCurrency();

        return $this->getNumberFormatter($options['locale'], NumberFormatter::CURRENCY_ACCOUNTING)
            ->formatCurrency((float) $value, $options['currency']);
    }

    /**
     * Format a DateTime as a date string.
     *
     * @param array $options The formatting options.
     * @param DateTime The DateTime.
     * @return string The date string.
     */
    public function date(DateTime $value, array $options = []): string
    {
        $options['format'] ??= $this->dateParser->getLocaleFormat() ?? 'dd/MM/yyyy';

        return $this->datetime($value, $options);
    }

    /**
     * Format a DateTime as a date/time string.
     *
     * @param array $options The formatting options.
     * @param DateTime The DateTime.
     * @return string The date/time string.
     */
    public function datetime(DateTime $value, array $options = []): string
    {
        $options['locale'] ??= $this->getDefaultLocale();
        $options['timeZone'] ??= $this->dateTimeParser->getUserTimeZone() ?? $this->getDefaultTimeZone();
        $options['format'] ??= $this->dateTimeParser->getLocaleFormat() ?? 'dd/MM/yyyy hh:mm a';

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
    public function getDefaultCurrency(): string
    {
        return $this->defaultCurrency;
    }

    /**
     * Get the default locale.
     *
     * @return string The default locale.
     */
    public function getDefaultLocale(): string
    {
        return $this->defaultLocale ?? locale_get_default();
    }

    /**
     * Get the default time zone.
     *
     * @return string The default zone.
     */
    public function getDefaultTimeZone(): string
    {
        return $this->defaultTimeZone ?? DateTime::getDefaultTimeZone();
    }

    /**
     * Format a value as a number string.
     *
     * @param array $options The formatting options.
     * @param float|int|string The value.
     * @return string The number string.
     */
    public function number(float|int|string $value, array $options = []): string
    {
        $options['locale'] ??= $this->getDefaultLocale();

        return $this->getNumberFormatter($options['locale'])
            ->format((float) $value);
    }

    /**
     * Format a value as a percent string.
     *
     * @param array $options The formatting options.
     * @param float|int|string The value.
     * @return string The percent string.
     */
    public function percent(float|int|string $value, array $options = []): string
    {
        $options['locale'] ??= $this->getDefaultLocale();

        return $this->getNumberFormatter($options['locale'], NumberFormatter::PERCENT)
            ->format((float) $value);
    }

    /**
     * Set the default currency.
     *
     * @param string $currency The currency.
     * @return Formatter The Formatter.
     */
    public function setDefaultCurrency(string $currency): static
    {
        $this->defaultCurrency = $currency;

        return $this;
    }

    /**
     * Set the default locale.
     *
     * @param string|null $locale The locale.
     * @return Formatter The Formatter.
     */
    public function setDefaultLocale(string|null $locale): static
    {
        $this->defaultLocale = $locale;

        return $this;
    }

    /**
     * Set the default time zone.
     *
     * @param string|null $timeZone The time zone.
     * @return Formatter The Formatter.
     */
    public function setDefaultTimeZone(string|null $timeZone): static
    {
        $this->defaultTimeZone = $timeZone;

        return $this;
    }

    /**
     * Format a DateTime as a time string.
     *
     * @param array $options The formatting options.
     * @param DateTime The DateTime.
     * @return string The time string.
     */
    public function time(DateTime $value, array $options = []): string
    {
        $options['format'] ??= $this->timeParser->getLocaleFormat() ?? 'hh:mm a';

        return $this->datetime($value, $options);
    }

    /**
     * Get a NumberFormatter for a locale.
     *
     * @param string $locale The locale.
     * @return NumberFormatter The NumberFormatter.
     */
    protected function getNumberFormatter(string $locale, int $type = NumberFormatter::DEFAULT_STYLE): NumberFormatter
    {
        $this->numberFormatters[$locale] ??= [];

        return $this->numberFormatters[$locale][$type] ??= new NumberFormatter($locale, $type);
    }
}
