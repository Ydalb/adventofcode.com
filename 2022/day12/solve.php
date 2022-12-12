<?php

require_once 'graph.php';

class Day12 {

    static public function runOne() : int {

        [$input, $start, $end] = self::input();

        $graph = Graph::create();

        $max_y = count($input);
        $max_x = count($input[0]);

        for ($y = 0; $y < $max_y; $y++) {

            for ($x = 0; $x < $max_x; $x++) {

                foreach ([[$y - 1, $x], [$y + 1, $x], [$y, $x - 1], [$y, $x + 1]] as [$j, $i]) {
                    if (!isset($input[$j][$i])) {
                        continue;
                    }
                    $from = $input[$y][$x];
                    $to = $input[$j][$i];
                    $from_coords = $y . ',' . $x;
                    $to_coords = $j . ',' . $i;

                    $delta = ord($to) - ord($from) + 26; //does not handle negative distance

                    if ($delta <= 27) {
                        $graph->add($from_coords, $to_coords, $delta, false);
                    }

                }

            }

        }

        $route = $graph->search($start, $end);

        return count($route) - 1;

    }

    static public function runTwo() : int {

        [$input, $start, $end] = self::input();

        $graph = Graph::create();

        $max_y = count($input);
        $max_x = count($input[0]);

        $possible_starts = [];

        for ($y = 0; $y < $max_y; $y++) {

            for ($x = 0; $x < $max_x; $x++) {

                if ($input[$y][$x] === 'a') {
                    $possible_starts[$y . ',' . $x] = true;
                }

                foreach ([[$y - 1, $x], [$y + 1, $x], [$y, $x - 1], [$y, $x + 1]] as [$j, $i]) {
                    if (!isset($input[$j][$i])) {
                        continue;
                    }
                    $from = $input[$y][$x];
                    $to = $input[$j][$i];
                    $from_coords = $y . ',' . $x;
                    $to_coords = $j . ',' . $i;

                    $delta = ord($to) - ord($from) + 26; //does not handle negative distance

                    if ($delta <= 27) {
                        $graph->add($from_coords, $to_coords, $delta, false);
                    }

                }

            }

        }

        $min_moves = PHP_INT_MAX;
        foreach (array_keys($possible_starts) as $start) {
            try {
                $route = $graph->search($start, $end);
            } catch(UnexpectedValueException $e) {
                echo $e->getMessage() . PHP_EOL;
                continue;
            }
            $moves = count($route) - 1;
            if ($moves < $min_moves) {
                $min_moves = $moves;
            }

        }

        return $min_moves;

    }

    static private function input() : array {

        $input = file(__DIR__ . '/input', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $input = array_map(function(string $line) {
            return str_split($line);
        }, $input);

        $start = null;
        $end = null;

        $max_y = count($input);
        $max_x = count($input[0]);

        for ($y = 0; $y < $max_y; $y++) {

            for ($x = 0; $x < $max_x; $x++) {

                if ($input[$y][$x] === 'S') {
                    $start = $y . ',' . $x;
                    $input[$y][$x] = 'a';
                } else if ($input[$y][$x] === 'E') {
                    $end = $y . ',' . $x;
                    $input[$y][$x] = 'z';
                }

            }
        }

        return [$input, $start, $end];

    }

}

echo Day12::runOne() . PHP_EOL;
echo Day12::runTwo() . PHP_EOL;