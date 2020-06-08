<?php

namespace App\Http\Controllers\Api\v1\Hearthstone\Mechanics;

use App\Http\Controllers\Api\v1\Hearthstone\BaseController;
use App\Services\Api\v1\Hearthstone\Mechanics\MechanicService;
use Illuminate\Http\Request;

class MechanicController extends BaseController
{
    private $mechanicService;

    public function __construct(MechanicService $mechanicService)
    {
        $this->mechanicService = $mechanicService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $mechanics = $this->mechanicService->getMechanics();

        return $this->sendResponse($mechanics, "Все механики карт");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
