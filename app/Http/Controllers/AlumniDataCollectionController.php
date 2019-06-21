<?php

namespace App\Http\Controllers;

use App\AlumniDataCollection;
use App\Http\Requests\AlumniDataCollectionStoreValidate;
use App\Http\Requests\AlumniDataCollectionUpdateValidate;
use Illuminate\Http\Response;

class AlumniDataCollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return response()->json(AlumniDataCollection::all());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param AlumniDataCollectionStoreValidate $request
     * @return Response
     */
    public function store(AlumniDataCollectionStoreValidate $request)
    {
        $alumni = AlumniDataCollection::create($request->all());
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
        return response()->json(AlumniDataCollection::find($id));
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
        $alumni = AlumniDataCollection::find($id);
        $alumni->update($request->all());
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
        $alumni = AlumniDataCollection::findOrFail($id);
        $alumni->delete();
        return response()->json($alumni, 204);
    }
}
