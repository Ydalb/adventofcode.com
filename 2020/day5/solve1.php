<?php

$fopen = fopen( __DIR__ . '/input', 'r' );

$max_seat_id = 0;
while ($line = fgets($fopen)) {

    $row = substr($line, 0, 7);
    $column = substr($line, 7, 3);

    // to binary then to decimal
    $row = bindec(str_replace(['F', 'B'], [0, 1], $row));
    $column = bindec(str_replace(['L', 'R'], [0, 1], $column));

    if (($seat_id = $row * 8 + $column) > $max_seat_id) {
        $max_seat_id = $seat_id;
    }

}
fclose($fopen);

echo $max_seat_id;
