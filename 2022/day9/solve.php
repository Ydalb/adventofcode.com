<?php

class Day09 {

    static public function runOne() : int {
        return self::run(2);
    }

    static public function runTwo() : int {
        return self::run($num_knots = 10);
    }

    static private function run(int $num_knots) {

        $moves = self::input();
        $visited = [];
        $num_visited = 0;
        $knots = [];
        $index_tail = $num_knots - 1;

        for ($i = 0; $i < $num_knots; $i++) {
            $knots[] = [0, 0];
        }

        foreach ($moves as [$direction, $duration]) {

            while ($duration > 0) {

                foreach ($knots as $index => $knot) {

                    if ($index === 0) {
                        if ($direction === 'R') {
                            $knots[$index][0]++;
                        } else if ($direction === 'U') {
                            $knots[$index][1]++;
                        } else if ($direction === 'L') {
                            $knots[$index][0]--;
                        } else if ($direction === 'D') {
                            $knots[$index][1]--;
                        }

                    } else {

                        $knots[$index] = self::follow($knots[$index - 1][0], $knots[$index - 1][1], $knots[$index][0], $knots[$index][1]);

                        if ($index === $index_tail) {
                            if (!isset($visited[$knots[$index][0]][$knots[$index][1]])) {
                                $num_visited++;
                                $visited[$knots[$index][0]][$knots[$index][1]] = 1;
                            }
                        }

                    }

                }

                $duration--;

            }

//            self::draw($knots);

        }

        return $num_visited;
    }

    static private function draw(array $knots) {
        for ($j = 20; $j > -20; $j--) {
            for ($i = -20; $i < 20; $i++) {
                $has_knot = false;
                foreach ($knots as $index => $knot) {
                    if ($knot === [$i, $j]) {
                        echo $index;
                        $has_knot = true;
                        break;
                    }
                }
                if (!$has_knot) {
                    if ($i === 0 && $j === 0) {
                        echo 's';
                    } else {
                        echo '.';
                    }
                }
            }
            echo PHP_EOL;
        }
    }

    static private function follow(int $x_h, int $y_h, int $x_t, int $y_t) : array {
        $delta_x = abs($x_h - $x_t);
        $delta_y = abs($y_h - $y_t);
        if ($delta_x === 2 && $delta_y === 0) {
            $x_t+= ($x_h - $x_t > 0) ? $delta_x - 1 : -$delta_x + 1;
        } else if ($delta_x === 0 && $delta_y === 2) {
            $y_t+= ($y_h - $y_t > 0) ? $delta_y - 1 : -$delta_y + 1;
        } else if ($delta_y === 2 && $delta_x === 1) {
            $x_t+= $x_h - $x_t;
            $y_t+= ($y_h - $y_t > 0) ? $delta_y - 1 : -$delta_y + 1;
        } else if ($delta_x === 2 && $delta_y === 1) {
            $y_t+= $y_h - $y_t;
            $x_t+= ($x_h - $x_t > 0) ? $delta_x - 1 : -$delta_x + 1;
        } else if ($delta_x === 2 && $delta_y === 2) { // part 2
            $x_t+= ($x_h - $x_t > 0) ? $delta_x - 1 : -$delta_x + 1;
            $y_t+= ($y_h - $y_t > 0) ? $delta_y - 1 : -$delta_y + 1;
        }
        return [$x_t, $y_t];
    }

    static private function input() : array {

        $input = file(__DIR__ . '/input', FILE_IGNORE_NEW_LINES);

        $moves = [];
        foreach ($input as $line) {
            $moves[] = explode(' ', $line);
        }

        return $moves;

    }

}

echo Day09::runOne() . PHP_EOL;
echo Day09::runTwo() . PHP_EOL;