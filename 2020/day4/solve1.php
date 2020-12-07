<?php

$fopen = fopen( __DIR__ . '/input', 'r' );

$num_valid_passports = 0;

while (true) {
    $passport = [];
    $count_blank_lines = 0;
    while (($line = fgets($fopen)) !== false) {
        $line = trim($line);
        if ($line === '') {
            break;
        }
        $keys_values = explode(' ', trim($line));
        foreach ($keys_values as $key_value) {
            $tmp = explode(':', $key_value);
            $passport[$tmp[0]] = $tmp[1];
        }
    }

    if (valid_passport($passport)) {
        $num_valid_passports++;
    }

    if ($line === false) {
        break;
    }

}
fclose($fopen);

echo $num_valid_passports;

function valid_passport(array $passport) : bool {
    if (count(array_keys($passport)) < 7) {
        return false;
    }
    if (count(array_keys($passport)) === 7 && isset($passport['cid'])) {
        return false;
    }
    return true;
}