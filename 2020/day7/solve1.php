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
        // On stock la relation contenant => contenu, si contenu différent de 'no other'
        // J'en profite pour compter le nombre de sacs que ça peut contenir, des fois que ce soit demandé dans l'exo 2
        if ($match['type'] !== 'no other') {
            $relations[$container][$match['type']] = $match['count'];
        }
    }
}

fclose($fopen);

echo count(count_bag('shiny gold', $relations));

function count_bag(string $looked_bag, array $relations, array &$bags = []) {
    foreach ($relations as $bag => $content) {
        if (isset($content[$looked_bag]) && !in_array($bag, $bags)) {
            echo "{$bag} => $looked_bag\n";
            $bags[] = $bag;
            count_bag($bag, $relations, $bags);
        }
    }
    return $bags;
}

function dd() {
    var_dump(func_get_args());
    die;
}