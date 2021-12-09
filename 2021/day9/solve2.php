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

        $tests = [
            ['y' => $y - 1, 'x' => $x], // up
            ['y' => $y + 1, 'x' => $x], // down
            ['y' => $y, 'x' => $x - 1], // left
            ['y' => $y, 'x' => $x + 1], // right
        ];

        foreach ($tests as $test) {
            $adjacent_y = $test['y'];
            $adjacent_x = $test['x'];
            if (isset($input[$adjacent_y][$adjacent_x]) && $input[$adjacent_y][$adjacent_x] <= $input[$y][$x]) {
                $is_lowest = false;
            }
        }

        if ($is_lowest) {
            $low_points[$y][$x] = true;
        }

    }

}

$basins = [];
foreach ($low_points as $y => $coords_x) {
    foreach (array_keys($coords_x) as $x) {
        retrieve_basin($input, $y .',' . $x, $y, $x, $basins);
    }
}

function retrieve_basin(array $input, string $origin, int $y, int $x, array &$basins) {

    $basins[$origin][$y.','.$x] = true;

    $tests = [
        ['y' => $y - 1, 'x' => $x], // up
        ['y' => $y + 1, 'x' => $x], // down
        ['y' => $y, 'x' => $x - 1], // left
        ['y' => $y, 'x' => $x + 1], // right
    ];

    foreach ($tests as $test) {
        $adjacent_y = $test['y'];
        $adjacent_x = $test['x'];
        if (isset($input[$adjacent_y][$adjacent_x]) && $input[$adjacent_y][$adjacent_x] != 9 && !isset($basins[$origin][$adjacent_y.','.$adjacent_x])) {
            $basins[$origin][$adjacent_y.','.$adjacent_x] = true;
            retrieve_basin($input, $origin, $adjacent_y, $adjacent_x, $basins);
        }
    }

}

array_multisort(array_map('count', $basins), SORT_DESC, $basins);

$first = array_shift($basins);
$second = array_shift($basins);
$third = array_shift($basins);

echo count($first) * count($second) * count($third) . PHP_EOL;