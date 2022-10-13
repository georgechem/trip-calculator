<?php

namespace App\Contracts;

use Carbon\Carbon;

abstract class Scenario
{
    protected Carbon $start;

    protected Carbon $end;

    protected int $distance;

    public function __construct(Carbon $start, Carbon $end, int $distance)
    {
        $this->start = $start;
        $this->end = $end;
        $this->distance = $distance;
    }

    public function modify(Array $modifiers = []):void
    {

    }

}