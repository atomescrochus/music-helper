# Trying to unify music sources into one handy package 🎶

[![Latest Version on Packagist](https://img.shields.io/packagist/v/utvarp/music-helper.svg?style=flat-square)](https://packagist.org/packages/utvarp/music-helper)
[![Total Downloads](https://img.shields.io/packagist/dt/utvarp/music-helper.svg?style=flat-square)](https://packagist.org/packages/utvarp/music-helper)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/utvarp/music-helper/master.svg?style=flat-square)](https://travis-ci.org/utvarp/music-helper)

There is a lot of source for music information around. Maybe you just want to search one of them. Maybe you need to have many of the at the same time. This package is here for you!

## Installation

You can install the package via composer:

```bash
composer require utvarp/music-helper
```

### Provider

Then add the ServiceProvider to your `config/app.php` file:

```php
'providers' => [
    ...

    Utvarp\MusicHelper\MusicHelperServiceProvider::class

    ....
]
```

## Usage

```php
$music = new Utvarp\Music();
echo $music->echoPhrase('Útvarp means radio, in Icelandic.');
```

## Testing

```bash
$ composer test
```

## Contributing

Contributions are welcome, [thanks to y'all](https://github.com/utvarp/music-helper/graphs/contributors) :)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
