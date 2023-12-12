<?php

use AOC\Input;

require __DIR__ . '/../../collection.php';


class Day12 {

    static public function runOne() : int {

        $num_arrangements = 0;
        self::input()
            ->each(function(array $line) use(&$num_arrangements) {
                [$left, $right] = $line;

                $combinations = [];
                self::generateCombination(data: $left, index: 0, current: '', result: $combinations);
                echo "LINE={$left}\n";

                $pattern = [];
                foreach (explode(',', $right) as $count) {
                    $pattern[] = str_repeat('#', $count);
                }

                foreach ($combinations as $combination) {
                    $combination = preg_replace('/\.+/', '.', $combination);
                    $combination = trim($combination, '.');
                    $combination = explode('.', $combination);
//                    echo "TEST: " . json_encode($combination) . ' vs ' . json_encode($pattern) . PHP_EOL;
                    if ($combination == $pattern) {
//                        echo "MATCH!! " . json_encode($combination) . ' vs ' . json_encode($pattern) . PHP_EOL;
                        $num_arrangements++;
                    }
                }

//                echo "COUNT={$num_arrangements}" . PHP_EOL;

            })
        ;

        return $num_arrangements;

    }

    static public function runTwo() : int {

        $num_arrangements = 0;
        self::input()
            ->each(function(array $line) use(&$num_arrangements) {
                [$left, $right] = $line;

                $combinations = [];
                self::generateCombination(data: $left, index: 0, current: '', result: $combinations);
                echo "LINE={$left}\n";

                $pattern = [];
                foreach (explode(',', $right) as $count) {
                    $pattern[] = str_repeat('#', $count);
                }

                foreach ($combinations as $combination) {
                    $combination = preg_replace('/\.+/', '.', $combination);
                    $combination = trim($combination, '.');
                    $combination = explode('.', $combination);
                    //                    echo "TEST: " . json_encode($combination) . ' vs ' . json_encode($pattern) . PHP_EOL;
                    if ($combination == $pattern) {
                        //                        echo "MATCH!! " . json_encode($combination) . ' vs ' . json_encode($pattern) . PHP_EOL;
                        $num_arrangements++;
                    }
                }

                //                echo "COUNT={$num_arrangements}" . PHP_EOL;

            })
        ;

        return $num_arrangements;

    }

    static private function generateCombination(string $data, int $index = 0, string $current = '', array &$result = []) : void {
        if ($index === strlen($data)) {
            $result[] = $current;
            return;
        }
        if ($data[$index] === '?') {
            self::generateCombination($data, $index + 1, $current . '.', $result);
            self::generateCombination($data, $index + 1, $current . '#', $result);
        } else {
            self::generateCombination($data, $index + 1, $current . $data[$index], $result);
        }
    }

    static public function input() : Input {

        return (new Input(__DIR__ . '/input'))
            ->map(function(string $line) : array {
                return explode(' ', $line);
            })
        ;

    }

}

//echo Day12::runOne() . PHP_EOL;
echo Day12::runTwo() . PHP_EOL;