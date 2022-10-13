<?php

use Laravel\Lumen\Application;

class TestCase extends Laravel\Lumen\Testing\TestCase
{

    public function createApplication(): Application
    {
        return require __DIR__.'/../bootstrap/app.php';
    }
}
