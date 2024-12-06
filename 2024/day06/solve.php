<?php

use AOC\Input;

require __DIR__ . '/../../collection.php';


class Day06 {

    static public function runOne() : int {

        [$data, $start_y, $start_x] = self::input();

        $visited = self::getVisited($data, $start_y, $start_x);

        return count(array_keys($visited));

    }

    static public function runTwo() : int {

        [$data, $start_y, $start_x] = self::input();

        $visited = self::getVisited($data, $start_y, $start_x);

        $sum = 0;

        foreach (array_keys($visited) as $visit) {

            [$y, $x] = explode(':', $visit);

            if ($y === $start_y && $x === $start_x) {
                continue;
            }

            $data_updated = $data;
            $data_updated[$y][$x] = 'X';
            try {
                self::getVisited($data_updated, $start_y, $start_x);
            } catch (LoopException) {
                $sum++;
            }

        }

        return $sum;

    }

    static private function getVisited(array $data, int $start_y, int $start_x) : array {

        $direction = 10;
        $current_y = $start_y;
        $current_x = $start_x;
        $visited = [];
        $loop_detector = [];
        while(true) {

//            echo "direction={$direction} current_y={$current_y} current_x={$current_x}\n";
//            self::print($data, $current_y, $current_x);

            $next_y = null;
            $next_x = null;

            if ($direction % 10 === 0) { //up
                $next_y = $current_y - 1;
                $next_x = $current_x;
            } else if ($direction % 11 === 0) { //right
                $next_y = $current_y;
                $next_x = $current_x + 1;
            } else if ($direction % 12 === 0) { //down
                $next_y = $current_y + 1;
                $next_x = $current_x;
            } else if ($direction % 13 === 0) { // left
                $next_y = $current_y;
                $next_x = $current_x - 1;
            } else {
                throw new \Exception('No such direction: ' . $direction);
            }

            if (isset($data[$next_y][$next_x])) {
                if ($data[$next_y][$next_x] === '#' || $data[$next_y][$next_x] === 'X') {
                    $direction++;
                    if ($direction === 14) {
                        $direction = 10;
                    }
                } else {
                    $current_y = $next_y;
                    $current_x = $next_x;
                    if (isset($loop_detector[$current_y . ':' . $current_x . ':' . $direction])) {
                        throw new LoopException();
                    }
                    $loop_detector[$current_y . ':' . $current_x . ':' . $direction] = 1;
                    $visited[$current_y . ':' . $current_x] = 1;
                }
            } else {
                break;
            }

        }

        return $visited;

    }

    static private function print(array $data, int $current_y, int $current_x) : void {
        for ($y = 0; $y < count($data); $y++) {
            for ($x = 0; $x < count($data[$y]); $x++) {
                if ($y === $current_y && $x === $current_x) {
                    echo '*';
                } else {
                    echo $data[$y][$x];
                }
            }
            echo PHP_EOL;
        }
    }

    static private function input() : array {
        $data = (new Input(__DIR__ . '/input'))->map('str_split')->toArray();
        for ($y = 0; $y < count($data); $y++) {
            for ($x = 0; $x < count($data[$y]); $x++) {
                if ($data[$y][$x] === '^') {
                    return [$data, $y, $x];
                }
            }
        }
        throw new \Exception("Couldn't not find starting point");
    }

}

class LoopException extends \Exception {}

echo Day06::runOne() . PHP_EOL;
echo Day06::runTwo() . PHP_EOL;