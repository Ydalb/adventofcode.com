<?php

use AOC\Input;

require __DIR__ . '/../../collection.php';


class Day11 {

    static public function runOne() : int {

        return self::input(2);

    }

    static public function runTwo() : int {

        return self::input(1_000_000);

    }

    static public function input(int $coeff) : int {

        $data = (new Input(__DIR__ . '/input'))
            ->map('str_split')
            ->toArray()
        ;

        //expand horizontally
        $column_without_galaxies = [];
        for ($j = 0; $j < count($data[0]); $j++) {
            $has_galaxies = false;
            for ($i = 0; $i < count($data); $i++) {
                if ($data[$i][$j] == '#') {
                    $has_galaxies = true;
                    break;
                }
            }
            if (!$has_galaxies) {
                $column_without_galaxies[] = $j;
            }
        }

        for ($i = 0; $i < count($data); $i++) {
            $row = $data[$i];
            foreach ($column_without_galaxies as $column_index) {
                $row[$column_index] = 'x';
            }
            if (!in_array('#', $row)) {
                $row = array_fill(0, count($data[$i]), 'x');
            }
            $univers[] = $row;
        }

        $galaxies = [];
        for ($i = 0; $i < count($univers); $i++) {
            for ($j = 0; $j < count($univers[$i]); $j++) {
                if ($univers[$i][$j] == '#') {
                    $galaxies[] = [$i, $j];
                }
            }
        }

        $pairs = [];
        for ($i = 0; $i < count($galaxies); $i++) {
            for ($j = $i + 1; $j < count($galaxies); $j++) {
                $pairs[] = [
                    $galaxies[$i],
                    $galaxies[$j]
                ];
            }
        }

        $sum_shortest_path = 0;

        foreach ($pairs as [$galaxy_a, $galaxy_b]) {

            $distance_i = abs($galaxy_a[0] - $galaxy_b[0]);
            $distance_j = abs($galaxy_a[1] - $galaxy_b[1]);
            $distance = $distance_i + $distance_j;

            $lignes_traversees = 0;

            $y1 = min($galaxy_a[0], $galaxy_b[0]);
            $y2 = max($galaxy_a[0], $galaxy_b[0]);
            for ($y = $y1; $y <= $y2; $y++) {
                if ($univers[$y][0] == 'x') {
                    $lignes_traversees++;
                }
            }

            $x1 = min($galaxy_a[1], $galaxy_b[1]);
            $x2 = max($galaxy_a[1], $galaxy_b[1]);
            for ($x = $x1; $x <= $x2; $x++) {
                if ($univers[0][$x] == 'x') {
                    $lignes_traversees++;
                }
            }

            $sum_shortest_path+= $distance + $lignes_traversees * ($coeff - 1);

        }

        return $sum_shortest_path;

    }

    static private function draw(array $univers) {
        echo "DRAWING:" . PHP_EOL;
        for ($i = 0; $i < count($univers); $i++) {
            for ($j = 0; $j < count($univers[$i]); $j++) {
                echo $univers[$i][$j];
            }
            echo PHP_EOL;
        }
    }

}

echo Day11::runOne() . PHP_EOL;
echo Day11::runTwo() . PHP_EOL;