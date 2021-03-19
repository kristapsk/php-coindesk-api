# CoinDesk Bitcoin Price Index API for PHP

[![tippin.me](https://badgen.net/badge/%E2%9A%A1%EF%B8%8Ftippin.me/@kristapsk/F0918E)](https://tippin.me/@kristapsk)

This is a simple composer package that implements [CoinDesk Bitcoin Price Index API](https://www.coindesk.com/coindesk-api) for PHP.

## Requirements

- PHP 7 with curl and json extensions enabled

## Installation

```
composer require kristapsk/php-coindesk-api
```

Or just copy `src/BPI.php` to your project, it has no other dependencies.

## Usage

In all examples last parameter of methods called specifies currency. Supported currencies are `EUR`, `GBP` and `USD`. It can be ommited, will default to `USD`.

### Get current Bitcoin price

```php
use kristapsk\CoinDesk\BPI;

// returns float or null on failure
var_dump(BPI::currentPrice('EUR'));
```

### Get historical Bitcoin prices

```php
use kristapsk\CoinDesk\BPI;

// returns array with Y-m-d format date string as key and float price as value
// or null on failure
var_dump(BPI::historical(strtotime('2021-03-01'), strtotime('2021-03-16'), 'EUR'));
```

## License

This package is released under the MIT License. See the bundled [LICENSE](LICENSE.md) file for details.

## Disclaimer

This project is not in any way affiliated with CoinDesk.

