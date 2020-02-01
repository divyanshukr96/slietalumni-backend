<?php

namespace App\Http\Controllers\API;

use App\GalleryImage;
use App\Http\Requests\GalleryImageValidate;
use App\Http\Resources\GalleryImage as GalleryImageResource;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class GalleryImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return GalleryImageResource::collection(GalleryImage::latest()->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param GalleryImageValidate $request
     * @return GalleryImageResource
     */
    public function store(GalleryImageValidate $request)
    {
        $image = GalleryImage::create($request->validated());

        if ($image->image) {
            list($width, $height) = getimagesize($image->image->getPath('thumb'));
            $image->width = $width;
            $image->height = $height;
            $image->save();
        }

        return new GalleryImageResource($image);
    }

    /**
     * Display the specified resource.
     *
     * @param GalleryImage $image
     * @return GalleryImageResource
     */
    public function show(GalleryImage $image)
    {
        return new GalleryImageResource($image);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param GalleryImage $image
     * @return Response
     */
    public function update(Request $request, GalleryImage $image)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param GalleryImage $image
     * @return JsonResponse|Response
     * @throws Exception
     */
    public function destroy(GalleryImage $image)
    {
        $image->delete();
        return response()->json([], 204);
    }
}
