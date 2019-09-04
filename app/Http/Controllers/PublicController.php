<?php

namespace App\Http\Controllers;

use App\Carousel;
use App\Http\Resources\PublicCarousel;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function carousel()
    {
        $carousel = Carousel::whereActive(true)->latest()->get();
        return PublicCarousel::collection($carousel);
    }
}
