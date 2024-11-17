# FyreFormatter

**FyreFormatter** is a free, open-source formatting library for *PHP*.


## Table Of Contents
- [Installation](#installation)
- [Basic Usage](#basic-usage)
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


## Basic Usage

- `$typeParser` is a [*TypeParser*](https://github.com/elusivecodes/FyreTypeParser).
- `$config` is a [*Config*](https://github.com/elusivecodes/FyreConfig).

```php
$formatter = new Formatter($typeParser, $config);
```

Default configuration options will be resolved from the "*App*" key in the [*Config*](https://github.com/elusivecodes/FyreConfig).

- `$options` is an array containing configuration options.
    - `locale` is a string representing the default locale, and will default to the system default.
    - `timeZone` is a string representing the default time zone, and will default to the system default.
    - `currency` is a string representing the default currency, and will default to "*USD*".

```php
$container->use(Config::class)->set('App', $options);
```

**Autoloading**

It is recommended to bind the *Formatter* to the [*Container*](https://github.com/elusivecodes/FyreContainer) as a singleton.

```php
$container->singleton(Formatter::class);
```

Any dependencies will be injected automatically when loading from the [*Container*](https://github.com/elusivecodes/FyreContainer).

```php
$formatter = $container->use(Formatter::class);
```


## Methods

**Currency**

Format a value as a currency string.

- `$value` is a string or number representing the value to format.
- `$options` is an array containing formatting options.
    - `$locale` is a string representing the locale, and will default to the *Formatter* default locale.
    - `$currency` is a string representing the currency, and will default to the *Formatter* default currency.

```php
$currency = $formatter->currency($value, $options);
```

**Date**

Format a [*DateTime*](https://github.com/elusivecodes/FyreDateTime) as a date string.

- `$value` is a [*DateTime*](https://github.com/elusivecodes/FyreDateTime).
- `$options` is an array containing formatting options.
    - `$locale` is a string representing the locale, and will default to the *Formatter* default locale.
    - `$timeZone` is a string representing the time zone, and will default to the *Formatter* default time zone.
    - `$format` is a string representing the format, and will default to the [*TypeParser*](https://github.com/elusivecodes/FyreTypeParser) default date user format.

```php
$date = $formatter->date($value, $options);
```

**Date/Time**

Format a [*DateTime*](https://github.com/elusivecodes/FyreDateTime) as a date/time string.

- `$value` is a [*DateTime*](https://github.com/elusivecodes/FyreDateTime).
- `$options` is an array containing formatting options.
    - `$locale` is a string representing the locale, and will default to the *Formatter* default locale.
    - `$timeZone` is a string representing the time zone, and will default to the *Formatter* default time zone.
    - `$format` is a string representing the format, and will default to the [*TypeParser*](https://github.com/elusivecodes/FyreTypeParser) default datetime user format.

```php
$datetime = $formatter->datetime($value, $options);
```

**Get Default Currency**

Get the default currency.

```php
$defaultCurrency = $formatter->getDefaultCurrency();
```

**Get Default Locale**

Get the default locale.

```php
$defaultLocale = $formatter->getDefaultLocale();
```

**Get Default Time Zone**

Get the default time zone.

```php
$defaultTimeZone = $formatter->getDefaultTimeZone();
```

**Number**

Format a value as a number string.

- `$value` is a string or number representing the value to format.
- `$options` is an array containing formatting options.
    - `$locale` is a string representing the locale, and will default to the *Formatter* default locale.

```php
$number = $formatter->number($value, $options);
```

**Percent**

Format a value as a percent string.

- `$value` is a string or number representing the value to format.
- `$options` is an array containing formatting options.
    - `$locale` is a string representing the locale, and will default to the *Formatter* default locale.

```php
$percent = $formatter->percent($value, $options);
```

**Set Default Currency**

Set the default currency.

- `$currency` is a string representing the currency code, or a *Closure* that returns the currency code.

```php
$formatter->setDefaultCurrency($currency);
```

**Set Default Locale**

Set the default locale.

- `$locale` is a string representing the locale, or a *Closure* that returns the locale.

```php
$formatter->setDefaultLocale($locale);
```

**Set Default Time Zone**

Set the default time zone.

- `$timeZone` is a string representing the time zone, or a *Closure* that returns the time zone.

```php
$formatter->setDefaultTimeZone($timeZone);
```

**Time**

Format a [*DateTime*](https://github.com/elusivecodes/FyreDateTime) as a time string.

- `$value` is a [*DateTime*](https://github.com/elusivecodes/FyreDateTime).
- `$options` is an array containing formatting options.
    - `$locale` is a string representing the locale, and will default to the *Formatter* default locale.
    - `$timeZone` is a string representing the time zone, and will default to the *Formatter* default time zone.
    - `$format` is a string representing the format, and will default to the [*TypeParser*](https://github.com/elusivecodes/FyreTypeParser) default time user format.

```php
$time = $formatter->time($value, $options);
```