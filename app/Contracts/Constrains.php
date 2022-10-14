<?php

namespace App\Contracts;

use Carbon\Carbon;
use Carbon\CarbonInterval;

class Constrains implements ConstrainsInterface
{
    protected int $value;

    protected Carbon $start;

    protected Carbon $end;

    public function __construct(Carbon $start, Carbon $end)
    {
        $this->start = $start;

        $this->end = $end;

        $this->value = 0;
    }

    public function weekends():self
    {
        $span = $this->end->diffAsCarbonInterval($this->start);
        $weekendHours = 0;
        $hoursTotal = $span->days * 24 + $span->hours;
        for($i = 0; $i <= $hoursTotal; $i++){
            $interval = CarbonInterval::hours(1);
            if(
                $this->start->add($interval)->isSaturday() ||
                $this->start->add($interval)->isSunday()
            ){
                // Limitation (we're charging customer only for full weekend hours)
                if(!$this->start->add(CarbonInterval::hours($i + 1))->isMonday()){
                    $weekendHours++;
                }
            }
        }
        // var_dump("is weekend hour", $weekendHours);
        // var_dump($this->start->format('Y-M-D H:i'));

        $this->value += $weekendHours * 200;

        return $this;
    }

    public function weekDaysBetween(): self
    {
        $span = $this->end->diffAsCarbonInterval($this->start);
        $weekDaysBetweenHours = 0;
        $hoursTotal = $span->days * 24 + $span->hours;

        for($i = 0; $i <= $hoursTotal; $i++){
            $interval = CarbonInterval::hours(1);
            if(
                $this->start->add($interval)->isMonday() ||
                $this->start->add($interval)->isTuesday() ||
                $this->start->add($interval)->isWednesday() ||
                $this->start->add($interval)->isThursday() ||
                $this->start->add($interval)->isFriday()
            ){
                var_dump($this->start->format('Y-M-D H:i'));
                // Limitation (we're charging customer only for full weekday between hours )
                if(!$this->start->add(CarbonInterval::hours($i + 1))->isSaturday()){
                    $weekDaysBetweenHours++;
                }
            }
        }
        var_dump("is week between hour", $weekDaysBetweenHours);
        // var_dump($this->start->format('Y-M-D H:i'));

        $this->value += $weekDaysBetweenHours * 665;

        return $this;

    }

    public function apply(): int
    {
        return $this->value;
    }

}