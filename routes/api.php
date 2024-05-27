<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use App\Services\CurrencyConverter\CurrencyApiService;
use App\Services\CurrencyConverter\CurrencyConverterInterface;

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

Route::get('/sync/invoices/unpaid',function(CurrencyConverterInterface $converter){


    return [
        ['id' => 229, 'client_id' => 4, 'currency' => 'USD', 'amount' =>  $converter->convert('USD','USD',220)],
        ['id' => 229, 'client_id' => 4, 'currency' => 'EUR', 'amount' => $converter->convert('USD','EUR',220)],
    ];
});
