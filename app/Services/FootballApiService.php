<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;
use RuntimeException;

class FootballApiService
{
    protected string $baseUrl;
    protected string $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('services.football.base_url');
        $this->apiKey = config('services.football.key');

        if (empty($this->baseUrl) || empty($this->apiKey)) {
            throw new RuntimeException(
                'Football API configuration is missing.'
            );
        }
    }

    public function get(string $endpoint, array $parameters = []): Response
    {
        return Http::withHeaders([
            'x-apisports-key' => $this->apiKey,
        ])
        ->timeout(15)
        ->get(rtrim($this->baseUrl, '/') . '/' . ltrim($endpoint, '/'), $parameters);
    }
}
