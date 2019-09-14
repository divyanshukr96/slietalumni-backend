<?php

namespace App\Http\Controllers;

use App\Carousel;
use App\Event;
use App\FeaturedAlumni;
use App\Http\Resources\PublicCarousel;
use App\Http\Resources\PublicEvent;
use App\Http\Resources\PublicFeaturedAlumni;
use App\Http\Resources\PublicNewsAndStories;
use App\News;
use Illuminate\Support\Carbon;

class PublicController extends Controller
{
    public function carousel()
    {
        $carousel = Carousel::whereActive(true)->latest()->get();
        return PublicCarousel::collection($carousel);
    }

    public function events()
    {
        return PublicEvent::collection(Event::wherePublished(true)->latest()->get());
    }

    public function featuredAlumni()
    {
        $featured = FeaturedAlumni::whereDate('featured', '>=', Carbon::today()->toDateString());
        return PublicFeaturedAlumni::collection($featured->latest()->get());
    }

    public function newsAndStories()
    {
        $newsStories = News::wherePublished(true)->latest()->get();
        return PublicNewsAndStories::collection($newsStories);
    }
}
