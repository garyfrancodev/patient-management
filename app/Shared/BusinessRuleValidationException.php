<?php

namespace App\Shared;

use Exception;
use Illuminate\Http\JsonResponse;

class BusinessRuleValidationException extends Exception
{
    protected BusinessRule $brokenRule;

    public function __construct(BusinessRule $brokenRule)
    {
        parent::__construct($brokenRule->getMessage());
        $this->message = $brokenRule->getMessage();
        $this->brokenRule = $brokenRule;
    }

    public function getBrokenRule(): BusinessRule
    {
        return $this->brokenRule;
    }

    public function getMessageResponse(): JsonResponse
    {
        return response()->json([
            'message' => $this->getMessage(),
        ], 400);
    }
}
