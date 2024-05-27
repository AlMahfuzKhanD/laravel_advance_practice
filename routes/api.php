<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/sync/invoices/unpaid',function(){

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


    return [
        ['id' => 229, 'client_id' => 4, 'currency' => 'USD', 'amount' =>  round($rates['USD']['value']*220,2)],
        ['id' => 229, 'client_id' => 4, 'currency' => 'EUR', 'amount' => round($rates['EUR']['value']*220,2)],
    ];
});
