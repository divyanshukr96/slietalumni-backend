<?php

namespace App\Http\Controllers\API;

use App\GalleryAlbum;
use App\Http\Requests\GalleryAlbumValidate;
use App\Http\Resources\GalleryAlbum as GalleryAlbumResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class GalleryAlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return GalleryAlbumResource::collection(GalleryAlbum::latest()->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param GalleryAlbumValidate $request
     * @return GalleryAlbumResource
     */
    public function store(GalleryAlbumValidate $request)
    {
        $album = GalleryAlbum::create($request->validated());
        return new GalleryAlbumResource($album);
    }

    /**
     * Display the specified resource.
     *
     * @param GalleryAlbum $album
     * @return GalleryAlbumResource
     */
    public function show(GalleryAlbum $album)
    {
        return new GalleryAlbumResource($album);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param GalleryAlbum $album
     * @return Response
     */
    public function update(Request $request, GalleryAlbum $album)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param GalleryAlbum $album
     * @return Response
     */
    public function destroy(GalleryAlbum $album)
    {
        //
    }
}
