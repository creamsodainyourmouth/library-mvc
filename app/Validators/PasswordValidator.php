<?php

namespace app\Validators;

use core\Src\Validators\AbstractValidator;

class PasswordValidator extends AbstractValidator
{
    public function rule(): bool
    {
        $pw_len = strlen($this->value);
        return $pw_len >= 6 && $pw_len <= 32;
    }
}