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
Route::apiResource('cards', 'Api\v1\Hearthstone\Cards\CardController')->only('index');
Route::get('cards/search', 'Api\v1\Hearthstone\Cards\SearchCardController@search')->name('cards.search');

Route::apiResource('heroes', 'Api\v1\Hearthstone\Heroes\HeroController')->only('index');
Route::apiResource('rarities', 'Api\v1\Hearthstone\Rarities\RarityController')->only('index');
Route::apiResource('types', 'Api\v1\Hearthstone\Types\TypeController')->only('index');
Route::apiResource('races', 'Api\v1\Hearthstone\Races\RaceController')->only('index');
Route::apiResource('mechanics', 'Api\v1\Hearthstone\Mechanics\MechanicController')->only('index');
Route::apiResource('packsets', 'Api\v1\Hearthstone\Packsets\PackSetController')->only('index');