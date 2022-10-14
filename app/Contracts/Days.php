<?php

namespace App\Contracts;

use Carbon\Carbon;
use function PHPUnit\Framework\throwException;

class Days implements SpanInterface
{
    protected Carbon $day;

    protected int $value;

    public function __construct(Carbon $day)
    {
        $this->day = $day;

        $this->value = 0;
    }

    public function capped(int $capped): int
    {
        if($this->value > $capped) return $capped;
        else return $this->value;
    }


    public function add(Carbon $span, int $value): void
    {
        if($span->isSameDay($this->day)) $this->value += $value;
        else{
            try{
                throw new \Exception("Adding not allowed");
            }catch(\Exception $e){
                echo $e->getMessage();
            }

        }
    }
}