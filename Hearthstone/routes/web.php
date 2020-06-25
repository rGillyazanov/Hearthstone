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

Auth::routes();

Route::get('/', 'Web\Hearthstone\Cards\CardsController@index')->name('home');
Route::get('/card/{id}', 'Web\Hearthstone\Cards\CardsController@index')->name('card');
Route::get('/information', 'Web\Hearthstone\Cards\CardsController@index')->name('information');
Route::get('/deckbuilder', 'Web\Hearthstone\Cards\CardsController@index')->name('deck.builder');
Route::get('/deckbuilder/hero/{id}', 'Web\Hearthstone\Cards\CardsController@index')->name('deck.builder.hero');
Route::get('/deck/{deck}', 'Web\Hearthstone\Cards\CardsController@index')->name('deck');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
