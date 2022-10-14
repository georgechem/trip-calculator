<?php

namespace App\Contracts;

interface ConstrainsInterface
{
    public function apply(): int;
}