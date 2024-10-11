# FyreFormatter

**FyreFormatter** is a free, open-source formatting library for *PHP*.


## Table Of Contents
- [Installation](#installation)
- [Methods](#methods)



## Installation

**Using Composer**

```
composer require fyre/formatter
```

In PHP:

```php
use Fyre\Utility\Formatter;
```


## Methods

**Currency**

Format a value as a currency string.

- `$value` is a string or number representing the value to format.
- `$options` is an array containing formatting options.
    - `$locale` is a string representing the locale, and will default to the *Formatter* default locale.
    - `$currency` is a string representing the currency, and will default to the *Formatter* default currency.

```php
$currency = Formatter::currency($value, $options);
```

**Date**

Format a [*DateTime*](https://github.com/elusivecodes/FyreDateTime) as a date string.

- `$value` is a [*DateTime*](https://github.com/elusivecodes/FyreDateTime).
- `$options` is an array containing formatting options.
    - `$locale` is a string representing the locale, and will default to the *Formatter* default locale.
    - `$timeZone` is a string representing the time zone, and will default to the *Formatter* default time zone.
    - `$format` is a string representing the format, and will default to the [*TypeParser*](https://github.com/elusivecodes/FyreTypeParser) default date user format.

```php
$date = Formatter::date($value, $options);
```

**Date/Time**

Format a [*DateTime*](https://github.com/elusivecodes/FyreDateTime) as a date/time string.

- `$value` is a [*DateTime*](https://github.com/elusivecodes/FyreDateTime).
- `$options` is an array containing formatting options.
    - `$locale` is a string representing the locale, and will default to the *Formatter* default locale.
    - `$timeZone` is a string representing the time zone, and will default to the *Formatter* default time zone.
    - `$format` is a string representing the format, and will default to the [*TypeParser*](https://github.com/elusivecodes/FyreTypeParser) default datetime user format.

```php
$datetime = Formatter::datetime($value, $options);
```

**Get Default Currency**

Get the default currency.

```php
$defaultCurrency = Formatter::getDefaultCurrency();
```

**Get Default Locale**

Get the default locale.

```php
$defaultLocale = Formatter::getDefaultLocale();
```

**Get Default Time Zone**

Get the default time zone.

```php
$defaultTimeZone = Formatter::getDefaultTimeZone();
```

**Number**

Format a value as a number string.

- `$value` is a string or number representing the value to format.
- `$options` is an array containing formatting options.
    - `$locale` is a string representing the locale, and will default to the *Formatter* default locale.

```php
$number = Formatter::number($value, $options);
```

**Percent**

Format a value as a percent string.

- `$value` is a string or number representing the value to format.
- `$options` is an array containing formatting options.
    - `$locale` is a string representing the locale, and will default to the *Formatter* default locale.

```php
$percent = Formatter::percent($value, $options);
```

**Set Default Currency**

Set the default currency.

- `$currency` is a string representing the currency code, or a *Closure* that returns the currency code.

```php
Formatter::setDefaultCurrency($currency);
```

**Set Default Locale**

Set the default locale.

- `$locale` is a string representing the locale, or a *Closure* that returns the locale.

```php
Formatter::setDefaultLocale($locale);
```

**Set Default Time Zone**

Set the default time zone.

- `$timeZone` is a string representing the time zone, or a *Closure* that returns the time zone.

```php
Formatter::setDefaultTimeZone($timeZone);
```

**Time**

Format a [*DateTime*](https://github.com/elusivecodes/FyreDateTime) as a time string.

- `$value` is a [*DateTime*](https://github.com/elusivecodes/FyreDateTime).
- `$options` is an array containing formatting options.
    - `$locale` is a string representing the locale, and will default to the *Formatter* default locale.
    - `$timeZone` is a string representing the time zone, and will default to the *Formatter* default time zone.
    - `$format` is a string representing the format, and will default to the [*TypeParser*](https://github.com/elusivecodes/FyreTypeParser) default time user format.

```php
$time = Formatter::time($value, $options);
```