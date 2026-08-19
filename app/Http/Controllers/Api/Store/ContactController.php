<?php

namespace App\Http\Controllers\Api\Store;

use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Requests\Api\Store\ContactRequest;
use App\Http\Resources\Store\BranchResource;
use App\Jobs\SendConversionEventJob;
use App\Services\Api\Store\ContactApiService;
use App\Services\Cache\ContactCacheService;

final class ContactController extends ApiBaseController
{
    public function __construct(
        private readonly ContactApiService $contactService,
        private readonly ContactCacheService $contactCache,
    ) {
        parent::__construct(app(\App\Http\Api\Response\Builder\ApiResponseBuilder::class));
    }

    /**
     * Return contact page metadata (hero, branches).
     */
    public function meta()
    {
        return $this->respondSuccess([
            'hero' => $this->contactCache->rememberContactHero(),
            'branches' => BranchResource::collection($this->contactCache->rememberBranches())->resolve(),
        ], 'Contact page metadata retrieved successfully');
    }

    public function store(ContactRequest $request)
    {
        $lead = $this->contactService->submitContactForm($request->validated());

        SendConversionEventJob::dispatch([
            'event_name' => 'Lead',
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'content_name' => $request->input('subject', 'Contact Inquiry'),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return $this->respondCreated(
            ['lead_id' => $lead->id],
            'Message submitted successfully'
        );
    }
}
