<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\PortfolioPayloadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\Response;

class PortfolioController extends Controller
{
    public function __invoke(Request $request, PortfolioPayloadService $service): Response
    {
        $payload = $service->getCachedPayload($request);
        $json = (string) json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $etag = '"'.sha1($json).'"';

        $updatedAtStr = isset($payload['updatedAt']) && is_string($payload['updatedAt'])
            ? $payload['updatedAt']
            : Carbon::now()->utc()->toIso8601String();

        $lastModified = Carbon::parse($updatedAtStr)->utc();

        $response = new JsonResponse($payload, 200, [], 0);
        $response->setEtag(trim($etag, '"'));
        $response->setLastModified($lastModified);
        $response->setPublic();

        if ($response->isNotModified($request)) {
            return $response;
        }

        return $response;
    }
}
