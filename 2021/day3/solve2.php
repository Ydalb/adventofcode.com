<?php

$lines_a = file(__DIR__ . '/input', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$lines_b = $lines_a;

$size = strlen($lines_a[0]);

$find_most_occurring_bit = function(array $lines, int $position = 0) {
    $bit_0 = 0;
    $bit_1 = 0;
    foreach ($lines as $line) {
        if ($line[$position] == 0) {
            $bit_0++;
        } else {
            $bit_1++;
        }
    }
    return (int)($bit_1 >= $bit_0);
};

for ($position = 0; $position < $size; $position++) {

    $most_occurring_bit_oxygen = $find_most_occurring_bit($lines_a, $position);
    $less_occurring_bit_co2 = (int) !$find_most_occurring_bit($lines_b, $position);

    if (count($lines_a) > 1) {
        foreach ($lines_a as $i => $line) {
            if ($line[$position] != $most_occurring_bit_oxygen) {
                unset($lines_a[$i]);
            }
        }
    }

    if (count($lines_b) > 1) {
        foreach ($lines_b as $i => $line) {
            if ($line[$position] != $less_occurring_bit_co2) {
                unset($lines_b[$i]);
            }
        }
    }
}

$oxygen_generator_rating = array_pop($lines_a);
$co2_scrubber_rating = array_pop($lines_b);

echo bindec($oxygen_generator_rating) * bindec($co2_scrubber_rating) . PHP_EOL;