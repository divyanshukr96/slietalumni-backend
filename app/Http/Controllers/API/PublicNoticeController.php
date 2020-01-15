<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\PublicNoticeValidate;
use App\PublicNotice;
use Exception;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class PublicNoticeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse|Response
     */
    public function index()
    {
        return response()->json([
            'data' => PublicNotice::latest()->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PublicNoticeValidate $request
     * @return JsonResponse|Response
     */
    public function store(PublicNoticeValidate $request)
    {
        $notice = PublicNotice::create($request->validated());
        return response()->json([
            'data' => $notice
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param PublicNotice $publicnotice
     * @return Response
     */
    public function show(PublicNotice $publicnotice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PublicNoticeValidate $request
     * @param PublicNotice $publicnotice
     * @return JsonResponse|Response
     */
    public function update(PublicNoticeValidate $request, PublicNotice $publicnotice)
    {
        $publicnotice->update($request->validated());
        return response()->json([
            'data' => $publicnotice
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param PublicNotice $publicnotice
     * @return JsonResponse|Response
     * @throws Exception
     */
    public function destroy(PublicNotice $publicnotice)
    {
        $publicnotice->delete();
        return response()->json([
            'data' => $publicnotice
        ], 204);
    }
}
