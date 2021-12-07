<?php

$input = file(__DIR__ . '/input', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES)[0];
$input = explode(',', $input);

sort($input);

$min_cost = PHP_INT_MAX;
for ($i = 0; $i <= count($input) - 1; $i++) {
    $target = $i;
    $cost = 0;
    foreach ($input as $position) {
        $diff = abs($position - $target);
        $cost += $diff * ($diff + 1) / 2;
    }
    if ($cost < $min_cost) {
        $min_cost = $cost;
    }
}

echo $min_cost;