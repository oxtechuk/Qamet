<?php

namespace App\Http\Controllers\Api\Store;

use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Requests\Api\Store\ContactRequest;
use App\Services\Api\Store\ContactApiService;

final class ContactController extends ApiBaseController
{
    public function __construct(
        private readonly ContactApiService $contactService,
    ) {
        parent::__construct(app(\App\Http\Api\Response\Builder\ApiResponseBuilder::class));
    }

    public function store(ContactRequest $request)
    {
        $lead = $this->contactService->submitContactForm($request->validated());

        return $this->respondCreated(
            ['lead_id' => $lead->id],
            'Message submitted successfully'
        );
    }
}
