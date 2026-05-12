<?php

namespace App\Http\Controllers;

use Illuminate\Http\Client\Pool;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function index()
    {
        // Parallel API calls — mirrors the Next.js Promise.all pattern
        $responses = Http::pool(fn (Pool $pool) => [
            $pool->as('home')->withoutVerifying()->get('https://api.quickdials.com/api/website/homePage'),
            $pool->as('repairs')->withoutVerifying()->get('https://api.quickdials.com/api/website/repairsServices'),
            $pool->as('wedding')->withoutVerifying()->get('https://api.quickdials.com/api/website/weddingPlanning'),
        ]);

        $homeData    = $responses['home']->json()    ?? [];

      
        $repairsData = $responses['repairs']->json() ?? [];
        $weddingData = $responses['wedding']->json() ?? [];
 



        return view('client.home', compact('homeData', 'repairsData', 'weddingData'));
    }
}
