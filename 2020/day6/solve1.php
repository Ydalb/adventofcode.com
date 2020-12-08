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
    $cumulative_answers = [];
    foreach($answers as $answer) {
        $cumulative_answers = array_merge($cumulative_answers, str_split($answer));
    }
    return count(array_unique($cumulative_answers));
}