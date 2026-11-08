<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FootballApiService
{
    protected string $baseUrl;
    protected string $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('services.football.base_url');
        $this->apiKey = config('services.football.key');
    }

    public function get(string $endpoint, array $parameters = [])
    {
        return Http::withHeaders([
            'x-apisports-key' => $this->apiKey,
        ])
        ->timeout(15)
        ->get($this->baseUrl . '/' . $endpoint, $parameters);
    }
}