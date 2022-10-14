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
            $currentDate = new Carbon($this->start);
            $interval = CarbonInterval::hours($i);
            if(
                $currentDate->add($interval)->isSaturday() ||
                $currentDate->add($interval)->isSunday()
            ){
                // Limitation (we're charging customer only for full weekend hours)
                if(!$currentDate->add(CarbonInterval::hours($i + 1))->isMonday()){
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
        $hours = [];
        $dayKeys = ['mon', 'tue', 'wed', 'thu', 'fri'];
        foreach ($dayKeys as $day){
            $hours[$day] = ['hours' => 0, 'price' => 0];
        }

        // Limitation: only charging for full hours
        for($i = 1; $i <= $hoursTotal; $i++){
            $currentDate = new Carbon($this->start);
            $currentDate->add($i, 'hours');
            // var_dump($currentDate->format('Y-M-D H:i'));
            if($currentDate->isMonday()){
                $stillCurrentDay = (new Carbon($currentDate))->add(1, 'hours');
                if($stillCurrentDay->isMonday()){
                    if($currentDate->hour >= 7 && $currentDate->hour <= 19) $hours['mon']['hours'] += 1;
                }
            }
            if($currentDate->isTuesday()){
                $stillCurrentDay = (new Carbon($currentDate))->add(1, 'hours');
                if($stillCurrentDay->isTuesday()){
                    if($currentDate->hour >= 7 && $currentDate->hour <= 19) $hours['tue']['hours'] += 1;
                }
            }
            if($currentDate->isWednesday()){
                $stillCurrentDay = (new Carbon($currentDate))->add(1, 'hours');
                if($stillCurrentDay->isWednesday()){
                    if($currentDate->hour >= 7 && $currentDate->hour <= 19) $hours['wed']['hours'] += 1;
                }
            }
            if($currentDate->isThursday()){
                $stillCurrentDay = (new Carbon($currentDate))->add(1, 'hours');
                if($stillCurrentDay->isThursday()){
                    if($currentDate->hour >= 7 && $currentDate->hour <= 19) $hours['thu']['hours'] += 1;
                }
            }
            if($currentDate->isFriday()){
                $stillCurrentDay = (new Carbon($currentDate))->add(1, 'hours');
                if($stillCurrentDay->isFriday()){
                    if($currentDate->hour >= 7 && $currentDate->hour <= 19) $hours['fri']['hours'] += 1;
                }
            }
        }

        foreach ($dayKeys as $day){
            $hours[$day]['price'] += $hours[$day]['hours'] * 665;
            // price is capped
            if( $hours[$day]['price'] > 3900) $hours[$day]['price'] = 3900;
        }
        foreach ($dayKeys as $day){
            $this->value += $hours[$day]['price'];
        }

        return $this;

    }

    public function apply(): int
    {
        return $this->value;
    }

}