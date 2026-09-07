<?php

namespace Tests\Unit;

use App\Services\DistanceCalculator;
use Tests\TestCase;

class DistanceCalculatorTest extends TestCase
{
    public function test_calculates_zero_distance_for_same_point(): void
    {
        $calculator = new DistanceCalculator();
        $distance = $calculator->calculate(-8.15627, 113.43497, -8.15627, 113.43497);

        $this->assertEqualsWithDelta(0.0, $distance, 0.01);
    }

    public function test_calculates_distance_between_different_points(): void
    {
        $calculator = new DistanceCalculator();
        // Distance between Xl RPL 2 and JURUSAN is around ~400 meters
        $distance = $calculator->calculate(-8.15627, 113.43497, -8.15530, 113.438508);

        $this->assertGreaterThan(300, $distance);
        $this->assertLessThan(500, $distance);
    }
}
