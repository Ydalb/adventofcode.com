<?php

$input = file(__DIR__ . '/input', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$fold_instructions = [];
$max_x = 0;
$max_y = 0;
$grid = [];
foreach ($input as $i => &$line) {
    if (str_starts_with($line, 'fold')) {
        preg_match('/ ([xy])=(\d+)/', $line, $matches);
        $fold_instructions[] = [$matches[1], (int)$matches[2]];
        unset($input[$i]);
    } else {
        [$x, $y]= explode(',', $line);
        $grid[$y][$x] = '#';
        $line = [$y, $x];
        if ($x > $max_x) {
            $max_x = $x;
        }
        if ($y >= $max_y) {
            $max_y = $y;
        }
    }
}

for ($y = 0; $y <= $max_y; $y++) {
    for ($x = 0; $x <= $max_x; $x++) {
        if (!isset($grid[$y][$x])) {
            $grid[$y][$x] = '.';
        }
    }
}

//display_grid($grid);

echo 'Dots=' . count_dots($grid) . "\n";

foreach ($fold_instructions as $instruction) {
    [$axe, $coord] = $instruction;
    fold($grid, $axe, $coord);
//    display_grid($grid);
    echo 'Dots=' . count_dots($grid) . "\n";
//    var_dump($grid);
//    exit;
}

display_grid($grid);


function fold(array &$grid, string $axe, int $coord) {
    echo "Folding along {$axe}={$coord}\n";
    for ($y = ($axe === 'y' ? $coord + 1 : 0); $y < count($grid); $y++) {
        for ($x = ($axe === 'x' ? $coord + 1 : 0); $x < count($grid[0]); $x++) {
            if (!isset($grid[$y][$x]) || $grid[$y][$x] !== '#') {
                continue;
            }
            if ($axe === 'x') {
                $distance_to_axe = $x - $coord;
                $new_x = $coord - $distance_to_axe;
                $grid[$y][$new_x] = '#';
//                echo "Folding {$y},{$x} to {$y},{$new_x}\n";
            } else {
                $distance_to_axe = $y - $coord;
                $new_y = $coord - $distance_to_axe;
                $grid[$new_y][$x] = '#';
//                echo "Folding {$y},{$x} to {$new_y},{$x}\n";
            }
            $grid[$y][$x] = '.';
        }
    }
}

function count_dots(array $grid) : int {
    $sum = 0;
    foreach ($grid as $dots) {
        foreach ($dots as $dot) {
            $sum+= ($dot === '#' ? 1 : 0);
        }
    }
    return $sum;
}

function display_grid(array $grid) : void {
    for ($y = 0; $y < 6; $y++) {
        for ($x = 0; $x < 40; $x++) {
            echo $grid[$y][$x];
        }
        echo PHP_EOL;
    }
    echo PHP_EOL;
}