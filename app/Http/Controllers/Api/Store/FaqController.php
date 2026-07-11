<?php

namespace App\Http\Controllers\Api\Store;

use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Resources\Store\FaqResource;
use App\Models\Faq;

final class FaqController extends ApiBaseController
{
    public function __construct()
    {
        parent::__construct(app(\App\Http\Api\Response\Builder\ApiResponseBuilder::class));
    }

    public function __invoke()
    {
        $faqs = Faq::where('is_visible', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return $this->respondSuccess(FaqResource::collection($faqs));
    }
}
