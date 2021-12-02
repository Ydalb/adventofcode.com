<?php

$horizontal = 0;
$depth = 0;

foreach (file(__DIR__ . '/input', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
    $line = trim($line);
    list($instruction, $value) = explode(' ', $line);
    switch ($instruction) {
        case 'forward': $horizontal+= $value; break;
        case 'down': $depth+= $value; break;
        case 'up': $depth-= $value; break;
    }
}

echo $horizontal * $depth . PHP_EOL;