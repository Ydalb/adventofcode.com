<?php

$input = file(__DIR__ . '/input', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$paths = [];

foreach ($input as $line) {

    [$cave_from, $cave_to] = explode('-', $line);

    if (!isset($paths[$cave_from])) {
        $paths[$cave_from] = [];
    }
    $paths[$cave_from][] = $cave_to;

    if ($cave_from === 'start' || $cave_to === 'end') {
        continue;
    }
    if (!isset($paths[$cave_to])) {
        $paths[$cave_to] = [];
    }
    $paths[$cave_to][] = $cave_from;
}

$valid_paths = [];

browse_caves($paths, $current_path = ['start'], $valid_paths);

//var_dump($valid_paths);
foreach ($valid_paths as $valid_path) {
    echo join('-', $valid_path) . PHP_EOL;
}
echo '$valid_paths=' . count($valid_paths) . PHP_EOL;

function browse_caves(array $paths, array $current_path, array &$valid_paths) {

    $last_cave = $current_path[array_key_last($current_path)];

    foreach ($paths[$last_cave] as $cave) {

        if ($cave === 'start') {
            continue;
        }

        if (
            ctype_lower($cave)
        ) {
            $tmp = array_filter($current_path, function(string $value) { return ctype_lower($value); });
            $tmp = array_filter(array_count_values($tmp), function(int $value) {
                return $value >= 2;
            });
            if (count($tmp) >= 1) {
                if (in_array($cave, $current_path, $strict = true)) {
//                echo "{$cave} (or another cave) is already found twice in the path " . join('-', $current_path) . ", ignoring\n";
                    continue;
                }
            }
        }

//        echo "{$cave} is not in the current path " . join('-', $current_path) . ", adding\n";

        if ($cave === 'end') {
            $valid_paths[] = array_merge($current_path, [$cave]);
        } else {
            browse_caves($paths, array_merge($current_path, [$cave]), $valid_paths);
        }

    }

}