<?php

$file_handle = fopen( __DIR__ . '/input', 'r' );

$first_wire_paths = explode(',', fgets($file_handle));
$second_wire_paths = explode(',', fgets($file_handle));

fclose($file_handle);

$map = [];

foreach ([$first_wire_paths, $second_wire_paths] as $i => $paths) {
    $x = 0;
    $y = 0;
    $distance_so_far = 0;
    foreach ($paths as $path) {
        $direction = substr(trim($path), 0, 1);
        $distance = substr(trim($path), 1);
        for ($j = $distance; $j > 0; $j--) {
            ++$distance_so_far;
            switch ($direction) {
                case 'U':
                    --$y;
                    break;
                case 'D':
                    ++$y;
                    break;
                case 'L':
                    --$x;
                    break;
                case 'R':
                    ++$x;
                    break;
                default:
                    throw new \Exception("Invalid path {$path}");
            }
            if (!isset($map[$y][$x][$i])) {
                $map[$y][$x][$i] = $distance_so_far;
            }
        }
    }
}

$distance = PHP_INT_MAX;
foreach ($map as $x => $columns) {
    foreach ($columns as $y => $values) {
        if (count($values) === 2) {
            $distance = min($values[0] + $values[1], $distance);
        }
    }
}
echo $distance;
