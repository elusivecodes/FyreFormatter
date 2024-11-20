<?php
declare(strict_types=1);

namespace Tests;

use Fyre\Config\Config;
use Fyre\Container\Container;
use Fyre\DateTime\DateTime;
use Fyre\DB\TypeParser;
use Fyre\Utility\Formatter;
use PHPUnit\Framework\TestCase;

final class FormatterTest extends TestCase
{
    protected Formatter $formatter;

    public function testCurrency(): void
    {
        $this->assertSame(
            '$123.00',
            $this->formatter->currency(123)
        );
    }

    public function testCurrencyFloat(): void
    {
        $this->assertSame(
            '$123.46',
            $this->formatter->currency(123.456)
        );
    }

    public function testCurrencyOptions(): void
    {
        $this->assertSame(
            '£123.00',
            $this->formatter->currency(123, [
                'locale' => 'en-GB',
                'currency' => 'gbp',
            ])
        );
    }

    public function testCurrencyString(): void
    {
        $this->assertSame(
            '$123.46',
            $this->formatter->currency('123.456')
        );
    }

    public function testDate(): void
    {
        $date = new DateTime('2022-01-01');

        $this->assertSame(
            '01/01/2022',
            $this->formatter->date($date)
        );
    }

    public function testDateOptions(): void
    {
        $date = new DateTime('2022-01-01');

        $this->assertSame(
            '٢٠٢٢-٠١-٠١',
            $this->formatter->date($date, [
                'locale' => 'ar-AR',
                'format' => 'yyyy-MM-dd',
            ])
        );
    }

    public function testDateTime(): void
    {
        $date = new DateTime('2022-01-01 11:59:59');

        $this->assertSame(
            '01/01/2022 11:59 AM',
            $this->formatter->datetime($date)
        );
    }

    public function testDateTimeOptions(): void
    {
        $date = new DateTime('2022-01-01 11:59:59');

        $this->assertSame(
            '٢٠٢٢-٠١-٠١ ٠٦:٥٩:٥٩',
            $this->formatter->datetime($date, [
                'locale' => 'ar-AR',
                'timeZone' => 'America/New_York',
                'format' => 'yyyy-MM-dd HH:mm:ss',
            ])
        );
    }

    public function testNumber(): void
    {
        $this->assertSame(
            '1,234',
            $this->formatter->number(1234)
        );
    }

    public function testNumberFloat(): void
    {
        $this->assertSame(
            '1,234.567',
            $this->formatter->number(1234.567)
        );
    }

    public function testNumberString(): void
    {
        $this->assertSame(
            '1,234.567',
            $this->formatter->number('1234.567')
        );
    }

    public function testPercent(): void
    {
        $this->assertSame(
            '100%',
            $this->formatter->percent(1)
        );
    }

    public function testPercentFloat(): void
    {
        $this->assertSame(
            '12%',
            $this->formatter->percent(0.123)
        );
    }

    public function testPercentString(): void
    {
        $this->assertSame(
            '12%',
            $this->formatter->percent('0.123')
        );
    }

    public function testTime(): void
    {
        $date = new DateTime('2022-01-01 11:59:59');

        $this->assertSame(
            '11:59 AM',
            $this->formatter->time($date)
        );
    }

    public function testTimeOptions(): void
    {
        $date = new DateTime('2022-01-01 11:59:59');

        $this->assertSame(
            '٠٦:٥٩:٥٩',
            $this->formatter->time($date, [
                'locale' => 'ar-AR',
                'timeZone' => 'America/New_York',
                'format' => 'HH:mm:ss',
            ])
        );
    }

    protected function setUp(): void
    {
        $container = new Container();
        $container->singleton(TypeParser::class);
        $container->singleton(Config::class);
        $container->use(Config::class)->set('App', [
            'defaultLocale' => 'en-US',
            'defaultTimeZone' => 'UTC',
            'defaultCurrency' => 'USD',
        ]);

        $this->formatter = $container->build(Formatter::class);
    }
}
