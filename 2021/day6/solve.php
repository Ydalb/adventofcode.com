<?php

ini_set('memory_limit','-1');

$input = file(__DIR__ . '/input', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
echo 'Initial state: ' . $input[0] . PHP_EOL;

$lanternfishes = explode(',', $input[0]);

echo 'Total lanternfishes: ' . grow_lanternfish($lanternfishes, 80) . PHP_EOL;

function grow_lanternfish(array &$lanternfishes, int $stop_after_n_days, int $num_days = 1) : int {
    $num_new_lanternfished = 0;
    foreach ($lanternfishes as &$internal_timer) {
        switch ($internal_timer) {
            case 0: $internal_timer = 6; $num_new_lanternfished++; break;
            default: $internal_timer--; break;
        }
    }
    for ($x = 0; $x < $num_new_lanternfished; ++$x) {
        array_push($lanternfishes, 8);
    }
//    echo "After {$num_days} days: " . join(',', $lanternfishes) . PHP_EOL;
    if ($num_days < $stop_after_n_days) {
        return grow_lanternfish($lanternfishes, $stop_after_n_days, $num_days + 1);
    } else {
        return count($lanternfishes);
    }
};
