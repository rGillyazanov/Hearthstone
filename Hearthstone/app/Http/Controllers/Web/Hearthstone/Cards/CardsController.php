<?php

namespace App\Http\Controllers\Web\Hearthstone\Cards;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CardsController extends Controller
{
    public function index()
    {
        return view('hearthstone.white.cards.cards');
    }
}
