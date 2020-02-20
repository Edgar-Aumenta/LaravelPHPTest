<?php

namespace App\Http\Controllers\Event;

use App\Event;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class EventController extends ApiController
{
    private $rules = [
        'name' => 'required',
    ];

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $events = Event::all();

        return $this->showAll($events);
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

        $event = Event::create($request->all());

        return $this->showOne($event, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Event $event
     * @return Response
     */
    public function show(Event $event)
    {
        return $this->showOne($event);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Event $event
     * @return Response
     * @throws ValidationException
     */
    public function update(Request $request, Event $event)
    {
        $this->validate($request, $this->rules);

        if($request->has('name')) $event['name'] = $request['name'];
        if($request->has('description')) $event['description'] = $request['description'];

        if(!$event->isDirty()){
            return $this->messageResponse('Nothing to update', 200);
        }

        $event->save();
        return $this->showOne($event);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Event $event
     * @return Response
     * @throws Exception
     */
    public function destroy(Event $event)
    {
        $event->delete();

        return $this->showOne($event);
    }
}
