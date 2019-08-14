<?php

namespace App\Http\Controllers\API;

use App\Alumni;
use App\FeaturedAlumni;
use App\Http\Requests\FeaturedAlumniValidate;
use App\Http\Resources\FeaturedAlumni as FeaturedAlumniResource;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response as ResponseAlias;

class FeaturedAlumniController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        if (count(request()->all()) > 0) return response()->json();
        return FeaturedAlumniResource::collection(FeaturedAlumni::latest()->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param FeaturedAlumniValidate $request
     * @return FeaturedAlumniResource
     */
    public function store(FeaturedAlumniValidate $request)
    {
        if ($request->has('alumni')) {
            $data = User::find($request->validated()['alumni']);
            $alumni = FeaturedAlumni::create($request->validated());
            $alumni->alumni()->associate($data);
            $alumni->save();
        } else {
            $alumni = FeaturedAlumni::create($request->validated());
        }

        return new  FeaturedAlumniResource($alumni);
    }

    /**
     * Display the specified resource.
     *
     * @param $search
     * @return ResponseAlias
     */
    public function show($search)
    {
        dd(User::isAlumni()->get());
        return User::isAlumni()->where(function (Builder $query) use ($search) {
            $query->where('name', 'LIKE', "%$search%")
                ->orWhere('email', 'LIKE', "%$search%")
                ->orWhere('mobile', 'LIKE', "%$search%");
        })->get();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param FeaturedAlumni $featuredAlumni
     * @return ResponseAlias
     */
    public function update(Request $request, FeaturedAlumni $featuredAlumni)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param FeaturedAlumni $featuredAlumni
     * @return ResponseAlias
     */
    public function destroy(FeaturedAlumni $featuredAlumni)
    {
        //
    }
}
