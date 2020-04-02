<?php

namespace App\Http\Controllers\Event;

use App\Event;
use App\EventSchedule;;
use App\Location;
use App\Lodging;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Validation\ValidationException;

class EventScheduleController extends ApiController
{
    private $rules = [
        'start_date' => 'required|date',
        'end_date' => 'required|date',
        'location' => 'required',
        'event' => 'required'                
    ];

    public function __construct()
    {
        $this->middleware('auth:api')->except(['publicIndex']);
        $this->middleware('isAdmin:api')->except(['publicIndex']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
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
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $currentUser = $request->user();
        $this->validate($request, $this->rules);

        $eventScheduleRow = array(
            'start_date'        => $request['start_date'],
            'end_date'          => $request['end_date'],
            'location_id'       => $this->getLocationId($request['location']),
            'event_id'          => $this->getEventId($request['event'], $request['event_description']),
            'lodging_id'        => $this->getLodgingId($request['lodging'], $request['lodging_url']),
            'visible'           => $request->has('visible') ? $request['visible'] : 1,
            'register_title'    => $request['register_title'],
            'register_url'      => $request['register_url'],
            'mi_title'          => $request['mi_title'],
            'mi_url'            => $request['mi_url'],
            'user_id'           => $currentUser['id'],
            'class_description' => $request['class_description']
        );

        $eventSchedule = EventSchedule::create($eventScheduleRow);

        return $this->showOne($eventSchedule, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param EventSchedule $eventSchedule
     * @return JsonResponse
     */
    public function show(EventSchedule $eventSchedule)
    {
        $eventScheduleReadModel = $this->convertToReadModel($eventSchedule);

        return $this->showOne($eventScheduleReadModel);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param EventSchedule $eventSchedule
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, EventSchedule $eventSchedule)
    {
        $currentUser = $request->user();
        $this->validate($request, $this->rules);

        $this->compareChangesAndAssign($request, $eventSchedule);
        $eventSchedule['user_id'] = $currentUser['id'];

        if(!$eventSchedule->isDirty()){
            return $this->messageResponse('Nothing to update', 200);
        }

        $eventSchedule->save();

        return $this->showOne($eventSchedule);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param EventSchedule $eventSchedule
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(EventSchedule $eventSchedule)
    {
        $eventSchedule->delete();
        return $this->showOne($eventSchedule);
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function publicIndex()
    {
        $eventSchedules = EventSchedule::all()->where('visible', true);

        $eventSchedulesReadModel = collect();

        foreach($eventSchedules as $eventSchedule)
        {
            $eventScheduleReadModel = $this->convertToReadModel($eventSchedule);
            $eventSchedulesReadModel->push($eventScheduleReadModel);
        }

        return $this->showAll($eventSchedulesReadModel);
    }

    /**
     * Compare chances and assign if there are
     * @param Request $request
     * @param EventSchedule $eventSchedule
     */
    private function compareChangesAndAssign(Request $request, EventSchedule &$eventSchedule)
    {
        if($request->has('start_date')) $eventSchedule['start_date'] = $request['start_date'];
        if($request->has('end_date')) $eventSchedule['end_date'] = $request['end_date'];
        if($request->has('location')) $eventSchedule['location_id'] = $this->getLocationId($request['location']);
        if($request->has('event')) $eventSchedule['event_id'] = $this->getEventId($request['event'], $request['event_description']);
        if($request->has('lodging') && $request->has('lodging_url'))
            $eventSchedule['lodging_id'] = $this->getLodgingId($request['lodging'], $request['lodging_url']);
        if($request->has('register_title')) $eventSchedule['register_title'] = $request['register_title'];
        if($request->has('register_url')) $eventSchedule['register_url'] = $request['register_url'];
        if($request->has('mi_title')) $eventSchedule['mi_title'] = $request['mi_title'];
        if($request->has('mi_url')) $eventSchedule['mi_url'] = $request['mi_url'];
        if($request->has('visible')) $eventSchedule['visible'] = $request['visible'];
        if($request->has('class_description')) $eventSchedule['class_description'] = $request['class_description'];
    }

    /**
     * @param EventSchedule $eventSchedule
     * @return EventSchedule
     */
    private function convertToReadModel(EventSchedule $eventSchedule){

        $eventScheduleNew = new EventSchedule();
        $eventScheduleNew->id = $eventSchedule->id;
        $eventScheduleNew['start_date'] = $eventSchedule['start_date'];
        $eventScheduleNew['end_date'] = $eventSchedule['end_date'];
        $eventScheduleNew['location'] = $eventSchedule['location'];
        $eventScheduleNew['event'] = $eventSchedule['event'];
        $eventScheduleNew['lodging'] = $eventSchedule['lodging'];
        $eventScheduleNew['register'] = $eventSchedule->register();
        $eventScheduleNew['moreInformation'] = $eventSchedule->moreInformation();
        $eventScheduleNew['visible'] = $eventSchedule['visible'];
        $eventScheduleNew['user'] = $eventSchedule['user'];
        $eventScheduleNew['created_at'] = $eventSchedule['created_at'];
        $eventScheduleNew['updated_at'] = $eventSchedule['updated_at'];
        $eventScheduleNew['class_description'] = $eventSchedule['class_description'];

        return $eventScheduleNew;
    }

    private function getEventId($eventName, $eventDescription)
    {
        $events = Event::all();
        $eventId = 0;
        // Find event in catalog if exist the description change
        foreach ($events as $event){
            if(strtolower($event['name']) == strtolower($eventName)) {
                $eventId = $event->id;
                $event['description'] = $eventDescription;
                $event->save();
                break;
            }
        }
        // if doesn't exist event then is create
        if($eventId == 0){
            $eventRow = array (
                'name' => $eventName,
                'description' => $eventDescription
                );
            $event = Event::create($eventRow);
            $eventId = $event->id;
        }
        return $eventId;
    }

    private function getLocationId($locationName)
    {
        $locations = Location::all();
        $locationId = 0;
        // find location in catalog
        foreach ($locations as $location){
            if(strtolower($location['name']) == strtolower($locationName)){
                $locationId = $location->id;
                break;
            }
        }
        // if doesn't exist location then is create
        if($locationId == 0){
            $locationRow = array( 'name' => $locationName);
            $location = Location::create($locationRow);
            $locationId = $location->id;
        }
        return $locationId;
    }

    private function getLodgingId($lodgingName, $lodgingUrl)
    {
        $lodgings = Lodging::all();
        $lodgingId = null;
        if($lodgingName != null && $lodgingUrl != null)
    {
        // find location in catalog
        foreach ($lodgings as $lodging){
            if(strtolower($lodging['name']) == strtolower($lodgingName) && $lodging['url'] == $lodgingUrl){
                $lodgingId = $lodging->id;
                break;
                }
            }
        // if doesn't exist location then is create
        if($lodgingId == null){
            $lodgingRow = array(
                'name' => $lodgingName,
                'url' => $lodgingUrl
            );
            $lodging = Lodging::create($lodgingRow);
            $lodgingId = $lodging->id;
            }
    }
        return $lodgingId;
    }
}
