<?php

$fopen = fopen( __DIR__ . '/input', 'r' );

$numbers = [];
while ($line = fgets($fopen)) {
    $numbers[] = (int)$line;
}

fclose($fopen);

$offset = 25;

for ($i = $offset; $i < count($numbers); $i++) {

    $number = $numbers[$i];

    $preamble = array_slice($numbers, $i - $offset, $offset);

    if (!has_matching_sum($number, $preamble)) {
        echo "{$number} is KO\n";
    }

}

function has_matching_sum(int $number, array $preamble) : bool {
    for ($i = 0; $i < count($preamble) - 1; $i++) {
        for ($j = $i + 1; $j - count($preamble); $j++) {
            if ($number == ($preamble[$i] + $preamble[$j])) {
                return true;
            }
        }
    }
    return false;
}

function dd() {
    var_dump(func_get_args());
    die;
}