<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleStoreValidate;
use App\Http\Requests\RoleUpdateValidate;
use App\Http\Resources\Role as RoleResource;
use App\Role;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;


class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return RoleResource::collection(Role::latest()->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RoleStoreValidate $request
     * @return RoleResource
     */
    public function store(RoleStoreValidate $request)
    {
        $role = Role::create($request->validated());
        $role->givePermissionTo($request->input('permission'));
        return new RoleResource($role);
    }

    /**
     * Display the specified resource.
     *
     * @param Role $role
     * @return RoleResource
     */
    public function show(Role $role)
    {
        return new RoleResource($role);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param RoleUpdateValidate $request
     * @param int $id
     * @return RoleResource
     */
    public function update(RoleUpdateValidate $request, $id)
    {
        $role = Role::findById($id);
        $d_name = $request->get('display_name');
        $desc = $request->get('description');
        if ($d_name != $role->display_name) $role->display_name = $d_name;
        if ($desc != $role->description) $role->description = $desc;
        $role->save();
        $role->syncPermissions($request->get('permission'));
        return new RoleResource($role);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
