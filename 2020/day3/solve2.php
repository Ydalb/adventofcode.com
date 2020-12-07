<?php
$slopes = [
    ['x' => 1, 'y' => 1],
    ['x' => 3, 'y' => 1],
    ['x' => 5, 'y' => 1],
    ['x' => 7, 'y' => 1],
    ['x' => 1, 'y' => 2],
];
foreach ($slopes as $slope) {

    $fopen = fopen( __DIR__ . '/input', 'r' );

    $x = 0;
    $num_trees = 0;
    fgets($fopen);
    $line = null;

    while (true) {

        $y = $slope['y'];
        while ($y-- > 0) {
            $line = fgets($fopen);
        }
        $x+= $slope['x'];

        if (!$line) {
            break;
        }

        $line = str_split(trim($line));
        $pos = $line[$x % count($line)];
        if ($pos === '#') {
            ++$num_trees;
        }

    }

    echo $num_trees . PHP_EOL;

    fclose($fopen);

}