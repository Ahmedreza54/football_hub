<?php

namespace App\Http\Controllers;

use App\Services\FootballApiService;

class HomeController extends Controller
{
    public function index(FootballApiService $footballApi)
    {
        $apiResponse = $footballApi->get('fixtures', [
            'date' => now('Europe/London')->toDateString(),
            'timezone' => 'Europe/London',
        ]);

        $fixtures = $apiResponse->successful()
            ? $apiResponse->json('response', [])
            : [];

        return view('home', compact('fixtures'));
    }
}