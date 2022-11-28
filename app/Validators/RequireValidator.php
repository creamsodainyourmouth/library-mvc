<?php

namespace app\Validators;

use core\Src\Validators\AbstractValidator;

class RequireValidator extends AbstractValidator
{
    protected string $message = 'Field :field is required';
    public function rule(): bool
    {
        return !empty($this->value);
    }
}