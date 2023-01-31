# Laravel URL Tracker

[![Latest Version on Packagist](https://img.shields.io/packagist/v/kaantanis/url-tracker.svg?style=flat-square)](https://packagist.org/packages/kaantanis/url-tracker)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/kaantanis/url-tracker/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/kaantanis/url-tracker/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/kaantanis/url-tracker/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/kaantanis/url-tracker/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/kaantanis/url-tracker.svg?style=flat-square)](https://packagist.org/packages/kaantanis/url-tracker)

If a user create short url, this package will track the url and store the data in database.

## Installation

You can install the package via composer:

```bash
composer require kaantanis/url-tracker
```

You can publish and run the migrations and config with:

```bash
php artisan install:url-tracker
```

This is the contents of the published config file:

```php
return [
    'prefix' => 'url-tracker', // example.com/url-tracker/QSGHG2
    'check-last-visit-minute' => 30 // check last 30 min same user visited this url. if not, increase view count
];
```

## Usage

```php
// Send post request to this url with tracked_url parameter
// example.com/url-tracker/generate-url (route name is url-tracker.generate-url)

Http::post(route('url-tracker.generate-url'), [
    'tracked_url' => 'https://google.com'
]);

// This return a string url path like this with a unique code
// example.com/url-tracker/QSGHG2

// If any visitor visit this url, user see the url and click it,
// this package will track the url and store the data in database.
```

## Which data will be stored in database?

```php
// main table
[
    'created_by' => auth()->id() ?? null,
    'url' => $request->tracked_url,
    'placeholder' => $uniqueCode
]

// and log table
[
    'url_tracker_table_id' => $urlFound->id,
    'ip_address' => request()->ip(),
    'user_agent' => request()->userAgent(),
    'referer' => request()->headers->get('referer'),
    'method' => request()->method(),
]
```


## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Kaan](https://github.com/KaanTanis)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
