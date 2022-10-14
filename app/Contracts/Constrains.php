<?php

namespace App\Contracts;

use Carbon\Carbon;

class Constrains implements ConstrainsInterface
{
    protected int $value;

    protected Carbon $start;

    protected Carbon $end;

    public function __construct(Carbon $start, Carbon $end)
    {
        $this->start = $start;

        $this->end = $end;

        $this->value = 0;
    }

    public function weekends():self
    {
        $this->value = 5;
        return $this;
    }

    public function apply(): int
    {
        return $this->value;
    }

}