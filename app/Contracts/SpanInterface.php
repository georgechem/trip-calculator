<?php

namespace App\Contracts;

use Carbon\Carbon;

interface SpanInterface
{
    public function capped(int $capped): Int;

    public function add(Carbon $span, int $value):void;

}