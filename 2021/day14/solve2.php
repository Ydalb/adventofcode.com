<?php

ini_set('memory_limit','-1');

$input = file(__DIR__ . '/input', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$polymer_template = array_shift($input);

$pair_rules = [];
foreach ($input as $line) {
    [$pair_left, $pair_right] = explode(' -> ', $line);
    $pair_rules[$pair_left] = $pair_right;
}

$pairs = [];
for ($i = 0; $i < strlen($polymer_template) - 1; $i++) {
    $pair = $polymer_template[$i] . $polymer_template[$i+1];
    if (!isset($pairs[$pair])) {
        $pairs[$pair] = 0;
    }
    $pairs[$pair]++;
}


$length = 0;

for ($step = 1; $step <= 40; $step++) {

    foreach ($pairs as $pair => $count) {
        $transform = $pair_rules[$pair];
        $pair_1 = $pair[0] . $transform;
        $pair_2 = $transform . $pair[1];

//        echo '$pair=' . $pair . ' $pair_1=' . $pair_1 . ' - $pair_2=' . $pair_2 . PHP_EOL;

        if (!isset($pairs[$pair_1])) {
            $pairs[$pair_1] = 0;
        }
        $pairs[$pair_1]+= $count;
        if (!isset($pairs[$pair_2])) {
            $pairs[$pair_2] = 0;
        }
        $pairs[$pair_2]+= $count;

        $pairs[$pair]-= $count;

    }

    $pairs = array_filter($pairs, function(int $count) {
        return $count > 0;
    });

//    echo '$step=' . $step . ' $length=' . $length . PHP_EOL;

//    die;
}

$stats = [];

foreach ($pairs as $pair => $count) {

    [$letter_a, $letter_b] = str_split($pair);

    if (!isset($stats[$letter_a])) {
        $stats[$letter_a] = 0;
    }
    if (!isset($stats[$letter_b])) {
        $stats[$letter_b] = 0;
    }
    $stats[$letter_a] += $count;
    $stats[$letter_b] += $count;

}

foreach ($stats as $letter => &$count) {
    if ($letter === $polymer_template[0] || $letter === substr($polymer_template, -1)) {
        $count = ($count - 1) / 2 + 1;
    } else {
        $count/= 2;
    }
}

//    var_dump($stats);
//    die;

$length = array_sum($stats);

arsort($stats, SORT_DESC);

$first = reset($stats);
$end = end($stats);


echo '$step=' . ($step - 1) . ' ' . '$length=' . $length . ' $diff=' . ($first - $end) . PHP_EOL;
