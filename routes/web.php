<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'ShortLinkController@index');  
Route::post('generate-link', 'ShortLinkController@store')->name('generate.shorten.link');  
Route::get('{code}', 'ShortLinkController@shortenLinkDetail')->name('shorten.link');  
