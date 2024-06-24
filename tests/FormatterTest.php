<?php
declare(strict_types=1);

namespace Tests;

use Fyre\DateTime\DateTime;
use Fyre\Utility\Formatter;
use PHPUnit\Framework\TestCase;

final class FormatterTest extends TestCase
{
    public function setUp(): void
    {
        Formatter::setDefaultCurrency('usd');
        Formatter::setDefaultLocale('en-US');
        Formatter::setDefaultTimeZone('UTC');
    }

    public function testCurrency(): void
    {
        $this->assertSame(
            '$123.00',
            Formatter::currency(123)
        );
    }

    public function testCurrencyFloat(): void
    {
        $this->assertSame(
            '$123.46',
            Formatter::currency(123.456)
        );
    }

    public function testCurrencyOptions(): void
    {
        $this->assertSame(
            '£123.00',
            Formatter::currency(123, [
                'locale' => 'en-GB',
                'currency' => 'gbp'
            ])
        );
    }

    public function testCurrencyString(): void
    {
        $this->assertSame(
            '$123.46',
            Formatter::currency('123.456')
        );
    }

    public function testDate(): void
    {
        $date = new DateTime('2022-01-01');

        $this->assertSame(
            '01/01/2022',
            Formatter::date($date)
        );
    }

    public function testDateOptions(): void
    {
        $date = new DateTime('2022-01-01');

        $this->assertSame(
            '٢٠٢٢-٠١-٠١',
            Formatter::date($date, [
                'locale' => 'ar-AR',
                'format' => 'yyyy-MM-dd'
            ])
        );
    }

    public function testDateTime(): void
    {
        $date = new DateTime('2022-01-01 11:59:59');

        $this->assertSame(
            '01/01/2022 11:59 AM',
            Formatter::datetime($date)
        );
    }

    public function testDateTimeOptions(): void
    {
        $date = new DateTime('2022-01-01 11:59:59');

        $this->assertSame(
            '٢٠٢٢-٠١-٠١ ٠٦:٥٩:٥٩',
            Formatter::datetime($date, [
                'locale' => 'ar-AR',
                'timeZone' => 'America/New_York',
                'format' => 'yyyy-MM-dd HH:mm:ss'
            ])
        );
    }

    public function testNumber(): void
    {
        $this->assertSame(
            '1,234',
            Formatter::number(1234)
        );
    }

    public function testNumberFloat(): void
    {
        $this->assertSame(
            '1,234.567',
            Formatter::number(1234.567)
        );
    }

    public function testNumberString(): void
    {
        $this->assertSame(
            '1,234.567',
            Formatter::number('1234.567')
        );
    }

    public function testPercent(): void
    {
        $this->assertSame(
            '100%',
            Formatter::percent(1)
        );
    }

    public function testPercentFloat(): void
    {
        $this->assertSame(
            '12%',
            Formatter::percent(0.123)
        );
    }

    public function testPercentString(): void
    {
        $this->assertSame(
            '12%',
            Formatter::percent('0.123')
        );
    }

    public function testTime(): void
    {
        $date = new DateTime('2022-01-01 11:59:59');

        $this->assertSame(
            '11:59 AM',
            Formatter::time($date)
        );
    }

    public function testTimeOptions(): void
    {
        $date = new DateTime('2022-01-01 11:59:59');

        $this->assertSame(
            '٠٦:٥٩:٥٩',
            Formatter::time($date, [
                'locale' => 'ar-AR',
                'timeZone' => 'America/New_York',
                'format' => 'HH:mm:ss'
            ])
        );
    }
}
