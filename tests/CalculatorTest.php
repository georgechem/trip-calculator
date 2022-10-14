<?php

use App\Contracts\Days;
use App\Contracts\ScenarioA;
use App\Contracts\ScenarioB;
use App\Contracts\ScenarioC;
use App\Rates\Calculator;
use Carbon\Carbon as c;
use App\Contracts\Constrains;

class CalculatorTest extends TestCase
{
    const SCENARIO_A = 0;
    const SCENARIO_B = 1;
    const SCENARIO_C = 2;

    /**
     * @dataProvider get_scenario_a_values
     *
     * @param \Carbon\Carbon $start
     * @param \Carbon\Carbon $end
     * @param int $value
     */
    public function test_scenario_a_rates_return_correct_results(c $start, c $end, int $value) {

        $scenario = new ScenarioA($start, $end, 0);

        $calculator = new Calculator($scenario);

        $result = $calculator->calculate();

        $this->assertEquals($value, $result->value(), "{$start} to {$end} has a value of {$value}");

        $distance = $result->distance();

        $this->assertEquals(0, $distance->value(), "Distance should be empty for Scenario A");
    }

    public function get_scenario_a_values(): array
    {
        return [
            [new c('2016-02-25 12:00'), new c('2016-02-25 15:00'), 1200 ],
            [new c('2016-02-25 20:00'), new c('2016-02-26 08:00'), 4800 ],
            [new c('2016-02-25 21:00'), new c('2016-02-26 08:00'), 4400 ],
            [new c('2016-02-25 22:00'), new c('2016-02-26 08:00'), 4000 ],
            [new c('2016-02-25 20:00'), new c('2016-02-26 07:00'), 4400 ],
            [new c('2016-02-26 00:00'), new c('2016-02-26 02:00'), 800  ],
            [new c('2016-02-26 00:00'), new c('2016-02-26 03:00'), 1200 ],
            [new c('2016-02-26 00:00'), new c('2016-02-26 04:00'), 1600 ],
            [new c('2016-02-26 21:00'), new c('2016-02-26 22:00'), 400  ],
            [new c('2016-02-26 21:00'), new c('2016-02-26 21:15'), 100  ],
            [new c('2016-02-25 20:00'), new c('2016-02-26 20:00'), 9600 ],
            [new c('2016-02-25 20:00'), new c('2016-02-26 22:00'), 10400],
            [new c('2016-02-25 20:00'), new c('2016-02-27 08:00'), 14400],
            [new c('2016-02-25 19:00'), new c('2016-02-27 08:00'), 14800],
        ];
    }

    /**
     * @dataProvider get_scenario_b_values
     *
     * @param \Carbon\Carbon $start
     * @param \Carbon\Carbon $end
     * @param int $distance
     * @param int $value
     * @param int $distanceValue
     */
    public function test_scenario_b_rates_return_correct_results(
        c $start, c $end, int $distance,
        int $value, int $distanceValue
    ) {
        $scenarioB = new ScenarioB($start, $end, $distance);

        $calculator = new Calculator($scenarioB);

        $result = $calculator->calculate();

        $this->assertEquals($value, $result->value(), "{$start} to {$end} has a value of {$value}");

        $this->assertEquals($distanceValue, $result->distance()->value(), "{$distance} units of distance should have a value of {$value}");

    }

    public function get_scenario_b_values(): array
    {
        return [
            [new c('2016-11-05 00:00'), new c('2016-11-05 07:00'), 50, 8500, 0],
            [new c('2016-11-05 00:00'), new c('2016-11-05 07:00'), 60, 8500, 500],
            [new c('2016-11-05 00:00'), new c('2016-11-05 08:00'), 60, 8500, 500],
            [new c('2016-11-05 00:00'), new c('2016-11-05 09:00'), 60, 8500, 500],
            [new c('2016-11-05 00:00'), new c('2016-11-05 10:00'), 60, 8500, 500],
            [new c('2016-11-05 00:00'), new c('2016-11-05 15:00'), 60, 8500, 500],
            [new c('2016-11-05 00:00'), new c('2016-11-05 18:00'), 60, 8500, 500],
            [new c('2016-11-04 23:00'), new c('2016-11-05 03:00'), 60, 6000, 500],
            [new c('2016-11-04 20:00'), new c('2016-11-05 07:00'), 60, 8500, 500],
            [new c('2016-11-04 00:00'), new c('2016-11-05 00:00'), 70, 8500, 1000],
            [new c('2016-11-05 09:00'), new c('2016-11-05 11:00'), 20, 3000, 0],
            [new c('2016-11-05 09:00'), new c('2016-11-05 10:00'), 20, 1500, 0],
            [new c('2016-11-03 09:00'), new c('2016-11-06 09:00'), 20, 25500, 0],
            [new c('2016-11-03 09:00'), new c('2016-11-06 10:00'), 20, 27000, 0],
        ];
    }

    /**
     * @dataProvider get_scenario_c_values
     *
     * @param \Carbon\Carbon $start
     * @param \Carbon\Carbon $end
     * @param int $distance
     * @param int $value
     * @param int $distanceValue
     */
    public function test_scenario_c_rates_return_correct_results(
        c $start, c $end, int $distance,
        int $value, int $distanceValue
    ) {
        // TODO: comment out the skip if you're feeling brave.
        //$this->markTestSkipped('Uncomment the skip in Scenario C to attempt it');

        $scenario = new ScenarioC($start, $end, $distance);

        $day = new Days($start);
        $scenario->setConstrains(new Constrains($start, $end, $day));

        //var_dump($scenario->getPrice()->value());

        $calculator = new Calculator($scenario);


        $result = $calculator->calculate();

        $this->assertEquals($value, $result->value(), "{$start} to {$end} has a value of {$value}");
//
//        $this->assertEquals($distanceValue, $result->distance()->value(), "{$distance} units of distance should have a value of {$value}");
    }

    public function get_scenario_c_values(): array
    {
        return [
            [new c('2016-05-12 07:00'), new c('2016-05-12 19:00'), 48, 3900, 48],
            [new c('2016-05-12 06:00'), new c('2016-05-12 22:00'), 200, 3900, 2100],
            [new c('2016-05-12 06:00'), new c('2016-05-12 07:00'), 12, 400, 12],
            [new c('2016-05-14 12:00'), new c('2016-05-14 16:00'), 0, 800, 0],
            [new c('2016-05-12 12:00'), new c('2016-05-14 16:00'), 0, 8600, 0],
            [new c('2016-05-13 20:00'), new c('2016-05-14 06:00'), 0, 1600, 0],
            [new c('2016-05-13 18:00'), new c('2016-05-14 04:00'), 0, 2400, 0],
        ];
    }
}
