<?php

$fopen = fopen( __DIR__ . '/input', 'r' );

$bad_instructions = [];
while ($line = fgets($fopen)) {
    $line = trim($line);

    $tmp = explode(' ', $line);
    $instruction = $tmp[0];
    $num = (int)$tmp[1];

    $bad_instructions[] = ['cmd' => $instruction, 'num' => $num, 'read' => false];

}

fclose($fopen);

while(true) {

    $instructions = generate_new_instructions($bad_instructions);

    $acc = 0;
    $index = 0;

    while (true) {

        if ($instructions[$index]['read'] === true) {
            echo "Instruction already done, generating new instructions set.\n";
            break;
        } else {
            $instructions[$index]['read'] = true;
        }
        switch ($instructions[$index]['cmd']) {
            case 'acc': $acc+= $instructions[$index]['num']; $index++; break;
            case 'jmp': $index+= $instructions[$index]['num']; break;
            case 'nop': $index++; break;
            default: echo "No such instruction " . var_export($instructions[$index], true); die;
        }

        if ($index === count($instructions)) {
            break 2;
        }

    }
}

echo $acc;

function generate_new_instructions(array $instructions) : array {
    static $last_index = 0;
    while ($last_index < count($instructions)) {
        $last_index++;
        if (in_array($cmd = $instructions[$last_index]['cmd'], ['nop', 'jmp'])) {
            $instructions[$last_index]['cmd'] = ($cmd === 'nop' ? 'jmp' : 'nop');
//            echo "Updating instruction $last_index\n";
            break;
        }
    }
//    echo md5(json_encode($instructions));
    return $instructions;
}

function dd() {
    var_dump(func_get_args());
    die;
}