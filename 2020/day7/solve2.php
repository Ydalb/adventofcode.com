<?php

$fopen = fopen( __DIR__ . '/input', 'r' );

$relations = [];
$shiny_count = 0;
while ($line = fgets($fopen)) {
    $line = trim($line);
    $tmp = explode(' bags contain ', $line);
    $container = $tmp[0];
    // striped plum bags contain 4 dark fuchsia bags, 4 dotted indigo bags.
    preg_match_all('/((?P<count>\d+) )?(?P<type>\w+ \w+) bags?/', $tmp[1], $matches, PREG_SET_ORDER);
    foreach ($matches as $match) {
        if ($match['type'] !== 'no other') {
            $relations[$container][$match['type']] = $match['count'];
        }
    }
}

fclose($fopen);

echo count_bag('shiny gold', $relations) - 1;

function count_bag(string $looked_bag, array $relations) {
    $count = 1;
    if (isset($relations[$looked_bag])) {
        foreach ($relations[$looked_bag] as $bag_type => $num_bags) {
            $count+= $num_bags * count_bag($bag_type, $relations);
        }
    }
    return $count;
}

function dd() {
    var_dump(func_get_args());
    die;
}