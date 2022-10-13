<?php

namespace App\Contracts;

use Carbon\Carbon;

abstract class Scenario
{
    protected Carbon $start;

    protected Carbon $end;

    protected int $distance;

    protected int $distancePrice;

    protected int $price;

    public function __construct(Carbon $start, Carbon $end, int $distance)
    {
        $this->start = $start;
        $this->end = $end;
        $this->distance = $distance;
        $this->distancePrice = 0;
    }

    public function getDistancePrice(): int
    {
        return $this->distancePrice;
    }

    public function setDistancePrice(int $price): void
    {
        $this->setDistancePrice = $price;
    }


}