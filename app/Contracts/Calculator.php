<?php

namespace App\Contracts;


interface Calculator
{
    public function __construct(ScenarioInterface $scenario);

    public function calculate(): Result;
}
