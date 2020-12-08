<?php

$fopen = fopen( __DIR__ . '/input', 'r' );

$seat_ids = [];
while ($line = fgets($fopen)) {

    $row = substr($line, 0, 7);
    $column = substr($line, 7, 3);

    // to binary then to decimal
    $row = bindec(str_replace(['F', 'B'], [0, 1], $row));
    $column = bindec(str_replace(['L', 'R'], [0, 1], $column));

    $seat_ids[] = $row * 8 + $column;

}
fclose($fopen);

sort($seat_ids);

var_dump(array_diff(range(min($seat_ids),max($seat_ids)), $seat_ids));
