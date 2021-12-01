<?php

$fopen = fopen( __DIR__ . '/input', 'r' );

$measurements = [];
while ($line = fgets($fopen)) {
    $measurements[] = (int)$line;
}
fclose($fopen);

$num_increased = 0;

for ($i = 1; $i <= count($measurements) - 1; $i++) {
    if ($measurements[$i] > $measurements[$i-1]) {
        $num_increased++;
    }
}

echo $num_increased . PHP_EOL;