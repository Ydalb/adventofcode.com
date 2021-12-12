<?php

$input = file(__DIR__ . '/input', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$input = array_map(function(string $line) {
    return str_split($line);
}, $input);

$num_octopous = 0;
foreach ($input as $row) {
    foreach ($row as $col) {
        $num_octopous++;
    }
}

display_grid($input);

$step = 0;

do {

    $num_flashes = 0;

    $step++;

    increase_level($input);

    $has_flashed = [];

    for ($y = 0; $y < count($input); $y++) {

        for ($x = 0; $x < count($input[0]); $x++) {

            if ($input[$y][$x] > 9) {
                flashes_octopous($input, $y, $x, $has_flashed);
            }

        }

    }

    foreach ($has_flashed as $j => $ii) {
        foreach ($ii as $i => $bool_hash_flashed) {
            $num_flashes+= 1;
            $input[$j][$i] = 0;
        }
    }

    display_grid($input);

    echo '$num_flashes=' . $num_flashes;
    echo ' $num_octopous=' . $num_octopous;
    echo PHP_EOL;

} while ($num_flashes !== $num_octopous);


echo '$step=' . $step . PHP_EOL;

function flashes_octopous(array &$input, int $y, int $x, array &$has_flashed) : array {
    if (isset($has_flashed[$y][$x])) {
        return $has_flashed;
    }
    $has_flashed[$y][$x] = true;
    for ($j = $y - 1; $j <= $y + 1; $j++) {
        for ($i = $x - 1; $i <= $x + 1; $i++) {
            if (!isset($input[$j][$i])) {
                continue;
            }
            if ($j === $y && $i === $x) {
                continue;
            }
            if (isset($has_flashed[$j][$i])) {
                continue;
            }
            $input[$j][$i]++;
            if ($input[$j][$i] > 9) {
                flashes_octopous($input, $j, $i, $has_flashed);
            }
        }
    }
    return $has_flashed;
}

function increase_level(array &$input) : void {
    for ($y = 0; $y < count($input); $y++) {
        for ($x = 0; $x < count($input[0]); $x++) {
            $input[$y][$x]++;
        }
    }
}

function display_grid(array $input) : void {
    for ($y = 0; $y < count($input); $y++) {
        for ($x = 0; $x < count($input[0]); $x++) {
            echo $input[$y][$x];
        }
        echo PHP_EOL;
    }
    echo PHP_EOL;
}