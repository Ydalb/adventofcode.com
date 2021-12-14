<?php

ini_set('memory_limit','-1');

$input = file(__DIR__ . '/input', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$polymer_template = array_shift($input);

$pair_rules = [];
foreach ($input as $line) {
    [$pair_left, $pair_right] = explode(' -> ', $line);
    $pair_rules[$pair_left] = $pair_right;
}

for ($step = 1; $step <= 40; $step++) {
    $result = '';
    for ($i = 0; $i < strlen($polymer_template) - 1; $i++) {

        $pair = substr($polymer_template, $i, 2);

        if (isset($pair_rules[$pair])) {
            $result.= $pair[0] . $pair_rules[$pair];
        } else {
            $result.= $pair;
        }

    }

    $result.= substr($polymer_template, -1);

    echo '$step=' . $step . ' - length($result)=' . strlen($result) . PHP_EOL;
    $polymer_template = $result;
}

$polymer_template_stats = array_count_values(str_split($polymer_template));
arsort($polymer_template_stats, SORT_DESC);

var_dump($polymer_template_stats);

$first = reset($polymer_template_stats);
$end = end($polymer_template_stats);

echo '$first-$end=' . ($first - $end) . PHP_EOL;