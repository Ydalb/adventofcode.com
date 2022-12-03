<?php

namespace AOC;

require __DIR__ . '/../../collection.php';

echo array_sum(
    array_map(
        fn($l) => eval('$a = ord($l[0]) - ord("A"); $b = ord($l[2]) - ord("X"); return 1 + $b + (($b - $a + 4) % 3) * 3;'),
        file(__DIR__ . '/input', FILE_IGNORE_NEW_LINES)
    )
);