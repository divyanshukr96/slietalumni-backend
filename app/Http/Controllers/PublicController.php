<?php

namespace App\Http\Controllers;

use App\Carousel;
use App\Donation;
use App\Event;
use App\FeaturedAlumni;
use App\Http\Resources\Member as MemberResource;
use App\Http\Resources\PublicCarousel;
use App\Http\Resources\PublicDonation;
use App\Http\Resources\PublicEvent;
use App\Http\Resources\PublicFeaturedAlumni;
use App\Http\Resources\PublicNewsAndStories;
use App\Member;
use App\News;
use App\PublicNotice;
use App\Traits\MemberTypes;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Carbon;

class PublicController extends Controller
{
    use MemberTypes;

    /**
     * @return AnonymousResourceCollection
     */
    public function carousel()
    {
        $carousel = Carousel::whereActive(true)->latest()->get();
        return PublicCarousel::collection($carousel);
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function events()
    {
        return PublicEvent::collection(Event::wherePublished(true)->latest()->get());
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function featuredAlumni()
    {
        $featured = FeaturedAlumni::whereDate('featured', '>=', Carbon::today()->toDateString());
        return PublicFeaturedAlumni::collection($featured->latest()->get());
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function newsAndStories()
    {
        $newsStories = News::wherePublished(true)->latest()->get();
        return PublicNewsAndStories::collection($newsStories);
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function members()
    {
        $orderBy = self::$memberOrderBy;
        $members = Member::orderByRaw("FIELD(designation , $orderBy)")->get();
        return MemberResource::collection($members);
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function donation()
    {
        $donations = Donation::whereVerified(true)->latest()->get();
        return PublicDonation::collection($donations);
    }

    /**
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function notice()
    {
        $donations = PublicNotice::whereDate('notice_till', '>=', Carbon::today()->toDateString());
        return response()->json([
            'data' => $donations->latest()->get()
        ]);
    }
}
