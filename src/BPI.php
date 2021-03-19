<?php

namespace kristapsk\CoinDesk;

use \BadMethodCallException;

class BPI
{
    private const ENDPOINT_BASE = 'https://api.coindesk.com/v1/bpi/';
    private const SUPPORTED_CURRENCIES = [ 'EUR', 'GBP', 'USD' ];

    private static function request (string $endpoint,
        array $params = null): object
    {
        $ch = curl_init();
        $url = $endpoint;
        if (!is_null($params)) {
            $url .= '?' . http_build_query($params);
        }
        curl_setopt_array(
            $ch,
            [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true
            ]
        );
        $response = curl_exec($ch);
        curl_close($ch);
        return json_decode($response);
    }

    private static function checkCurrency (string $currency): void
    {
        if (!in_array($currency, SELF::SUPPORTED_CURRENCIES)) {
            throw new BadMethodCallException(
                "Unsupported currency $currency");
        }
    }

    public static function currentPrice (string $currency = 'USD'): ?float
    {
        self::checkCurrency($currency);
        $result =
            self::request(
                self::ENDPOINT_BASE . 'currentprice/' . $currency . '.json'
            );
        if (
            property_exists($result, 'bpi') &&
            property_exists($result->bpi, $currency) &&
            property_exists($result->bpi->$currency, 'rate_float')
        ) {
            return $result->bpi->$currency->rate_float;
        }
        else {
            return null;
        }
    }

    public static function historical (int $time_start, int $time_end,
        string $currency = 'USD'): ?array
    {
        self::checkCurrency($currency);
        $result =
            self::request(
                self::ENDPOINT_BASE . 'historical/close.json',
                [
                    'currency' => $currency,
                    'start' => date('Y-m-d', $time_start),
                    'end' => date('Y-m-d', $time_end)
                ]
            );
        if (property_exists($result, 'bpi')) {
            return (array)$result->bpi;
        }
        else {
            return null;
        }
    }
}
/*
var_dump(BPI::currentPrice());
var_dump(BPI::currentPrice('EUR'));
var_dump(BPI::historical(strtotime('2021-03-01'), strtotime('2021-03-16')));
var_dump(BPI::historical(strtotime('2021-03-01'), strtotime('2021-03-16'), 'EUR'));
*/
