<?php

namespace App\Http\Controllers;

use App\AlumniRegistration;
use App\Http\Requests\AlumniRegistrationStoreValidation;
use App\Http\Resources\AlumniRegisterResource;
use App\Http\Resources\RegisteredAlumni;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class AlumniRegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return RegisteredAlumni::collection(AlumniRegistration::all());
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
     * @param AlumniRegistrationStoreValidation $request
     * @return AlumniRegisterResource
     */
    public function store(AlumniRegistrationStoreValidation $request)
    {
        return new AlumniRegisterResource(AlumniRegistration::create($request->all()));
    }

    /**
     * Display the specified resource.
     *
     * @param \App\AlumniRegistration $alumniRegistration
     * @return Response
     */
    public function show(AlumniRegistration $alumniRegistration)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\AlumniRegistration $alumniRegistration
     * @return Response
     */
    public function edit(AlumniRegistration $alumniRegistration)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\AlumniRegistration $alumniRegistration
     * @return Response
     */
    public function update(Request $request, AlumniRegistration $alumniRegistration)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\AlumniRegistration $alumniRegistration
     * @return Response
     */
    public function destroy(AlumniRegistration $alumniRegistration)
    {
        //
    }
}
