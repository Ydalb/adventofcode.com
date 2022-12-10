<?php

class Day06 {

    static public function runOne() : int {

        return self::run(4);

    }

    static public function runTwo() : int {

        return self::run(14);

    }

    static private function run(int $num_distinct_chars) : int {

        $input = self::input();
        for ($i = 0; $i < count($input); $i++) {
            $last_four = array_slice($input, $i, $num_distinct_chars);
            if (count(array_unique($last_four)) === $num_distinct_chars) {
                return $i + $num_distinct_chars;
            }
        }

        return 0;

    }

    static private function input() : array {

        return str_split(current(file(__DIR__ . '/input', FILE_IGNORE_NEW_LINES)));

    }

}

echo Day06::runOne() . PHP_EOL;
echo Day06::runTwo() . PHP_EOL;