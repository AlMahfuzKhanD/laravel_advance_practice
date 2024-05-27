<?php

namespace App\Services\CurrencyConverter;

use Illuminate\Support\Facades\Cache;
use App\Services\CurrencyConverter\CurrencyConverterInterface;


class CurrencyApiService implements CurrencyConverterInterface
{
    function convert(string $from, string $to, int|float $amount):float
    {
        $currencyApiKey = config('currency_api.key');
        $rates = Cache::remember('currency_rates',now()->addHours(12),function() use($currencyApiKey){
             $resp = \Illuminate\Support\Facades\Http::get("https://api.currencyapi.com/v3/latest?apikey={$currencyApiKey}&currencies=EUR%2CUSD%2CCAD");
             if($resp->ok()){
                 $rates = $resp->json()['data'];
                 return $rates;
             }else{
                 throw new \RuntimeException('Currency Api Error');
             }
             
         });

         return round($rates[$to]['value'] * $amount);
    }
    

}