<?php

ini_set('memory_limit','-1');

$input = file(__DIR__ . '/input', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
//echo 'Initial state: ' . $input[0] . PHP_EOL;

$lanternfishes_by_internal_timer = array_fill(0, 8 + 1, 0);
foreach (explode(',', $input[0]) as $internal_timer) {
    $lanternfishes_by_internal_timer[$internal_timer]++;
}

echo 'Total lanternfishes: ' . grow_lanternfish($lanternfishes_by_internal_timer, 256) . PHP_EOL;

function grow_lanternfish(array $lanternfishes_by_internal_timer, int $stop_after_n_days, int $num_days = 1) : int {
    $num_new_lanternfished = 0;
    $lanternfishes_new_state = array_fill(0, 8 + 1, 0);
    foreach ($lanternfishes_by_internal_timer as $internal_timer => $count) {
        if ($count == 0) {
            continue;
        }
        if ($internal_timer == 0) {
            $num_new_lanternfished = $count;
            $internal_timer = 6;
        } else {
            $internal_timer--;
        }
        $lanternfishes_new_state[$internal_timer]+= $count;
    }
    $lanternfishes_new_state[8] = $num_new_lanternfished;
    if ($num_days < $stop_after_n_days) {
        return grow_lanternfish($lanternfishes_new_state, $stop_after_n_days, $num_days + 1);
    } else {
        return array_sum($lanternfishes_new_state);
    }
}