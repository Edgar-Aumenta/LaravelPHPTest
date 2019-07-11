<?php

namespace App\Http\Controllers\Lodging;

use App\Lodging;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class LodgingController extends ApiController
{
    private $rules = [
        'name' => 'required',
        'url' => 'required',
    ];

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lodgings = Lodging::all();

        return $this->showAll($lodgings);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->rules);

        $lodging = Lodging::create($request->all());

        return $this->showOne($lodging, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Lodging  $lodging
     * @return \Illuminate\Http\Response
     */
    public function show(Lodging $lodging)
    {
        return $this->showOne($lodging);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Lodging $lodging
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Lodging $lodging)
    {
        $this->validate($request, $this->rules);

        if($request->has('name')) $lodging->name = $request->name;
        if($request->has('url')) $lodging->url = $request->url;

        if(!$lodging->isDirty()){
            return $this->errorResponse('Se debe especificar al menos un valor diferente para actualizar', 422);
        }

        $lodging->save();

        return $this->showOne($lodging);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Lodging $lodging
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Lodging $lodging)
    {
        $lodging->delete();

        return $this->showOne($lodging);
    }
}
