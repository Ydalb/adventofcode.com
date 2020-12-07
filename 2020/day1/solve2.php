<?php

$fopen = fopen( __DIR__ . '/input', 'r' );

$nums = [];
while ($line = fgets($fopen)) {
    $nums[] = (int)$line;
}
fclose($fopen);

for ($i = 0; $i < count($nums) - 2; ++$i) {
    for ($j = $i; $j < count($nums) - 1; ++$j) {
        for ($k = $i; $k < count($nums); ++$k) {
            if (($nums[$i] + $nums[$j] + $nums[$k]) === 2020) {
                echo $nums[$i] * $nums[$j] * $nums[$k];
                exit();
            }
        }
    }
}
echo "Not found";