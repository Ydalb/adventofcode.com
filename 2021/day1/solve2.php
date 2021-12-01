<?php

$fopen = fopen( __DIR__ . '/input', 'r' );

$measurements = [];
while ($line = fgets($fopen)) {
    $measurements[] = (int)$line;
}
fclose($fopen);

$num_increased = 0;

for ($i = 0; $i < count($measurements) - 3; $i++) {
    $measurement_1 = $measurements[$i] + $measurements[$i+1] + $measurements[$i+2];
    $measurement_2 = $measurements[$i+1] + $measurements[$i+2] + $measurements[$i+3];
    if ($measurement_2 > $measurement_1) {
        $num_increased++;
    }
}

echo $num_increased . PHP_EOL;