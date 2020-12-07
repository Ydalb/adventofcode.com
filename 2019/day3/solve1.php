<?php

$file_handle = fopen( __DIR__ . '/input', 'r' );

$first_wire_paths = explode(',', fgets($file_handle));
$second_wire_paths = explode(',', fgets($file_handle));

fclose($file_handle);

$map = [];

foreach ([$first_wire_paths, $second_wire_paths] as $i => $paths) {
    $x = 0;
    $y = 0;
    foreach ($paths as $path) {
        $direction = substr(trim($path), 0, 1);
        $distance = substr(trim($path), 1);
        for ($j = $distance; $j > 0; $j--) {
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
            $map[$y][$x][$i] = true;
        }
    }
}

$distance = PHP_INT_MAX;
foreach ($map as $x => $columns) {
    foreach ($columns as $y => $values) {
        if (count($values) === 2) {
            var_dump($values);
          $distance = min(abs($x) + abs($y), $distance);
        }
    }
}
echo $distance;
