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
    if ($passport['byr'] < 1920 || $passport['byr'] > 2002) {
        return false;
    }
    if ($passport['iyr'] < 2010 || $passport['iyr'] > 2020) {
        return false;
    }
    if ($passport['eyr'] < 2020 || $passport['eyr'] > 2030) {
        return false;
    }
    if (!preg_match('/(\d+)(cm|in)/', $passport['hgt'], $matches)) {
        return false;
    }
    if (!isset($matches[2])) {
        var_dump($passport);
        var_dump(preg_match('/(\d+)(cm|in)/', $passport['hgt'], $matches));
        die;
    }
    if ($matches[2] === 'cm') {
        if ($matches[1] < 150 || $matches[1] > 193) {
            return false;
        }
    } else {
        if ($matches[1] < 59 || $matches[1] > 76) {
            return false;
        }
    }
    if (!preg_match('/^#[0-9a-f]{6}$/', $passport['hcl'])) {
        return false;
    }
    if (!in_array($passport['ecl'], ['amb','blu','brn','gry','grn','hzl','oth'])) {
        return false;
    }
    if (!preg_match('/^[0-9]{9}$/', $passport['pid'])) {
        return false;
    }
    return true;
}