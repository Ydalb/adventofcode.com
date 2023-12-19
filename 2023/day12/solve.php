<?php

use AOC\Input;

require __DIR__ . '/../../collection.php';


class Day12 {

    static public function runOne() : int {
        return self::input(repeat: 1);
    }

    static public function runTwo() : int {
        return self::input(repeat: 5);
    }

    static public function input(int $repeat) : int {

        return (new Input(__DIR__ . '/input'))
            ->map(function(string $line) : array {
                return explode(' ', $line);
            })
            ->reduce(function(int $num_arrangements, array $line) use($repeat) {

                [$left, $right] = $line;

                $left = substr(str_repeat($left . '?', $repeat), 0, -1);
                $right = substr(str_repeat($right . ',', $repeat), 0, -1);

                $damaged_springs = array_map('intval', explode(',', $right));

                $count = self::recursive(springs: $left, damaged_springs: $damaged_springs);

                return $num_arrangements + $count;

            }, $carry = 0)
        ;

    }

    static private function recursive(string $springs, array $damaged_springs) : int {

        static $cache = [];
        $cache_key = $springs . '|' . json_encode($damaged_springs);
        if (array_key_exists($cache_key, $cache)) {
            return $cache[$cache_key];
        }

        if (count($damaged_springs) === 0) {
            if (str_contains($springs, '#')) {
                $return = 0;
            } else {
                $return = 1;
            }
        } else if (strlen($springs) === 0) {
            $return = 0;
        } else if (strlen($springs) < ($remaining = array_sum($damaged_springs) + count($damaged_springs) - 1)) {
            $return = 0;
        } else if ($springs[0] === '?') {
            $return = self::processDot($springs, $damaged_springs) + self::processHash($springs, $damaged_springs);
        } else if ($springs[0] === '.') {
            $return = self::processDot($springs, $damaged_springs);
        } else if ($springs[0] === '#') {
            $return = self::processHash($springs, $damaged_springs);
        } else {
            throw new \Exception("Unsupported char: {$springs[0]}");
        }

        $cache[$cache_key] = $return;

        return $return;

    }

    static private function processDot(string $springs, array $damaged_springs) : int {
        return self::recursive(substr($springs, 1), $damaged_springs);
    }

    static private function processHash(string $springs, array $damaged_springs) : int {
        if (!str_contains(substr($springs, 0, $damaged_springs[0]), '.') && ($springs[$damaged_springs[0]] ?? '') !== '#') {
            $springs = substr($springs, $damaged_springs[0] + 1);
            array_shift($damaged_springs);
            return self::recursive($springs, $damaged_springs);
        } else {
            return 0;
        }
    }

}

echo Day12::runOne() . PHP_EOL;
echo Day12::runTwo() . PHP_EOL;