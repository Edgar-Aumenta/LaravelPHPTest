<?php

namespace App\Http\Controllers\Location;

use App\Location;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class LocationController extends ApiController
{
    private $rules = [
        'name' => 'required|unique:locations',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $locations = Location::all();

        return $this->showAll($locations);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->rules);

        $location = Location::create($request->all());

        return $this->showOne($location, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function show(Location $location)
    {
        $location = Location::findOrFail($location->id);

        return $this->showOne($location);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Location $location)
    {
        $location = Location::findOrFail($location->id);

        $this->validate($request, $this->rules);

        if($request->has('name')) $location->name = $request->name;

        if(!$location->isDirty()){
            return response()->json(['error' => 'Se debe especificar al menos un valor diferente para actualizar', 'code' => 422], 422);
        }

        $location->save();

        return $this->showOne($location);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function destroy(Location $location)
    {
        $location = Location::findOrFail($location->id);

        $location->delete();

        return $this->showOne($location);
    }
}
