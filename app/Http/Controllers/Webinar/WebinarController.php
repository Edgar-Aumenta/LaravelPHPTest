<?php

namespace App\Http\Controllers\Webinar;

use App\Http\Controllers\ApiController;
use App\Webinar;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class WebinarController extends ApiController
{

    private $rules = [
        'start_date' => 'nullable|date',
        'start_time' => 'nullable|time',
        'location_id' => 'required',
        'name' => 'required',
        'user_id' => 'required'
    ];

    public function __construct()
    {
        $this->middleware('auth:api')->except(['publicIndex']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $webinars = Webinar::all();

        return $this->showAll($webinars);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->rules);

        $webinar = Webinar::create($request->all());

        return $this->showOne($webinar, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Webinar $webinar
     * @return Response
     */
    public function show(Webinar $webinar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Webinar $webinar
     * @return Response
     */
    public function update(Request $request, Webinar $webinar)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Webinar $webinar
     * @return Response
     */
    public function destroy(Webinar $webinar)
    {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function publicIndex()
    {
        $eventSchedules = Webinar::all()->where('visible', true);

        return $this->showAll($eventSchedules);
    }
}
