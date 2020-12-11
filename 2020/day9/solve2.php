<?php

$fopen = fopen( __DIR__ . '/input', 'r' );

$numbers = [];
while ($line = fgets($fopen)) {
    $numbers[] = (int)$line;
}

fclose($fopen);

$invalid_number = 1492208709;
//$invalid_number = 127;

for ($i = 0; $i < count($numbers) - 1; $i++) {
    $sum = [$numbers[$i]];
    $j = $i + 1;
    do {
        $sum[] = $numbers[$j];
        $tmp = array_sum($sum);
        if ($tmp > $invalid_number) {
            break;
        } else if ($tmp == $invalid_number) {
            echo min($sum) + max($sum);
            exit();
        }
    } while ($j++);

}

function dd() {
    var_dump(func_get_args());
    die;
}