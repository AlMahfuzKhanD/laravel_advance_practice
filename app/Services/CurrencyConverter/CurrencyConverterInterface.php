<?php

namespace App\Services\CurrencyConverter;



interface CurrencyConverterInterface
{
    function convert(string $from, string $to, int|float $amount):float;
}