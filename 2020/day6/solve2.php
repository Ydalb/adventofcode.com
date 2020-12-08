<?php

$fopen = fopen( __DIR__ . '/input', 'r' );

$answers = [];
$sum = 0;
while ($line = fgets($fopen)) {
    $line = trim($line);
    if ($line === '') {
        $sum+= count_answer($answers);
        $answers = [];
    } else {
        $answers[] = $line;
    }
}

$sum+= count_answer($answers);

fclose($fopen);
echo $sum;

function count_answer(array $answers) {
    foreach($answers as &$answer) {
        $answer = str_split($answer);
    }
    if (count($answers) > 1) {
        return count(array_intersect(...$answers));
    } else {
        return count($answers[0]);
    }
}