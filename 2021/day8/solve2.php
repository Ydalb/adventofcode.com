<?php

$input = file(__DIR__ . '/input', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$input = array_map(function(string $line) {
    return explode(' | ', $line);
}, $input);

$sum = 0;

foreach ($input as $line) {

    [$wrong_signals, $output_values] = [explode(' ', $line[0]), explode(' ', $line[1])];

    usort($wrong_signals, function(string $a, string $b) {
        return strlen($a) <=> strlen($b);
    });

    $mapping = [];

    while (count($mapping) !== 10) {

        $iterate = $wrong_signals;

        foreach ($iterate as $i => $wrong_signal) {

            $wrong_signal = str_split($wrong_signal);

            $signal_length = count($wrong_signal);

            $found = false;

            switch ($signal_length) {
                case 2:
                    $mapping[1] = $wrong_signal;
                    $found  = true;
                    break;
                case 3:
                    $mapping[7] = $wrong_signal;
                    $found = true;
                    break;
                case 4:
                    $mapping[4] = $wrong_signal;
                    $found = true;
                    break;
                case 5:
                    if (isset($mapping[1]) && !isset($mapping[3])) {
                        if (count(array_intersect($mapping[1], $wrong_signal)) === 2) {
                            $mapping[3] = $wrong_signal;
                            $found = true;
                        }
                    } else if (isset($mapping[3]) && isset($mapping[9])) {
                        $tmp = array_unique(array_merge($wrong_signal, $mapping[1]));
                        sort($tmp);
                        sort($mapping[9]);
                        if ($tmp === $mapping[9]) {
                            $mapping[5] = $wrong_signal;
                        } else {
                            $mapping[2] = $wrong_signal;
                        }
                        $found = true;
                    }
                    break;
                case 6:
                    if (isset($mapping[3])) {
                        if (!isset($mapping[9]) && count(array_intersect($mapping[3], $wrong_signal)) === 5) {
                            $mapping[9] = $wrong_signal;
                            $found = true;
                        } else if (isset($mapping[9])) {
                            if (count(array_unique(array_merge($wrong_signal, $mapping[1]))) === 7) {
                                $mapping[6] = $wrong_signal;
                            } else {
                                $mapping[0] = $wrong_signal;
                            }
                            $found = true;
                        }
                    }
                    break;
                case 7:
                    $mapping[8] = $wrong_signal;
                    $found = true;
                    break;
            }

            if ($found) {
                unset($wrong_signals[$i]);
            }

        }

    }

    $output = '';
    foreach ($output_values as $output_value) {
        $output_value = str_split($output_value);
        sort($output_value);
        foreach ($mapping as $digit => $signal) {
            sort($signal);
            if ($signal === $output_value) {
                $output.= $digit;
                break;
            }
        }
    }

    $sum+= (int)$output;

}

echo '$sum=' . $sum . PHP_EOL;