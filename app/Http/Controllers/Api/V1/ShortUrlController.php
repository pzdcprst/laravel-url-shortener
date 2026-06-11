<?php

namespace App\Http\Controllers\Api\V1;

use App\Application\ShortUrl\Commands\CreateShortUrlHandler;
use App\Application\ShortUrl\Queries\GetShortUrlStatsHandler;
use App\Application\ShortUrl\Commands\DeleteShortUrlHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateShortUrlRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ShortUrlController extends Controller
{
    public function store(
        CreateShortUrlRequest $request,
        CreateShortUrlHandler $handler,
    ): JsonResponse {
        $result = $handler->handle(
            url: $request->validated('url'),
            userId: $request->user()->id,
        );

        return response()->json([
            'id' => $result->id,
            'short_url' => $result->shortUrl,
            'original_url' => $result->originalUrl,
        ], 201);
    }

    public function stats(
        string $id,
        Request $request,
        GetShortUrlStatsHandler $handler,
    ): JsonResponse {
        $stats = $handler->handle($id, $request->user()->id);

        return response()->json([
            'clicks' => $stats->clicks,
            'unique_visitors' => $stats->uniqueVisitors,
            'last_click_at' => $stats->lastClickAt,
        ]);
    }

    public function destroy(
        string $id,
        Request $request,
        DeleteShortUrlHandler $handler,
    ): JsonResponse {
        $handler->handle(
            $id,
            $request->user()->id,
        );

        return response()->json([
            'message' => 'Short URL deleted.',
        ]);
    }
}
