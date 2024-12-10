<?php

use AOC\Input;

require __DIR__ . '/../../collection.php';


class Day10 {

    static public function runOne() : int {

        $trailheads = self::input();

        $sum = 0;
        foreach ($trailheads as $nines) {
            $sum+= count($nines);
        }

        return $sum;

    }

    static public function runTwo() : int {

        $trailheads = self::input();

        $sum = 0;
        foreach ($trailheads as $nines) {
            foreach ($nines as $rating) {
                $sum+= $rating;
            }
        }

        return $sum;

    }

    static private function hike(array $data, int $y, int $x, int $next_value, &$carry) : void {
        if ($next_value == 10) {
            if (!isset($carry[$y . ',' . $x])) {
                $carry[$y . ',' . $x] = 0;
            }
            $carry[$y . ',' . $x]++;
            return;
        }
        foreach ([[-1, 0], [0, 1], [1, 0], [0, -1]] as [$yy, $xx]) {
            $next_y = $y + $yy;
            $next_x = $x + $xx;
            if (!isset($data[$next_y][$next_x])) {
                continue;
            }
            if ($data[$next_y][$next_x] == $next_value) {
                self::hike($data, $next_y, $next_x, $next_value + 1, $carry);
            }
        }
    }

    static private function input() : array {

        $data = (new Input(__DIR__ . '/input'))
            ->map('str_split')
            ->toArray()
        ;

        $trailheads = [];

        for ($y = 0; $y < count($data); $y++) {
            for ($x = 0; $x < count($data[$y]); $x++) {
                if ($data[$y][$x] == '0') {
                    $carry = [];
                    self::hike($data, $y, $x, 1, $carry);
                    $trailheads[$y . ',' . $x] = $carry;
                }
            }
        }

        return $trailheads;

    }

}

echo Day10::runOne() . PHP_EOL;
echo Day10::runTwo() . PHP_EOL;