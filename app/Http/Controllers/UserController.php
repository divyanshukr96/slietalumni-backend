<?php

namespace App\Http\Controllers;

use App\Http\Requests\SACUserAddValidate;
use App\Http\Requests\UserUpdateValidate;
use App\Http\Resources\SACUserResource;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class UserController extends Controller
{
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
     * @param int $id
     * @return SACUserResource
     */
    public function show($id)
    {
        $user = User::find($id);
        if (!$user) return response()->json([
            'message' => 'User not found !!'
        ],404);
        return new SACUserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserUpdateValidate $request
     * @param int $id
     * @return SACUserResource
     */
    public function update(UserUpdateValidate $request, $id)
    {
        $user = User::find($id);
        $user->fill($request->all());
        $user->save();
        if ($request->has('roles')) $user->syncRoles($request->get('roles'));
        return new SACUserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return response()->json();
    }
}
