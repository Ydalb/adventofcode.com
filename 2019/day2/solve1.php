<?php

$input = fgets(fopen( __DIR__ . '/input', 'r' ));

$opcodes = explode(',', $input);
$opcodes = array_map('intval', $opcodes);


echo run_opcodes($opcodes, 12, 2);

function run_opcodes($opcodes, $noun, $verb) {
    $opcodes[1] = $noun;
    $opcodes[2] = $verb;
    $position = 0;
    while ($opcodes[$position] !== 99) {
        $instruction = $opcodes[$position];
        $first_value_position = $opcodes[$position + 1];
        $second_value_position = $opcodes[$position + 2];
        $third_value_position = $opcodes[$position + 3];
        $first_value = $opcodes[$first_value_position];
        $second_value = $opcodes[$second_value_position];
        if ($instruction === 1) {
            $value = $first_value + $second_value;
        } else if ($instruction === 2) {
            $value = $first_value * $second_value;
        } else {
            throw new \Exception("Unknown instruction: {$instruction} at position {$position}");
        }
        $opcodes[$third_value_position] = $value;
        $position+= 4;
    }
    return $opcodes[0];
}

