<?php

$file_handle = fopen( __DIR__ . '/input', 'r' );

$range = explode('-', fgets($file_handle));

fclose($file_handle);

$valid_password = 0;
for ($password = $range[0]; $password < $range[1]; $password++) {
    if (is_valid_password((string)$password)) {
        ++$valid_password;
        echo "{$password} is valid\n";
    }
}

echo $valid_password;


function is_valid_password(string $password) {
    $password = str_split($password);
    // six-digit number.
    if (count($password) !== 6) {
        return false;
    }
    // Going from left to right, the digits never decrease; they only ever increase or stay the same
    $password_copy = $password;
    sort($password_copy);
    if ($password_copy !== $password) {
        return false;
    }
    // Two adjacent digits are the same
    for ($i = 0; $i < count($password) - 1; $i++) {
        $repeated_numbers = 0;
        while ($i < (count($password) - 1) && $password[$i] === $password[$i + 1]) {
            ++$i;
            ++$repeated_numbers;
        }
        if ($repeated_numbers === 1) {
            return true;
        }
    }
    return false;
}