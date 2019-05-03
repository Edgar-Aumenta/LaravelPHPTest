<?php

namespace App\Http\Controllers\Event;

use App\EventSchedule;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class EventScheduleController extends ApiController
{
    private $rules = [
        'start_date' => 'nullable|date',
        'end_date' => 'nullable|date',
        'location_id' => 'required',
        'event_id' => 'required',
        'lodging_id' => 'required',
        'user_id' => 'required'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $eventSchedules = EventSchedule::all();

        $eventSchedulesReadModel = collect();

        foreach($eventSchedules as $eventSchedule)
        {
            $eventScheduleReadModel = $this->convertToReadModel($eventSchedule);
            $eventSchedulesReadModel->push($eventScheduleReadModel);
        }

        return $this->showAll($eventSchedulesReadModel);
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

        $eventSchedule = EventSchedule::create($request->all());

        return $this->showOne($eventSchedule, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\EventSchedule  $eventSchedule
     * @return \Illuminate\Http\Response
     */
    public function show(EventSchedule $eventSchedule)
    {
        $eventSchedule = EventSchedule::findOrFail($eventSchedule->id);

        $eventScheduleReadModel = $this->convertToReadModel($eventSchedule);

        return $this->showOne($eventScheduleReadModel);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\EventSchedule  $eventSchedule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EventSchedule $eventSchedule)
    {
        $eventSchedule = EventSchedule::findOrFail($eventSchedule->id);

        $this->validate($request, $this->rules);

        $this->compareChangesAndAssign($request, $eventSchedule);
        
        if(!$eventSchedule->isDirty()){
            return response()->json(['error' => 'Se debe especificar al menos un valor diferente para actualizar', 'code' => 422], 422);
        }

        $eventSchedule->save();

        return $this->showOne($eventSchedule);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\EventSchedule  $eventSchedule
     * @return \Illuminate\Http\Response
     */
    public function destroy(EventSchedule $eventSchedule)
    {
        $eventSchedule = EventSchedule::findOrFail($eventSchedule->id);

        $eventSchedule->delete();

        return $this->showOne($eventSchedule);
    }

    /**
     * Compare chances and assign if there are
     * @param \Illuminate\Http\Request  $request
     * @param  \App\EventSchedule  $event Reference param
     */
    private function compareChangesAndAssign(Request $request, EventSchedule &$eventSchedule)
    {
        if($request->has('start_date')) $eventSchedule->start_date = $request->start_date;
        if($request->has('end_date')) $eventSchedule->end_date = $request->end_date;
        if($request->has('location_id')) $eventSchedule->location_id = $request->location_id;
        if($request->has('event_id')) $eventSchedule->event_id = $request->event_id;
        if($request->has('lodging_id')) $eventSchedule->lodging_id = $request->lodging_id;
        if($request->has('register_title')) $eventSchedule->register_title = $request->register_title;
        if($request->has('register_url')) $eventSchedule->register_url = $request->register_url;
        if($request->has('mi_title')) $eventSchedule->mi_title = $request->mi_title;
        if($request->has('mi_url')) $eventSchedule->mi_url = $request->mi_url;
        if($request->has('visible')) $eventSchedule->visible = $request->visible;
        if($request->has('user_id')) $eventSchedule->user_id = $request->user_id;
    }

    private function convertToReadModel(EventSchedule $eventSchedule){

        $eventScheduleNew = new EventSchedule();
        $eventScheduleNew->id = $eventSchedule->id;
        $eventScheduleNew->start_date = $eventSchedule->start_date;
        $eventScheduleNew->end_date = $eventSchedule->end_date;
        $eventScheduleNew->location = $eventSchedule->location;
        $eventScheduleNew->event = $eventSchedule->event;
        $eventScheduleNew->lodging = $eventSchedule->lodging;
        $eventScheduleNew->register = $eventSchedule->register();
        $eventScheduleNew->moreInformation = $eventSchedule->moreInformation();
        $eventScheduleNew->visible = $eventSchedule->visible;
        $eventScheduleNew->user = $eventSchedule->user;
        $eventScheduleNew->created_at = $eventSchedule->created_at;
        $eventScheduleNew->updated_at = $eventSchedule->updated_at;

        return $eventScheduleNew;
    }
}
