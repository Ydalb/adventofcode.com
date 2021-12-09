<?php

$input = file(__DIR__ . '/input', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$input = array_map(function(string $line) {
    return str_split($line);
}, $input);

$max_y = count($input);
$max_x = count($input[0]);

$low_points = [];

for ($y = 0; $y < $max_y; $y++) {

    for ($x = 0; $x < $max_x; $x++) {

        $is_lowest = true;

        // up
        $adjacent_y = $y - 1;
        $adjacent_x = $x;
        if (isset($input[$adjacent_y][$adjacent_x]) && $input[$adjacent_y][$adjacent_x] <= $input[$y][$x]) {
            $is_lowest = false;
        }
        // down
        $adjacent_y = $y + 1;
        $adjacent_x = $x;
        if (isset($input[$adjacent_y][$adjacent_x]) && $input[$adjacent_y][$adjacent_x] <= $input[$y][$x]) {
            $is_lowest = false;
        }
        // left
        $adjacent_y = $y;
        $adjacent_x = $x - 1;
        if (isset($input[$adjacent_y][$adjacent_x]) && $input[$adjacent_y][$adjacent_x] <= $input[$y][$x]) {
            $is_lowest = false;
        }
        // right
        $adjacent_y = $y;
        $adjacent_x = $x + 1;
        if (isset($input[$adjacent_y][$adjacent_x]) && $input[$adjacent_y][$adjacent_x] <= $input[$y][$x]) {
            $is_lowest = false;
        }

        if ($is_lowest) {
            $low_points[$y][$x] = true;
        }

    }

}

$sum = 0;
foreach ($low_points as $coord_y => $coords_x) {
    foreach ($coords_x as $coord_x => $result) {
        if ($result) {
            $sum+= $input[$coord_y][$coord_x] + 1;
        }
    }
}
echo $sum . PHP_EOL;