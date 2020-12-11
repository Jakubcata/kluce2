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

Route::get('/keys', 'KeysController@getKeys')->name('getKeys');

Route::post('/key/change', 'KeysController@changeKey')->name('changeKey');

Route::get('/owners', 'KeysController@getOwners')->name('getOwners');

Route::post('/owner/new', 'KeysController@newOwner')->name('newOwner');
