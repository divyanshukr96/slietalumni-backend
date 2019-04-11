<?php

namespace App\Http\Controllers;

use App\AlumniDataCollection;
use App\Http\Requests\AlumniDataCollectionStoreValidate;
use Illuminate\Http\Request;
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
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
     * @param \App\AlumniDataCollection $alumniDataCollection
     * @return Response
     */
    public function show(AlumniDataCollection $alumniDataCollection)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\AlumniDataCollection $alumniDataCollection
     * @return Response
     */
    public function edit(AlumniDataCollection $alumniDataCollection)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\AlumniDataCollection $alumniDataCollection
     * @return Response
     */
    public function update(Request $request, AlumniDataCollection $alumniDataCollection)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\AlumniDataCollection $alumniDataCollection
     * @return Response
     */
    public function destroy(AlumniDataCollection $alumniDataCollection)
    {
        //
    }
}
