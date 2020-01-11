<?php

namespace App\Http\Controllers\API;

use App\FeaturedAlumni;
use App\Http\Requests\FeaturedAlumniUpdateValidate;
use App\Http\Requests\FeaturedAlumniValidate;
use App\Http\Resources\FeaturedAlumni as FeaturedAlumniResource;
use App\Http\Resources\FeaturedAlumniSearch;
use App\User;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response as ResponseAlias;

class FeaturedAlumniController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse|AnonymousResourceCollection
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
        if ($request->get('alumni')) {
            $data = User::find($request->validated()['alumni']);
            $alumni = FeaturedAlumni::create($request->validated());
            $alumni->alumni()->associate($data);
            $alumni->save();
        } else {
            $alumni = FeaturedAlumni::create($request->validated());
        }

        return new FeaturedAlumniResource($alumni);
    }

    /**
     * Display the specified resource.
     *
     * @param $search
     * @return FeaturedAlumni|AnonymousResourceCollection|ResponseAlias
     */
    public function show($search)
    {
        $user = User::isAlumni()->where(function (Builder $query) use ($search) {
            $query->where('name', 'LIKE', "%$search%")
                ->orWhere('email', 'LIKE', "%$search%")
                ->orWhere('mobile', 'LIKE', "%$search%");
        })->get();
        return FeaturedAlumniSearch::collection($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param FeaturedAlumniUpdateValidate $request
     * @param FeaturedAlumni $featured_alumnus
     * @return FeaturedAlumniResource
     */
    public function update(FeaturedAlumniUpdateValidate $request, FeaturedAlumni $featured_alumnus)
    {
        $featured_alumnus->update($request->validated());
        return new FeaturedAlumniResource($featured_alumnus);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param FeaturedAlumni $featured_alumnus
     * @return FeaturedAlumniResource|ResponseAlias
     * @throws Exception
     */
    public function destroy(FeaturedAlumni $featured_alumnus)
    {
        $featured_alumnus->delete();
        return new FeaturedAlumniResource($featured_alumnus);
    }
}
