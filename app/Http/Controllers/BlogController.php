<?php

namespace App\Http\Controllers;

use App\Blog;
use App\Image;
use Illuminate\Http\Request;
use App\Http\Requests\NewsStoreValidate;

class BlogController extends Controller
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        $blog = Blog::create($request->all());
        if ($request->hasFile('image')) {
            $photos = $request->file('image');
            foreach ($photos as $photo) {
                $image = Image::create(['image' => $photo]);
                $blog->images()->attach($image);
            }
        }
        return response()->json([
            'status' => "success",
            'code' => 201,
            'data' => $blog
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function show(Blog $blog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit(Blog $blog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Blog $blog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog $blog)
    {
        //
    }
}
