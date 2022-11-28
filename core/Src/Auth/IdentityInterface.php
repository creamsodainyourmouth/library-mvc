<?php

namespace core\Src\Auth;

interface IdentityInterface
{
    public function find_identity(int $id);
    public function get_id(): int;
    public function attempt_identity(array $credentials);
}