<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\MemberStoreValidation;
use App\Http\Requests\MemberUpdateValidation;
use App\Http\Resources\Member as MemberResource;
use App\Member;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection|Response
     */
    public function index()
    {
        return MemberResource::collection(Member::latest()->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param MemberStoreValidation $request
     * @return MemberResource|Response
     */
    public function store(MemberStoreValidation $request)
    {
        $member = Member::create($request->all());
        return new MemberResource($member);
    }

    /**
     * Display the specified resource.
     *
     * @param Member $member
     * @return void
     */
    public function show(Member $member)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param MemberUpdateValidation $request
     * @param Member $member
     * @return MemberResource|Response
     */
    public function update(MemberUpdateValidation $request, Member $member)
    {
        $member->update($request->validated());
        return new MemberResource($member);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Member $member
     * @return JsonResponse|Response
     * @throws Exception
     */
    public function destroy(Member $member)
    {
        $member->delete();
        return response()->json($member, 204);
    }
}
