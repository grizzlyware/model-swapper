# Swap vendor models out for your own implementations, on the fly

[![Latest Version on Packagist](https://img.shields.io/packagist/v/grizzlyware/model-swapper.svg?style=flat-square)](https://packagist.org/packages/grizzlyware/model-swapper)
[![Tests](https://github.com/grizzlyware/model-swapper/actions/workflows/run-tests.yml/badge.svg?branch=main)](https://github.com/grizzlyware/model-swapper/actions/workflows/run-tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/grizzlyware/model-swapper.svg?style=flat-square)](https://packagist.org/packages/grizzlyware/model-swapper)

This package can be used to use your own applications implementation of a model which has been provided by a vendor package. This can be useful to manipulate behaviour on a model, access protected properties or use classes in your own namespace.

Extending a vendor's class is already possible, but you cannot change vendors invocation of the class. All references will still point to the original class name and namespace.

This package will change the actual class that is returned from Eloquent query builders, including `all()`, `first()`, `findOrFail()` etc.

For example:

```php
// Code which may exist out of your control, in a vendor's package for example
\Vendor\Package\Models\CountryCode::firstOrFail() // \Vendor\Package\Models\CountryCode is returned

// With Model Swapper
\Vendor\Package\Models\CountryCode::firstOrFail() // \App\Models\CountryCode is returned
```

## Installation

You can install the package via composer:

```bash
composer require grizzlyware/model-swapper
```

## Usage

```php
// TODO
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Security Vulnerabilities

Please notify contact@grizzlyware.com about any security vulnerabilities, do not open an issue for them.

## Credits

- [Grizzlyware Ltd](https://github.com/grizzlyware)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
