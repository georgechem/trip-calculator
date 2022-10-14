<?php

namespace App\Contracts;

use App\Helper;
use Carbon\Carbon;
use App\Rates\Result;
use App\Rates\Distance;

class ScenarioA extends Scenario implements ScenarioInterface
{

    public function getPrice(): Result
    {
        $start = Helper::clamp($this->start);

        $end = Helper::clamp($this->end);

        $minutes = $end->diffInMinutes($start);

        return new Result(floor($minutes/60 * 400), new Distance($this));

    }
}