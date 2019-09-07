<?php

namespace App\Http\Controllers;

use App\DataCollection;
use App\Http\Requests\AlumniDataCollectionStoreValidate;
use App\Http\Requests\AlumniDataCollectionUpdateValidate;
use App\Http\Resources\DataCollection as DataCollectionResource;
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
     * @param $id
     * @return Response
     */
    public function update(AlumniDataCollectionUpdateValidate $request, $id)
    {
        return response()->json('Should add observer on updating so that proper academic and professional detail can be updated', 400);
        $alumni = DataCollection::find($id);
        $alumni->update($request->validated());
        return response()->json($alumni, 200);
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
