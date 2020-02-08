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
        'start_date' => 'required|date',
        'start_time' => 'required',
        'time_zone_desc' => 'required',
        'name' => 'required',
        'visible' => 'required',
        'user_id' => 'required'
    ];

    public function __construct()
    {
        $this->middleware('auth:api')->except(['publicIndex']);
        $this->middleware('isAdmin:api')->except(['publicIndex']);
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
        return $this->showOne($webinar);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Webinar $webinar
     * @return Response
     * @throws ValidationException
     */
    public function update(Request $request, Webinar $webinar)
    {
        $this->validate($request, $this->rules);

        $this->compareChangesAndAssign($request, $webinar);

        if(!$webinar->isDirty()){
            return $this->errorResponse('Se debe especificar al menos un valor diferente para actualizar', 422);
        }

        $webinar->save();

        return $this->showOne($webinar);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Webinar $webinar
     * @return Response
     * @throws \Exception
     */
    public function destroy(Webinar $webinar)
    {
        $webinar->delete();
        return $this->showOne($webinar);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function publicIndex()
    {
        $eventSchedules = Webinar::all()->where('visible', true);

        $eventSchedulesReadModel = collect();

        foreach ($eventSchedules as $eventSchedule){
            $eventSchedulesReadModel->push($eventSchedule);
        }

        return $this->showAll($eventSchedulesReadModel);
    }

    /**
     * Compare chances and assign if there are
     * @param Request $request
     * @param Webinar $webinar
     */
    private function compareChangesAndAssign(Request $request, Webinar &$webinar)
    {
        if($request->has('start_date')) $webinar->start_date = $request->start_date;
        if($request->has('start_time')) $webinar->start_time = $request->start_time;
        if($request->has('time_zone_desc')) $webinar->time_zone_desc = $request->time_zone_desc;
        if($request->has('name')) $webinar->name = $request->name;
        if($request->has('register_url')) $webinar->register_url = $request->register_url;
        if($request->has('recoded_url')) $webinar->recoded_url = $request->recoded_url;
        if($request->has('visible')) $webinar->visible = $request->visible;
        if($request->has('description')) $webinar->description = $request->description;
        if($request->has('user_id')) $webinar->user_id = $request->user_id;
    }
}
