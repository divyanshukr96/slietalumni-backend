<?php

namespace App\Http\Controllers;

use App\Event;
use App\EventType;
use App\Http\Requests\EventStoreValidate;
use App\Image;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param EventStoreValidate $request
     * @return \Illuminate\Http\Response
     */
    public function store(EventStoreValidate $request)
    {
        $event_type = EventType::where('name', $request->only('event'))->first();
        $event = $event_type->events()->create($request->all());
        if ($request->hasFile('image')) {
            $image = Image::create(['image' => $request->file('image')]);
            $event->image()->associate($image);
            $event->save();
        }
        return response($event);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Event $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Event $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Event $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Event $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        //
    }
}
