<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/{group}/keys', 'KeysController@getKeys')->name('getKeys');

Route::post('/{group}/key/change', 'KeysController@changeKey')->name('changeKey');

Route::get('/{group}/owners', 'KeysController@getOwners')->name('getOwners');

Route::post('/{group}/owner/new', 'KeysController@newOwner')->name('newOwner');
