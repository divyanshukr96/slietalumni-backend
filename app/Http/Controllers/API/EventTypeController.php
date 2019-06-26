<?php

namespace App\Http\Controllers\API;

use App\EventType;
use App\Http\Requests\EventTypeStoreValidate;
use App\Http\Resources\EventType as EventTypeResource;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class EventTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return EventTypeResource::collection(EventType::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param EventTypeStoreValidate $request
     * @return EventTypeResource
     */
    public function store(EventTypeStoreValidate $request)
    {
        return new EventTypeResource(EventType::create($request->validated()));
    }

    /**
     * Display the specified resource.
     *
     * @param EventType $event_type
     * @return Response
     */
    public function show(EventType $event_type)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param EventTypeStoreValidate $request
     * @param EventType $event_type
     * @return EventTypeResource
     */
    public function update(EventTypeStoreValidate $request, EventType $event_type)
    {
        $event_type->fill($request->validated());
        $event_type->save();
        return new EventTypeResource($event_type);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param EventType $event_type
     * @return Response
     * @throws Exception
     */
    public function destroy(EventType $event_type)
    {
        $event_type->delete();
        return response()->json($event_type, 204);
    }
}
