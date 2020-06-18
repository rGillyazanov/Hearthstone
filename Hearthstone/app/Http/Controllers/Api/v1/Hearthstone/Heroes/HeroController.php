<?php

namespace App\Http\Controllers\Api\v1\Hearthstone\Heroes;

use App\Http\Controllers\Api\v1\Hearthstone\BaseController;
use App\Services\Api\v1\Hearthstone\Heroes\HeroService;

class HeroController extends BaseController
{
    private $heroService;

    public function __construct(HeroService $heroService)
    {
        $this->heroService = $heroService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $heroes = $this->heroService->getHeroes();

        return $this->sendResponse($heroes, "Все герои");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $hero = $this->heroService->getHero($id);

        return $this->sendResponse($hero, "Герой");
    }
}
