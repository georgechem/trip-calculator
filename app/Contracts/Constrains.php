<?php

namespace App\Contracts;

use Carbon\Carbon;
use Carbon\CarbonInterval;

class Constrains implements ConstrainsInterface
{
    protected int $value;

    protected Carbon $start;

    protected Carbon $end;

    protected array $days;

    public function __construct(Carbon $start, Carbon $end)
    {
        $this->start = $start;

        $this->end = $end;

        $this->value = 0;

        $this->days = [];

        $this->prepare();

    }

    public function addDay(Days $day)
    {
        $alreadyIn = false;
        foreach ($this->days as $d){
            if($d->getDay()->isSameDay($day->getDay())) $alreadyIn = true;
        }
        if(!$alreadyIn) $this->days[] = $day;
    }

    public function getDay(Carbon $carbon)
    {
        $day = null;
        foreach ($this->days as $d){
            if($d->getDay()->isSameDay($carbon)) $day = $d;
        }
        return $day ?? new Days($carbon);
    }

    // prepare list of days with table of hours
    private function prepare()
    {
        $span_in_days = (new Carbon($this->end))->diffInDays(new Carbon($this->start));

        $start = new Carbon($this->start);

        for($d = 0; $d <= $span_in_days; $d++){
            $day = $this->getDay((new Carbon($start))->add($d, 'days'));
            $this->days[] = $day;
        }
        foreach ($this->days as $day){
            for($h = 0; $h < 24; $h++){
                if($day->getDay()->greaterThanOrEqualTo($this->start) && $day->getDay()->lessThanOrEqualTo($this->end)){
                    if($day->getDay()->isSameDay($this->start) && $h < $this->start->hour) continue;
                    if($day->getDay()->isSameDay($this->end) && $h >= $this->end->hour) continue;
                    //var_dump(" --------------------------------------------------");
                    // var_dump($day->getDay()->format('Y-M-d H:i'));
                    //var_dump($h, $this->start->hour, $this->end->hour);
                    $day->initHour($h);
                    //var_dump(" --------------------------------------------------");
                }
            }
        }
    }

    public function weekends():self
    {

        foreach ($this->days as $day){
            if($day->getDay()->isSaturday() || $day->getDay()->isSunday()){
                if(!((new Carbon($day->getDay()))->add(1, 'hours')->isMonday())){
                    foreach ($day->getHours() as $hour => $price){
                        // var_dump($hour, $day->getHours());
                        // var_dump($day->getDay()->format('Y-M-d H:i'));
                        $day->addToHour($hour, 200);
                    }
                }
            }
        }
//        foreach ($this->days as $day){
//            var_dump($day->getHours());
//        }
        return $this;
    }

    public function weekDaysBetween():self
    {

        foreach($this->days as $day){
            var_dump($day->getDay()->format('Y-M-D H:i'));
            if(!$day->getDay()->isSaturday() && !$day->getDay()->isSunday()){
                if(!((new Carbon($day->getDay()))->add(1, 'hours')->isSaturday())){
                    foreach ($day->getHours() as $hour => $price){
                        if($hour >= 7 && $hour < 19) $day->addToHour($hour, 665);
                    }
                }
            }
        }
        return $this;
    }

    public function weekDaysOutside():self
    {
        foreach($this->days as $day){
            // var_dump($day->getDay()->format('Y-M-D H:i'));
            if(!$day->getDay()->isSaturday() && !$day->getDay()->isSunday()){
                if(!((new Carbon($day->getDay()))->add(1, 'hours')->isSaturday())){
                    foreach ($day->getHours() as $hour => $price){
                        if($hour < 7 || $hour >= 19) $day->addToHour($hour, 400);
                    }
                }
            }
        }
        return $this;
    }

    public function nineToSixPromo():self
    {
//        foreach ($this->days as $day){
//            var_dump($day->getHours());
//        }
        $sum = 0;
        $index = 0;
        foreach ($this->days as $day){
            $sum = 0;
            foreach ($day->getHours() as $hour => $price){
                if(!$day->getDay()->isSaturday() && !$day->getDay()->isSunday()){
                    if($hour >= 21) $sum += $price;
                }
            }
            if($sum >= 1200){
                // zero hourly prices for next day 0 - 6 as max 1200 achieved
                if(array_key_exists($index + 1, $this->days)){
                    for($h = 0;$h < 6; $h++){
                        $this->days[$index + 1]->setHour($h, 0);
                    }
                }
            }
            $index++;
        }
        return $this;
    }


    public function apply(): int
    {
        foreach ($this->days as $day){
            $day->sum();
            $this->value += $day->getValue();
        }
        return $this->value;
    }

}