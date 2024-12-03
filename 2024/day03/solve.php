<?php

use AOC\Input;

require __DIR__ . '/../../collection.php';


class Day02 {

    static public function runOne() : int {
        return self::input()
            ->reduce(function(int $sum, string $section) {
                $sum+= self::multiply($section);
                return $sum;
            }, $sum = 0)
        ;
    }

    static public function runTwo() : int {

        $sections = explode('don\'t()', self::input()->implode(''));
        $sum = 0;

        $first = array_shift($sections);
        $sum += self::multiply($first);

        foreach ($sections as $section) {
            $does = explode('do()', $section);
            $dont = array_shift($does);
            $memory = join('do()', $does);
            if (strlen($memory)) {
                $sum+= self::multiply($memory);
            }
        }

        return $sum;

    }

    static private function multiply(string $data) : int {
        $sum = 0;
        preg_match_all('#mul\((\d{1,3}),(\d{1,3})\)#', $data, $matches);
        if (count($matches[1])) {
            for ($i = 0; $i < count($matches[1]); $i++) {
                $sum+= $matches[1][$i] * $matches[2][$i];
            }
        }
        return $sum;
    }

    static private function input() : Input {
        return (new Input(__DIR__ . '/input'));
    }

}

echo Day02::runOne() . PHP_EOL;
echo Day02::runTwo() . PHP_EOL;