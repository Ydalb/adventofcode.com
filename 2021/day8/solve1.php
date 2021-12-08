<?php

$input = file(__DIR__ . '/input', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$input = array_map(function(string $line) {
    return explode(' | ', $line);
}, $input);

$num_basic_digits = 0;
foreach ($input as $line) {
    [, $output_value] = $line;
    foreach (explode(' ', $output_value) as $value) {
        $length = strlen($value);
        switch($length) {
            case 2: //1
            case 4: //4
            case 3: //7
            case 7: //8
                $num_basic_digits++;
                break;
        }
    }
}

echo $num_basic_digits . PHP_EOL;