<?php

$lines = file(__DIR__ . '/input', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$num_lines = count($lines);

$sum_bits = [];
foreach ($lines as $line) {
    $line = trim($line);
    $bits = str_split($line);
    foreach ($bits as $x => $bit) {
        if (!isset($sum_bits[$x])) {
            $sum_bits[$x] = 0;
        }
        $sum_bits[$x]+= $bit;
    }
}

$gama_rate = '';
$epsilon_rate = '';
foreach ($sum_bits as $sum) {
    if ($num_lines - $sum > $num_lines/2) {
        $gama_rate.= 1;
        $epsilon_rate.= 0;
    } else {
        $gama_rate.= 0;
        $epsilon_rate.= 1;
    }
}

echo bindec($gama_rate) * bindec($epsilon_rate) . PHP_EOL;