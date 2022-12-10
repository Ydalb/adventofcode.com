<?php

class Day01 {

    static public function runOne() : string {

        $calories = self::input();

        return max($calories);

    }

    static public function runTwo() : string {

        $calories = self::input();

        rsort($calories);

        return $calories[0] + $calories[1] + $calories[2];

    }

    static private function input() : array {

        $lines = [];
        $i = 0;

        foreach (file(__DIR__ . '/input', FILE_IGNORE_NEW_LINES) as $line) {

            if (strlen($line) === 0) {
                $i++;
            }

            if (!isset($lines[$i])) {
                $lines[$i] = 0;
            }

            $lines[$i]+= intval($line);

        }

        return $lines;

    }

}

echo Day01::runOne() . PHP_EOL;
echo Day01::runTwo() . PHP_EOL;