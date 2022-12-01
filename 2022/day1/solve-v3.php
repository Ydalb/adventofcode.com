<?php

$calories = array_map(
    fn($addition) => eval("return {$addition};"),
    array_map(
        fn($items) => str_replace("\n", "+", $items),
        explode("\n\n", file_get_contents(__DIR__ . '/input'))
    )
);
rsort($calories);
echo 'Part1: ' . max($calories) . PHP_EOL;
echo 'Part2: ' . array_sum(array_slice($calories,  0, 3));