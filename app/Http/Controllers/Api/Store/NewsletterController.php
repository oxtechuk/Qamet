<?php

namespace App\Http\Controllers\Api\Store;

use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Requests\Api\Store\NewsletterSubscribeRequest;
use App\Services\Api\Store\NewsletterApiService;

final class NewsletterController extends ApiBaseController
{
    public function __construct(
        private readonly NewsletterApiService $newsletterService,
    ) {
        parent::__construct(app(\App\Http\Api\Response\Builder\ApiResponseBuilder::class));
    }

    public function store(NewsletterSubscribeRequest $request)
    {
        $result = $this->newsletterService->subscribe(
            $request->input('email'),
            $request->ip()
        );

        if ($result->isError()) {
            return response()->json([
                'success' => false,
                'message' => $result->message,
                'data' => null,
                'errors' => null,
                'meta' => null,
            ], $result->statusCode);
        }

        return $this->respondSuccess(null, $result->message);
    }
}
