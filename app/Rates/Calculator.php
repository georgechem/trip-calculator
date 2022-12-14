<?php

namespace App\Rates;

use App\Contracts\Calculator as CalculatorContract;
use App\Contracts\Result as ResultContract;
use App\Contracts\ScenarioInterface;

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
