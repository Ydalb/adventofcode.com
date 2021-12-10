<?php

$input = file(__DIR__ . '/input', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$available_opening_tag = ['(', '{', '[', '<'];
$available_closing_tag = [')', '}', ']', '>'];

$points  = [
    ')' => 1,
    ']' => 2,
    '}' => 3,
    '>' => 4,
];

$sum_points = [];

foreach ($input as $line) {

    $tags = str_split($line);

    $opened_chunks = [];

    foreach ($tags as $tag) {

        if (($index_closed = array_search($tag, $available_closing_tag)) !== false) {
            $last_opened_tag = array_pop($opened_chunks);
            $last_opened_tag_index = array_search($last_opened_tag, $available_opening_tag);
            if ($index_closed !== $last_opened_tag_index) {
                $opened_chunks = [];
                break; // Syntax error, line ignored
            }
        } else if (in_array($tag, $available_opening_tag)) {
            $opened_chunks[] = $tag;
        } else {
            $opened_chunks = [];
            break; // Tag not support, line ignored
        }

    }

    if (count($opened_chunks) > 0) {
        echo "Incomplete line: {$line}";
        $complete_tags = [];
        $sum = 0;
        do {
            $sum*= 5;
            $last_opened_tag = array_pop($opened_chunks);
            $correct_closed_tag = $available_closing_tag[array_search($last_opened_tag, $available_opening_tag)];
            $sum+= $points[$correct_closed_tag];
        } while (count($opened_chunks) > 0);

        $sum_points[] = $sum;

        echo ' ' . join('', $complete_tags) . ' ' . $sum . ' points' . PHP_EOL;

    }

}

sort($sum_points);

echo 'Middle score: ' . $sum_points[floor(count($sum_points) / 2)] . PHP_EOL;