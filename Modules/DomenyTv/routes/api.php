<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\DomenyTv\App\Http\Controllers\AccountBalanceController;

/*
    |--------------------------------------------------------------------------
    | API Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register API routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | is assigned the "api" middleware group. Enjoy building your API!
    |
*/

Route::middleware([])->name('api.')->group(function () {
    Route::get('domenytv', 'AccountBalanceController@index')->name('domenytv');
});
