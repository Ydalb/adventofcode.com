<?php

use AOC\Input;

class Day03 {

    static public function runOne() : int {

        return self::input(
            callable: function(array $adjacent_parts) : int {
                return array_sum($adjacent_parts);
            },
            gear_regexp: '/[^.[0-9]/'
        );

    }

    static public function runTwo() : int {

        return self::input(
            callable: function(array $adjacent_parts) : int {
                if (count($adjacent_parts) === 2) {
                    return array_product($adjacent_parts);
                } else {
                    return 0;
                }
            },
            gear_regexp: '/[*]/'
        );

    }

    static private function input(callable $callable, string $gear_regexp) : int {

        $data = file(__DIR__ . '/input', FILE_IGNORE_NEW_LINES);
        $num_lines = count($data);

        $sum = 0;

        for ($i = 0; $i < $num_lines; $i++) {

            if (preg_match_all($gear_regexp, $data[$i], $matches_gear, PREG_OFFSET_CAPTURE) > 0) {

                foreach ($matches_gear[0] as [$gear, $gear_start]) {

                    $adjacent_parts = [];

                    $gear_end = (int)$gear_start + strlen($gear);

                    for ($j = -1; $j <= 1; $j++) {
                        $line = $data[$i + $j] ?? null;
                        if ($line === null) {
                            continue;
                        }
                        if (preg_match_all('/[[0-9]+/', $line, $matches_parts, PREG_OFFSET_CAPTURE)) {
                            foreach ($matches_parts[0] as [$part, $part_start]) {
                                $part_end = (int)$part_start + strlen($part);
                                if ($part_end > $gear_start - 1 && $part_start < $gear_end + 1) {
                                    $adjacent_parts[] = $part;
                                }
                            }
                        }
                    }

                    $sum+= $callable($adjacent_parts);

                }

            }
        }

        return $sum;

    }

}

echo Day03::runOne() . PHP_EOL;
echo Day03::runTwo() . PHP_EOL;