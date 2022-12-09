<?php

class Day09 {

    static public function runOne() : int {

        $moves = self::input();
        $visited = [];
        $num_visited = 0;

        $knots = [
            [0, 0],
            [0, 0],
        ];

        foreach ($moves as [$direction, $duration]) {

            echo "Move '{$direction} {$duration}'\n";

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
                        } else {
                            throw new \Exception("Unhandled direction {$direction}");
                        }
                    } else {

                        $knots[$index] = self::follow($knots[$index - 1][0], $knots[$index - 1][1], $knots[$index][0], $knots[$index][1]);

                        if (!isset($visited[$knots[$index][0]][$knots[$index][1]])) {
                            $num_visited++;
                            $visited[$knots[$index][0]][$knots[$index][1]] = 1;
                        }

                    }

                   echo "=> H ({$knots[0][0]},{$knots[0][1]}) T ({$knots[1][0]},{$knots[1][1]})\n";

                }

                $duration--;

            }

            self::draw($visited);

        }

        return $num_visited;

    }

    static public function runTwo() : int {

        $moves = self::input();
        $visited = [];
        $num_visited = 0;

        $knots = [
            [0, 0], //head
            [0, 0], //1
            [0, 0], //2
            [0, 0], //3
            [0, 0], //4
            [0, 0], //5
            [0, 0], //6
            [0, 0], //7
            [0, 0], //8
            [0, 0], //9
        ];

        foreach ($moves as [$direction, $duration]) {

            echo "Move '{$direction} {$duration}'\n";

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
                        } else {
                            throw new \Exception("Unhandled direction {$direction}");
                        }
                    } else {

                        $knots[$index] = self::follow($knots[$index - 1][0], $knots[$index - 1][1], $knots[$index][0], $knots[$index][1]);

                        if ($index === 9) {
                            if (!isset($visited[$knots[$index][0]][$knots[$index][1]])) {
                                $visited[$knots[$index][0]][$knots[$index][1]] = 1;
                                $num_visited++;
                            }
                        }

                    }

//                    echo "=> H ({$knots[0][0]},{$knots[0][1]}) T ({$knots[1][0]},{$knots[1][1]})\n";

                }

                $duration--;

            }

//            self::draw($visited);

        }

        return $num_visited;

    }

    static private function draw(array $visited) : void {

        for ($i = -10; $i < 10; $i++) {
            for ($j = 10; $j > -10; $j--) {
                if (isset($visited[$i][$j])) {
                    echo '#';
                } else {
                    echo '.';
                }
            }
            echo PHP_EOL;
        }

    }

    static private function follow(int $x_h, int $y_h, int $x_t, int $y_t) : array {
        $delta_x = abs($x_h - $x_t);
        $delta_y = abs($y_h - $y_t);
//        echo "delta_x={$delta_x} delta_y={$delta_y} \n";
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
//echo Day09::runTwo() . PHP_EOL;