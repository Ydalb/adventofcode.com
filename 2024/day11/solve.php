<?php

use AOC\Input;

require __DIR__ . '/../../collection.php';


class Day11 {

    static public function runOne() : int {

        $sum = 0;
        foreach (self::input() as $stone) {
            $sum+= self::blink($stone, 25, 0);
        }

        return $sum;

    }

    static public function runTwo() : int {

        $sum = 0;
        foreach (self::input() as $stone) {
            $sum+= self::blink($stone, 75, 0);
        }

        return $sum;

    }

    static private function blink(int $stone, int $max_iterations, int $current_iteration) : int {

        static $cache = [];

        $cache_key = $stone . ':' . ($max_iterations - $current_iteration);

        if (isset($cache[$cache_key])) {

            return $cache[$cache_key];

        } else if ($current_iteration < $max_iterations) {

            if ($stone == 0) {

                $stone = 1;
                $cache[$cache_key] = self::blink($stone, $max_iterations, $current_iteration + 1);
                return $cache[$cache_key];

            } elseif (strlen((string)$stone) % 2 == 0) {

                $src_stone = (string)$stone;
                $mid = strlen($src_stone) / 2;
                $stone_1 = intval(substr($src_stone, 0, $mid));
                $stone_2 = intval(substr($src_stone, $mid));

                $cache[$cache_key] = self::blink($stone_1, $max_iterations, $current_iteration + 1)
                    + self::blink($stone_2, $max_iterations, $current_iteration + 1)
                ;

                return $cache[$cache_key];

            } else {

                $cache[$cache_key] = self::blink($stone * 2024, $max_iterations, $current_iteration + 1);

                return $cache[$cache_key];

            }

        } else {

            return 1;

        }

    }

    static private function input() : array {

        $data = (new Input(__DIR__ . '/input'))->toArray()[0];

        return array_map('intval', explode(' ', $data));

    }

}

echo Day11::runOne() . PHP_EOL;
echo Day11::runTwo() . PHP_EOL;