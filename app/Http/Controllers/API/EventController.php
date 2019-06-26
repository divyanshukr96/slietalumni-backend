<?php

namespace App\Http\Controllers\API;

use App\Event;
use App\EventType;
use App\Http\Requests\EventStoreValidate;
use App\Http\Resources\Event as EventResource;
use App\Image;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return EventResource::collection(Event::latest()->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param EventStoreValidate $request
     * @return EventResource
     */
    public function store(EventStoreValidate $request)
    {
        $event_type = EventType::where('name', $request->only('event'))->first();
        $event = $event_type->events()->create($request->validated());
        if ($request->hasFile('image')) {
            $image = Image::create(['image' => $request->file('image')]);
            $event->image()->associate($image);
            $event->save();
        }
        return new EventResource($event);
    }

    /**
     * Display the specified resource.
     *
     * @param Event $event
     * @return Response
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param EventStoreValidate $request
     * @param Event $event
     * @return EventResource
     */
    public function update(EventStoreValidate $request, Event $event)
    {
        $event->fill($request->validated());
        if ($request->hasFile('image')) {
            $image = Image::create(['image' => $request->file('image')]);
            $event->image()->associate($image);
        }
        $event->save();
        return new EventResource($event);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Event $event
     * @return EventResource
     */
    public function publish(Request $request, Event $event)
    {
//        $event->save();
        return new EventResource($event);
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
        return response()->json($event, 204);
    }
}
