<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShortUrlRequest;
use App\Services\ShortUrlService;
use Illuminate\Http\Request;

class ShortUrlController extends Controller
{
    public function __construct(protected ShortUrlService $shortUrlService) {}

    public function generateURL(Request $request)
    {

        if ($request->isMethod('get')) {
            return view('urls-generate');
        }

        $data = app(ShortUrlRequest::class)->validated();

        try {
            $this->shortUrlService->generate($data['long_url']);

            return redirect()
                ->route('dashboard')
                ->with('success', 'URL generated successfully.');
        } catch (\Throwable $e) {

            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    public function resolve($shortCode)
    {
        $longUrl = $this->shortUrlService->getUrlAndIncrementHits($shortCode);

        return redirect()->away($longUrl);
    }
}
