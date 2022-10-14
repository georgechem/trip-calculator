<?php

namespace App\Rates;

use App\Contracts\Distance as DistanceContract;
use App\Contracts\Scenario;

class Distance implements DistanceContract
{
    protected Scenario $scenario;

    public function __construct(Scenario $scenario)
    {
        $this->scenario = $scenario;
    }

    public function value(): int
    {
        return $this->scenario->priceForDistance();
    }


}
