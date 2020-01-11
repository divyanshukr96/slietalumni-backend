<?php

namespace App\Http\Controllers\API;

use App\Carousel;
use App\Http\Controllers\Controller;
use App\Http\Requests\CarouselStoreValidate;
use App\Http\Resources\Carousel as CarouselResource;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class CarouselController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return CarouselResource::collection(Carousel::latest()->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CarouselStoreValidate $request
     * @return CarouselResource
     */
    public function store(CarouselStoreValidate $request)
    {
        $carousel = Carousel::create($request->validated());
        return new CarouselResource($carousel);
    }

    /**
     * Display the specified resource.
     *
     * @param Carousel $carousel
     * @return Response
     */
    public function show(Carousel $carousel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Carousel $carousel
     * @return CarouselResource
     */
    public function update(Request $request, Carousel $carousel)
    {
        $carousel->update(["active" => !$carousel->active]);
        return new CarouselResource($carousel);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Carousel $carousel
     * @return CarouselResource
     * @throws Exception
     */
    public function destroy(Carousel $carousel)
    {
        $carousel->delete();
        return new CarouselResource($carousel);
    }
}
