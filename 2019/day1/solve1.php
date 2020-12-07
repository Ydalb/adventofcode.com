<?php

$fopen = fopen( __DIR__ . '/input', 'r' );

$total_fuel = 0;
while ($line = fgets($fopen)) {
    $mass = (int) $line;
    $fuel = floor($mass / 3) - 2;
    $total_fuel+= $fuel;
}

fclose($fopen);

echo $total_fuel;
