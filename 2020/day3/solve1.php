<?php

$fopen = fopen( __DIR__ . '/input', 'r' );

$x = 0;
$y = 0;
$num_trees = 0;
fgets($fopen);
while ($line = fgets($fopen)) {

    $line = str_split(trim($line));

    $x+= 3;

    $pos = $line[$x % count($line)];
    echo "\$x=$x \$y=$y pos=$pos\n";
    if ($pos === '#') {
        ++$num_trees;
    }


}
fclose($fopen);

echo $num_trees;