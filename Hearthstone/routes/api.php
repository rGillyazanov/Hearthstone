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
Route::prefix('/user')->group(function () {
    Route::post('/login', 'Api\v1\LoginController@login');
});

Route::apiResource('cards', 'Api\v1\Hearthstone\Cards\CardsController')->only('index');
Route::apiResource('heroes', 'Api\v1\Hearthstone\Heroes\HeroController')->only('index', 'show');
Route::apiResource('rarities', 'Api\v1\Hearthstone\Rarities\RarityController')->only('index');
Route::apiResource('types', 'Api\v1\Hearthstone\Types\TypeController')->only('index');
Route::apiResource('races', 'Api\v1\Hearthstone\Races\RaceController')->only('index');
Route::apiResource('mechanics', 'Api\v1\Hearthstone\Mechanics\MechanicController')->only('index');
Route::apiResource('packsets', 'Api\v1\Hearthstone\Packsets\PackSetController')->only('index');

Route::prefix('/cards')->group(function () {
    Route::get('/search', 'Api\v1\Hearthstone\Cards\SearchCardController@search')->name('cards.search');
    Route::get('/search/name', 'Api\v1\Hearthstone\Cards\SearchCardController@searchOfName')->name('cards.search');
    Route::get('/hero/cost', 'Api\v1\Hearthstone\Cards\CardsOfDecksController@cardsOfCost')->name('deck.cardsOfCost');
    Route::get('/hero/neutrals', 'Api\v1\Hearthstone\Cards\CardsOfDecksController@cardsNeutrals')->name('deck.cardsNeutrals');
    Route::get('/hero/{id}', 'Api\v1\Hearthstone\Cards\CardsOfDecksController@cardsOfHero')->name('deck.cardsOfHero');
});

Route::get('card/{id}', 'Api\v1\Hearthstone\Cards\Card\CardController@index')->name('card');

Route::get('deck/import', 'Api\v1\Hearthstone\Deck\DeckController@getCardsFromCodeDeck')->name('deck.import');
