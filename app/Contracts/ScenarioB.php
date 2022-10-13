<?php

namespace App\Contracts;

use App\Helper;
use App\Rates\Result;
use App\Rates\Distance;

class ScenarioB extends Scenario implements ScenarioInterface
{
    public function getPrice(): Result
    {
        $start = Helper::clamp($this->start);
        $end = Helper::clamp($this->end);

        $this->price = 0;

        $hours = $end->diffInHours($start);

        $full_days = floor($hours / 24);

        $rest = $hours % 24;

        $rest = min(($rest * 1500), 8500);

        $this->price += (8500 * $full_days) + $rest;

        if($this->distance > 50){
            $this->distancePrice = ($this->distance - 50) * 50;
        }

        return new Result($this->price, new Distance($this->distance));
    }

}