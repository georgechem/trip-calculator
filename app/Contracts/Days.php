<?php

namespace App\Contracts;

use Carbon\Carbon;
use function PHPUnit\Framework\throwException;

class Days implements SpanInterface
{
    protected Carbon $day;

    protected array $hours;

    protected int $value;

    protected int $promo = 0;

    public function __construct(Carbon $day)
    {
        $this->day = $day;
        $this->value = 0;
        $this->hours = [];
    }

    public function getDay(): Carbon
    {
        return $this->day;
    }

    public function initHour(int $hour){
        $this->hours[$hour] = 0;
    }

    public function addToHour(int $hour, int $value)
    {
        if(array_key_exists($hour, $this->hours)){
            $this->hours[$hour] += $value;
        }
    }

    public function setHour(int $hour, int $value){
        if(array_key_exists($hour, $this->hours)){
            $this->hours[$hour] = $value;
        }
    }

    public function getHours(): array
    {
        return $this->hours;
    }

    public function sum()
    {
        $this->value = 0;
        foreach ($this->getHours() as $price){
            $this->value += $price;
            if($this->value > 3900) $this->value = 3900;
        }
    }

    public function capped(int $capped): int
    {
        if($this->value > $capped) return $capped;
        else return $this->value;
    }

    public function getValue(): int
    {
        return $this->value - $this->promo;
    }
}