<?php

$fopen = fopen( __DIR__ . '/input', 'r' );

$num_valid_password = 0;
while ($line = fgets($fopen)) {
    $tmp = explode(':', $line);
    $policy = trim($tmp[0]);
    $password = trim($tmp[1]);

    preg_match('/(\d+)-(\d+) ([a-z])/', $policy, $matches);
    $count = substr_count($password, $matches[3]);

    if ($count >= $matches[1] && $count <= $matches[2]) {
        ++$num_valid_password;
    }

}
fclose($fopen);

echo $num_valid_password;