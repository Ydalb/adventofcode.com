<?php

class Day01 {

    static public function runOne() : string {

        $measurements = self::input();

        $num_increased = 0;

        for ($i = 1; $i <= count($measurements) - 1; $i++) {
            if ($measurements[$i] > $measurements[$i-1]) {
                $num_increased++;
            }
        }

        return $num_increased;

    }

    static public function runTwo() : string {

        $measurements = self::input();

        $num_increased = 0;

        for ($i = 0; $i < count($measurements) - 3; $i++) {
            $measurement_1 = $measurements[$i] + $measurements[$i+1] + $measurements[$i+2];
            $measurement_2 = $measurements[$i+1] + $measurements[$i+2] + $measurements[$i+3];
            if ($measurement_2 > $measurement_1) {
                $num_increased++;
            }
        }

        return $num_increased;
    }

    static private function input() : array {

        $fopen = fopen( __DIR__ . '/input', 'r' );

        $lines = [];
        while ($line = fgets($fopen)) {
            $lines[] = (int)$line;
        }
        fclose($fopen);

        return $lines;
    }

}

echo Day01::runOne() . PHP_EOL;
echo Day01::runTwo() . PHP_EOL;