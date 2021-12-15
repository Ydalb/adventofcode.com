<?php

require_once 'graph.php';

$input = file(__DIR__ . '/input', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$input = array_map(function(string $line) {
    return str_split($line);
}, $input);

$max_y = count($input);
$max_x = count($input[0]);

$graph = Graph::create();

for ($y = 0; $y < $max_y; $y++) {

    for ($x = 0; $x < $max_x; $x++) {

        foreach ([[$y - 1, $x], [$y + 1, $x], [$y, $x - 1], [$y, $x + 1]] as [$j, $i]) {
            if (!isset($input[$j][$i])) {
                continue;
            }
            $graph->add($y . ',' . $x, $j . ',' . $i, $input[$j][$i], $add_inverse_edge = false);
        }

    }

}

$route = $graph->search('0,0', ($max_y - 1) . ',' . ($max_x - 1));
var_dump($route);
var_dump($graph->cost($route));

display_route($route);

function display_route(array $route) {
    global $input, $max_y, $max_x;
    for ($y = 0; $y < $max_y; $y++) {
        for ($x = 0; $x < $max_x; $x++) {
            if (in_array($y . ',' . $x, $route)) {
                echo '-';
            } else {
                echo $input[$y][$x];
            }
        }
        echo PHP_EOL;
    }
    echo PHP_EOL;
}