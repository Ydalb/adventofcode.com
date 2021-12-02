<?php

$horizontal = 0;
$depth = 0;
$aim = 0;

foreach (file(__DIR__ . '/input', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
    $line = trim($line);
    list($instruction, $value) = explode(' ', $line);
    switch ($instruction) {
        case 'forward':$horizontal+= $value; $depth+= $aim * $value; break;
        case 'down': $aim+= $value; break;
        case 'up': $aim-= $value; break;
    }
}

echo $horizontal * $depth . PHP_EOL;