<?php

$input = file(__DIR__ . '/input', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$available_opening_tag = ['(', '{', '[', '<'];
$available_closing_tag = [')', '}', ']', '>'];

$points  = [
    ')' => 3,
    ']' => 57,
    '}' => 1197,
    '>' => 25137,
];

$sum_points = 0;

foreach ($input as $line) {
    $tags = str_split($line);

    $opened_chunks = [];

    foreach ($tags as $tag) {

        if (($index_closed = array_search($tag, $available_closing_tag)) !== false) {
            $last_opened_tag = array_pop($opened_chunks);
            $last_opened_tag_index = array_search($last_opened_tag, $available_opening_tag);
            if ($index_closed !== $last_opened_tag_index) {
                $correct_closed_tag = $available_closing_tag[array_search($last_opened_tag, $available_opening_tag)];
                echo "Error on line: {$line} Expected {$correct_closed_tag}, but found {$tag} instead\n";
                $sum_points+= $points[$tag];
            }
        } else if (in_array($tag, $available_opening_tag)) {
            $opened_chunks[] = $tag;
        } else {
            echo "Tag {$tag} not supported, line: {$line}\n";
        }

    }

    if (count($opened_chunks) > 0) {
        // line incomplete
        echo "Incomplete line: {$line}\n";
    }

}

echo '$sum_points=' . $sum_points . PHP_EOL;