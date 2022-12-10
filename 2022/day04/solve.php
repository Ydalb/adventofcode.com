<?php

class Day04 {

    static public function runOne() : int {

        $num_useless_pairs = 0;

        foreach (self::input() as [$section1, $section2]) {

            $overlap = array_intersect($section1, $section2);

            if (count($overlap) === count($section1) || count($overlap) === count($section2)) {
                $num_useless_pairs++;
            }

        }

        return $num_useless_pairs;

    }

    static public function runTwo() : int {

        $num_useless_pairs = 0;

        foreach (self::input() as [$section1, $section2]) {

            $overlap = array_intersect($section1, $section2);

            if (count($overlap)) {
                $num_useless_pairs++;
            }

        }

        return $num_useless_pairs;

    }

    static private function input() : array {

        $assignments = [];

        foreach (file(__DIR__ . '/input', FILE_IGNORE_NEW_LINES) as $line) {

            [$left,$right] = explode(',', $line);
            $assignments[] = [
                range(...explode('-', $left)),
                range(...explode('-', $right))
            ];

        }

        return $assignments;

    }

}

echo Day04::runOne() . PHP_EOL;
echo Day04::runTwo() . PHP_EOL;