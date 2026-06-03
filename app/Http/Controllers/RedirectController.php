<?php

namespace App\Http\Controllers;

use App\Application\ShortUrl\Commands\RecordClickHandler;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RedirectController extends Controller
{
    public function __invoke(
        string $shortCode,
        Request $request,
        RecordClickHandler $handler,
    ): RedirectResponse {
        $originalUrl = $handler->handle(
            shortCode: $shortCode,
            ip: $request->ip() ?? '0.0.0.0',
            userAgent: $request->userAgent(),
            referer: $request->headers->get('referer'),
        );

        return redirect()->away($originalUrl, 302);
    }
}
