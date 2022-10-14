<?php

namespace App\Contracts;

use App\Helper;
use Carbon\Carbon;
use App\Rates\Result;
use App\Rates\Distance;

class ScenarioC extends Scenario implements ScenarioInterface
{

    public function __construct(Carbon $start, Carbon $end, int $distance)
    {
        parent::__construct($start, $end, $distance);
        $this->start = Helper::clamp($start);
        $this->end = Helper::clamp($end);
    }

    public function getPrice(): Result
    {
        $price = $this->constrains
            ->weekends()
            ->apply();

        return new Result($price, new Distance($this));
    }

    public function priceForDistance(): int
    {
        if($this->distance > 100){

            return  100 + (($this->distance - 100) * 20);

        }else return $this->distance;


    }

}