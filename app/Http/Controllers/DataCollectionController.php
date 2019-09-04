<?php

namespace App\Http\Controllers;

use App\DataCollection;
use App\Http\Requests\AlumniDataCollectionStoreValidate;
use App\Http\Requests\AlumniDataCollectionUpdateValidate;
use Illuminate\Http\Response;

class DataCollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return response()->json(DataCollection::all());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param AlumniDataCollectionStoreValidate $request
     * @return Response
     */
    public function store(AlumniDataCollectionStoreValidate $request)
    {
        $alumni = DataCollection::create($request->validated());
        return response()->json($alumni, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return Response
     */
    public function show($id)
    {
        return response()->json(DataCollection::find($id));
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
