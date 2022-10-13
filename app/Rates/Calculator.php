<?php

namespace App\Rates;

use App\Contracts\Calculator as CalculatorContract;
use App\Contracts\PriceInterface;
use App\Contracts\Result as ResultContract;
use App\Contracts\ScenarioInterface;
use App\Helper;
use Carbon\Carbon;

class Calculator implements CalculatorContract
{
    protected ScenarioInterface $scenario;

    public function __construct(ScenarioInterface $scenario)
    {
        $this->scenario = $scenario;
    }

    public function calculate(): ResultContract
    {
        return $this->scenario->getPrice();
    }
}
