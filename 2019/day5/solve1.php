<?php

$input = fgets(fopen( __DIR__ . '/input', 'r' ));

$instructions = explode(',', $input);
$instructions = array_map('intval', $instructions);


echo run_instructions($instructions, 12, 2);

function run_instructions($instructions, $noun, $verb) {
    $instructions[1] = $noun;
    $instructions[2] = $verb;
    $position = 0;
    while (($instruction = $instructions[$position]) !== 99) {

        $opcode = get_opcode($instruction);

        $first_value_position = $instructions[$position + 1];
        $second_value_position = $instructions[$position + 2];
        $third_value_position = $instructions[$position + 3];
        $first_value = $instructions[$first_value_position];
        $second_value = $instructions[$second_value_position];

        switch ($opcode) {
            case 1:
                $value = get_value($instructions, $position + 1, get_parameter_mode($instruction, 1))
                    + get_value($instructions, $position + 2, get_parameter_mode($instruction, 2));
                set_value($instructions, $position + 3, $value);
                break;
            case 2:
                $value = get_value($instructions, $position + 1, get_parameter_mode($instruction, 1))
                    * get_value($instructions, $position + 2, get_parameter_mode($instruction, 2));
                set_value($instructions, $position + 3, $value);
                break;
            case 3:
                $value = $first_value;
//                $instructions[$fi]
                break;
            default:
                throw new \Exception("Unknown opcode: {$opcode} at position {$position}, instruction: {$instructions}");
        }
        $position+= 4;
    }
    return $instructions[0];
}

function get_opcode($instruction) {
    return intval(substr($instruction, -2));
}

function get_parameter_mode($instruction, $index) {
    $parameters_mode = str_split(substr($instruction, 0, -2));
    $parameters_mode = array_reverse($parameters_mode);
    return $parameters_mode[$index - 1] ?? 0;
}

function set_value(array &$instructions, int $position, int $value) {
    $instructions[$instructions[$position]] = $value;
}

function get_value(array $instructions, int $position, int $parameter_mode = 0) {
    switch ($parameter_mode) {
        case 0: return $instructions[$position];
        case 1: return $position;
        default: throw new \Exception("Unknown parameter mode {$parameter_mode}");
    }
}