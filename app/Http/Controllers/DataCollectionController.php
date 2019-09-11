<?php

namespace App\Http\Controllers;

use App\DataCollection;
use App\Http\Requests\AlumniDataCollectionStoreValidate;
use App\Http\Requests\AlumniDataCollectionUpdateValidate;
use App\Http\Resources\DataCollection as DataCollectionResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class DataCollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection|Response
     */
    public function index()
    {
        return DataCollectionResource::collection(DataCollection::all());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param AlumniDataCollectionStoreValidate $request
     * @return DataCollectionResource|Response
     */
    public function store(AlumniDataCollectionStoreValidate $request)
    {
        $alumni = DataCollection::create($request->validated());
        if ($request->get('organisation')) $alumni->professional()->create($request->validated());
        if ($request->get('programme')) $alumni->academic()->create($request->validated());
        return new DataCollectionResource($alumni);
    }

    /**
     * Display the specified resource.
     *
     * @param DataCollection $alumni_datum
     * @return DataCollectionResource|Response
     */
    public function show(DataCollection $alumni_datum)
    {
        return new DataCollectionResource($alumni_datum);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param AlumniDataCollectionUpdateValidate $request
     * @param DataCollection $alumni_datum
     * @return DataCollectionResource|Response
     */
    public function update(AlumniDataCollectionUpdateValidate $request, DataCollection $alumni_datum)
    {
        $alumni_datum->update($request->validated());
        if ($alumni_datum->professional) $alumni_datum->professional->update($request->validated());
        else $alumni_datum->professional()->create($request->validated());

        if ($alumni_datum->academic) $alumni_datum->academic->update($request->validated());
        else $alumni_datum->academic()->create($request->validated());

        return new DataCollectionResource($alumni_datum);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return Response
     */
    public function destroy($id)
    {
        $alumni = DataCollection::findOrFail($id);
        $alumni->delete();
        return response()->json($alumni, 204);
    }
}
