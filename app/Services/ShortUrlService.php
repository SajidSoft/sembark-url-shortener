<?php

namespace App\Services;

use App\Models\ShortUrl;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ShortUrlService
{
    public function generate($longUrl)
    {
        do {
            $shortCode = Str::random(6);
        } while (ShortUrl::where('short_code', $shortCode)->exists());

        return ShortUrl::create([
            'url' => $longUrl,
            'short_code' => $shortCode,
            'user_id' => Auth::id(),
            'company_id' => Auth::user()->company_id,
        ]);
    }

    public function getUrlAndIncrementHits($shortCode)
    {
        $shortUrl = ShortUrl::where('short_code', $shortCode)->firstOrFail();

        $shortUrl->increment('hits');

        return $shortUrl->url;
    }
}
