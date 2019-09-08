<?php

namespace App\Http\Controllers\API;

use App\Contact;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContactStoreValidation;
use App\Http\Resources\Contact as ContactResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection|Response
     */
    public function index()
    {
        return ContactResource::collection(Contact::latest()->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ContactStoreValidation $request
     * @return Response
     */
    public function store(ContactStoreValidation $request)
    {
        return response()->json([
            'data' => Contact::create($request->validated())  // should not be restricted
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Contact $contact
     * @return ContactResource|Response
     */
    public function show(Contact $contact)
    {
        return new ContactResource($contact);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Contact $contact
     * @return ContactResource|Response
     */
    public function update(Request $request, Contact $contact)
    {
        return new ContactResource($contact);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Contact $contact
     * @return Response
     */
    public function destroy(Contact $contact)
    {
        //
    }
}
