<?php

use AOC\Input;

require __DIR__ . '/../../collection.php';


class Day10 {

    static public function runOne() : int {

        [$data, $distance, $polygon] = self::input();

        return $distance / 2;

    }

    static public function runTwo() : int {

        [$data, $distance, $polygon] = self::input();

        $num_lines = count($data);
        $num_column = count($data[0]);
        $num_tiles = 0;
        for ($y = 0; $y < $num_lines; $y++) {
            for ($x = 0; $x < $num_column; $x++) {
                $current = [$y, $x];
                if (!in_array($current, $polygon)) {
                    if (self::isPointInPolygon($polygon, $current)) {
                        $num_tiles++;
                    }
                }
            }
        }

        return $num_tiles;

    }

    //thx ChatGPT
    static private function isPointInPolygon(array $polygon, array $point) : bool {

        $pointY = $point[0];
        $pointX = $point[1];
        $isInside = false;
        $polygonSize = count($polygon);

        for ($i = 0, $j = $polygonSize - 1; $i < $polygonSize; $j = $i++) {
            $vertex1Y = $polygon[$i][0];
            $vertex1X = $polygon[$i][1];
            $vertex2Y = $polygon[$j][0];
            $vertex2X = $polygon[$j][1];

            $intersect = (($vertex1Y > $pointY) != ($vertex2Y > $pointY)) &&
                ($pointX < ($vertex2X - $vertex1X) * ($pointY - $vertex1Y) / ($vertex2Y - $vertex1Y) + $vertex1X);
            if ($intersect) {
                $isInside = !$isInside;
            }
        }

        return $isInside;

    }

    static public function input() : array {

        $data = (new Input(__DIR__ . '/input'))->map('str_split')->toArray();

        //starting point
        $num_lines = count($data);
        $num_column = count($data[0]);
        for ($y = 0; $y < $num_lines; $y++) {
            for ($x = 0; $x < $num_column; $x++) {
                if ($data[$y][$x] == 'S') {
                    break 2;
                }
            }
        }

        $current_x = $x;
        $current_y = $y;
        $previous_x = null;
        $previous_y = null;
        $distance = 0;
        $polygon = [
            [$y, $x],
        ];
        $pipe = 'S';

        do {

            $top_pipe = $data[$current_y - 1][$current_x];
            $right_pipe = $data[$current_y][$current_x + 1];
            $bottom_pipe = $data[$current_y + 1][$current_x];
            $left_pipe = $data[$current_y][$current_x - 1];

            $can_go_top = in_array($top_pipe, ['S', '|', '7', 'F'])
                && ($current_y - 1 != $previous_y)
                && in_array($pipe, ['S', '|', 'J', 'L'])
            ;
            $can_go_right = in_array($right_pipe, ['S', '-', 'J', '7'])
                && ($current_x + 1 !== $previous_x)
                && in_array($pipe, ['S', '-', 'L', 'F'])
            ;
            $can_go_bottom = in_array($bottom_pipe, ['S', '|', 'J', 'L'])
                && ($current_y + 1 !== $previous_y)
                && in_array($pipe, ['S', '|', '7', 'F'])
            ;
            $can_go_left = in_array($left_pipe, ['S', '-', 'L', 'F'])
                && ($current_x - 1 !== $previous_x)
                && in_array($pipe, ['-', 'J', '7'])
            ;

            $previous_x = $current_x;
            $previous_y = $current_y;

            if ($can_go_top) {
                $pipe = $top_pipe;
                $current_y--;
            } else if ($can_go_right) {
                $pipe = $right_pipe;
                $current_x++;
            } else if ($can_go_bottom) {
                $pipe = $bottom_pipe;
                $current_y++;
            } else if ($can_go_left) {
                $pipe = $left_pipe;
                $current_x--;
            } else {
                var_dump("STUCK @ Y={$current_y},X={$current_x}");
                die;
            }

            $polygon[] = [$current_y, $current_x];
            $distance++;

        } while ($pipe != 'S');

        return [$data, $distance, $polygon];

    }

}

echo Day10::runOne() . PHP_EOL;
echo Day10::runTwo() . PHP_EOL;