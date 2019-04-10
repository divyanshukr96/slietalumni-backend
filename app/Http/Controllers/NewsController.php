<?php

namespace App\Http\Controllers;

use App\Image;
use App\News;
use Illuminate\Http\Request;
use App\Http\Requests\NewsStoreValidate;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param NewsStoreValidate $request
     * @return \Illuminate\Http\Response
     */
    public function store(NewsStoreValidate $request)
    {
        $news = News::create($request->all());
        if ($request->hasFile('image')) {
            $photos = $request->file('image');
            foreach ($photos as $photo) {
                $image = Image::create(['image' => $photo]);
                $news->images()->attach($image);
            }
        }
        return response()->json([
            'status' => "success",
            'code' => 201,
            'data' => $news
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\News $news
     * @return \Illuminate\Http\Response
     */
    public function show(News $news)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\News $news
     * @return \Illuminate\Http\Response
     */
    public function edit(News $news)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\News $news
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, News $news)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\News $news
     * @return \Illuminate\Http\Response
     */
    public function destroy(News $news)
    {
        //
    }
}
