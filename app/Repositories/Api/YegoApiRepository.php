<?php

namespace App\Repositories\Api;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

abstract class YegoApiRepository
{
    protected PendingRequest $client;

    public function __construct()
    {
        $this->client = Http::baseUrl(
            config('yego.api_url')
        )->withToken(
            config('yego.api_token')
        );
    }
}