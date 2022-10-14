<?php

namespace App\Contracts;

use Carbon\Carbon;

abstract class Scenario
{
    protected Carbon $start;

    protected Carbon $end;

    protected ConstrainsInterface $constrains;

    protected int $distance;

    protected int $price;

    public function __construct(Carbon $start, Carbon $end, int $distance)
    {
        $this->start = $start;
        $this->end = $end;
        $this->distance = $distance;
        $this->price = 0;

    }

    public function setConstrains(ConstrainsInterface $constrains): void
    {
        $this->constrains = $constrains;
    }

    public function priceForDistance():Int
    {
        return 0;
    }




}