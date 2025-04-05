<?php

namespace App\Shared;

abstract class ValueObject
{
    public function checkRule(BusinessRuleValidationException $businessRuleValidationException): void
    {
        $rule = $businessRuleValidationException->getBrokenRule();

        if (! $rule->isValid()) {
            throw $businessRuleValidationException;
        }
    }
}
