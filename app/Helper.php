<?php

namespace App;

use Carbon\Carbon;

class Helper
{
    public static function clamp(Carbon $date): Carbon
    {
        $offset = 5;
        $interval = 15;

        if ($date->minute % $interval === 0) {
            return $date->second(0);
        }

        $date->subMinutes($interval + $offset);
        $date->addMinutes($interval - ($date->minute % $interval));

        print_r('SCENARIO A in CLAMP');

        var_dump($date->format('Y-M-D H:i'));

        return $date->second(0);

        }

}