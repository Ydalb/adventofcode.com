<?php

$fopen = fopen( __DIR__ . '/input', 'r' );

$nums = [];
while ($line = fgets($fopen)) {
    $nums[] = (int)$line;
}
fclose($fopen);

for ($i = 0; $i < count($nums) - 1; ++$i) {
    for ($j = $i; $j < count($nums); ++$j) {
        if (($nums[$i] + $nums[$j]) === 2020) {
            echo $nums[$i] * $nums[$j];
            exit();
        }
    }
}
echo "Not found";