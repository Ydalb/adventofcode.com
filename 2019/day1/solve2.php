<?php

$fopen = fopen(__DIR__ . '/input', 'r');

$total_fuel = 0;
while ($line = fgets($fopen)) {
    $mass = (int)$line;
    while ($mass > 5) {
        $fuel = floor($mass / 3) - 2;
        $total_fuel+= $fuel;
        $mass = $fuel;
    }
}

fclose($fopen);

echo $total_fuel;
