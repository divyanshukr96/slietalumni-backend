<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermissionStoreValidate;
use App\Http\Requests\PermissionUpdateValidate;
use App\Http\Resources\Permission as PermissionResource;
use App\Permission;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return PermissionResource::collection(Permission::latest()->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PermissionStoreValidate $request
     * @return PermissionResource
     */
    public function store(PermissionStoreValidate $request)
    {
        return new PermissionResource(Permission::create($request->validated()));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return PermissionResource
     */
    public function show($id)
    {
        return new PermissionResource(Permission::findById($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PermissionUpdateValidate $request
     * @param int $id
     * @return PermissionResource
     */
    public function update(PermissionUpdateValidate $request, $id)
    {
        $per = Permission::findById($id);
        $d_name = $request->get('display_name');
        $desc = $request->get('description');
        if ($d_name != $per->display_name) $per->display_name = $d_name;
        if ($desc != $per->description) $per->description = $desc;
        $per->save();
        return new PermissionResource($per);
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
