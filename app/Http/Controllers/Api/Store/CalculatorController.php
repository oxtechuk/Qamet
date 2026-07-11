<?php

namespace App\Http\Controllers\Api\Store;

use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Requests\Api\Store\CalculatorCalculateRequest;
use App\Http\Requests\Api\Store\CalculatorLeadRequest;
use App\Http\Requests\Api\Store\CalculatorOtpSendRequest;
use App\Http\Requests\Api\Store\CalculatorOtpVerifyRequest;
use App\Http\Resources\Store\CalculatorBankResource;
use App\Models\CalculatorBank;
use App\Services\Api\Store\CalculatorApiService;

final class CalculatorController extends ApiBaseController
{
    public function __construct(
        private readonly CalculatorApiService $calculatorService,
    ) {
        parent::__construct(app(\App\Http\Api\Response\Builder\ApiResponseBuilder::class));
    }

    public function banks()
    {
        $banks = $this->calculatorService->banks();

        return $this->respondSuccess(
            CalculatorBankResource::collection($banks),
        );
    }

    public function calculate(CalculatorCalculateRequest $request)
    {
        $result = $this->calculatorService->calculate(
            carId: (int) $request->input('car_id'),
            downPaymentPct: (float) $request->input('down_payment_percentage',10),
            periodMonths: (int) $request->input('period_months',12),
            bankId: (int) $request->input('bank_id',CalculatorBank::query()->first()->id),
        );

        return $this->respondSuccess($result);
    }

    public function saveLead(CalculatorLeadRequest $request)
    {
        $lead = $this->calculatorService->saveLead($request->validated());

        return $this->respondCreated(
            ['lead_id' => $lead->id],
            'Lead saved successfully'
        );
    }

    public function sendOtp(CalculatorOtpSendRequest $request)
    {
        $result = $this->calculatorService->sendOtp(
            $request->input('phone')
        );

        if (! $result['success']) {
            return $this->respondError($result['message'], 422);
        }

        return $this->respondSuccess(null, $result['message']);
    }

    public function verifyOtp(CalculatorOtpVerifyRequest $request)
    {
        $verified = $this->calculatorService->verifyOtp(
            $request->input('phone'),
            $request->input('code')
        );

        if (! $verified) {
            return $this->respondError('Invalid or expired code', 422);
        }

        $lead = $this->calculatorService->createLeadFromVerified(
            $request->input('name'),
            $request->input('phone')
        );

        return $this->respondCreated(
            ['lead_id' => $lead->id],
            'OTP verified successfully'
        );
    }
}
