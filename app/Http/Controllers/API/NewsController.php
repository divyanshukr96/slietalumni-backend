<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\NewsPublishValidate;
use App\Http\Requests\NewsStoreValidate;
use App\Http\Resources\News as NewsResource;
use App\News;
use Carbon\Carbon;
use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return NewsResource::collection(News::latest()->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param NewsStoreValidate $request
     * @return NewsResource
     */
    public function store(NewsStoreValidate $request)
    {
        $news = News::create($request->validated());
        if ($request->hasFile('cover')) {
            $photos = $request->file('cover');
            foreach ($photos as $photo) {
                $image = Image::create(['image' => $photo]);
                $news->images()->attach($image);
            }
        }
        return new NewsResource($news);
    }

    /**
     * Display the specified resource.
     *
     * @param News $news
     * @return NewsResource|Response
     */
    public function show(News $news)
    {
        return new NewsResource($news);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param NewsStoreValidate $request
     * @param News $news
     * @return NewsResource
     */
    public function update(NewsStoreValidate $request, News $news)
    {
        $news->update($request->validated());
        $news->save();
        return new NewsResource($news);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param NewsPublishValidate $request
     * @param News $news
     * @return NewsResource
     */
    public function publish(NewsPublishValidate $request, News $news)
    {
        $news->published = $request->validated()['publish'];
        $news->published_by = auth()->user()->getAuthIdentifier();
        $news->published_at = Carbon::now();
        $news->save();

        return new NewsResource($news);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param News $news
     * @return Response
     * @throws Exception
     */
    public function destroy(News $news)
    {
//        $news->published = false;
//        $news->save();
        $news->delete();
        return response()->json($news, 204);
    }
}
