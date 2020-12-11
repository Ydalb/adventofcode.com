<?php

$fopen = fopen( __DIR__ . '/input', 'r' );

$instructions = [];
while ($line = fgets($fopen)) {
    $line = trim($line);

    $tmp = explode(' ', $line);
    $instruction = $tmp[0];
    $num = (int)$tmp[1];

    $instructions[] = ['cmd' => $instruction, 'num' => $num, 'read' => false];

}

fclose($fopen);

$acc = 0;
$index = 0;
while(true) {

    if ($instructions[$index]['read'] === true) {
        echo "Instruction already done " . var_export($instructions[$index], true);
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
}

echo $acc;

function dd() {
    var_dump(func_get_args());
    die;
}