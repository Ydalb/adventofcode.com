<?php

use AOC\Input;

require __DIR__ . '/../../collection.php';


class Day02 {

    static public function runOne() : int {

        $bag = [
            'red' => 12,
            'green' => 13,
            'blue' => 14,
        ];

        return self::input()
            ->reduce(function(int $carry, string $line) use($bag) : int {
                preg_match('/Game (\d+):(.+)/', $line, $matches);
                $game_id = (int)$matches[1];
                $playable = true;
                foreach (explode(';', $matches[2]) as $set) {
                    foreach (explode(',', $set) as $subset) {
                        [$num, $color] = explode(' ', trim($subset));
                        if ($num > $bag[$color]) {
                            $playable = false;
                            break 2;
                        }
                    }
                }
                if ($playable) {
                    $carry+= $game_id;
                }
                return $carry;
            }, $count = 0)
        ;

    }

    static public function runTwo() : int {

        return self::input()
            ->reduce(function(int $carry, string $line) : int {
                preg_match('/Game (\d+):(.+)/', $line, $matches);
                $min = [];
                foreach (explode(';', $matches[2]) as $set) {
                    foreach (explode(',', $set) as $subset) {
                        [$num, $color] = explode(' ', trim($subset));
                        if (!isset($min[$color]) || $num > $min[$color]) {
                            $min[$color] = (int)$num;
                        }
                    }
                }
                $carry+= array_product($min);
                return $carry;
            }, $count = 0)
        ;

    }

    static private function input() : Input {

        return (new Input(__DIR__ . '/input'));

    }

}

echo Day02::runOne() . PHP_EOL;
echo Day02::runTwo() . PHP_EOL;