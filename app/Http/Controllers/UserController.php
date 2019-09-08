<?php

namespace App\Http\Controllers;

use App\Http\Requests\SACUserAddValidate;
use App\Http\Requests\UserUpdateValidate;
use App\Http\Resources\SACUserResource;
use App\User;
use Exception;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
//        $this->middleware('role:divya');
    }

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return SACUserResource::collection(User::role('sac')->latest()->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SACUserAddValidate $request
     * @return SACUserResource
     */
    public function store(SACUserAddValidate $request)
    {
        $user = User::create($request->validated());
        $user->assignRole('sac');
        return new SACUserResource($user);
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return SACUserResource
     */
    public function show(User $user)
    {
        return new SACUserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserUpdateValidate $request
     * @param User $user
     * @return SACUserResource
     */
    public function update(UserUpdateValidate $request, User $user)
    {
        $user->fill($request->validated());
        $user->save();
        if ($request->has('roles')) $user->syncRoles($request->get('roles'));
        return new SACUserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return Response
     * @throws Exception
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json($user, 204);
    }
}
