<?php

use AOC\Input;

require __DIR__ . '/../../collection.php';


class Day09 {

    static public function runOne() {

        return self::input()

            ->reduce(function(int $carry, array $sequences) {

                for ($i = count($sequences) - 2; $i >= 0; $i--) {
                    $sequences[$i][] = end($sequences[$i + 1]) + end($sequences[$i]);
                }

                return $carry+= end($sequences[0]);

            }, $carry = 0)
        ;

    }

    static public function runTwo() {

        return self::input()

            ->reduce(function(int $carry, array $sequences) {

                for ($i = count($sequences) - 2; $i >= 0; $i--) {
                    array_unshift(
                        $sequences[$i],
                        reset($sequences[$i]) - reset($sequences[$i + 1])
                    );
                }

                return $carry+= reset($sequences[0]);

            }, $carry = 0)
        ;

    }

    static public function input() : Input {

        return (new Input(__DIR__ . '/input'))

            ->map(function(string $line) {

                $sequences = [
                    array_map('intval', explode(' ', $line))
                ];

                do {
                    $last = end($sequences);
                    $sequence = [];
                    for ($i = 1; $i < count($last); $i++) {
                        $sequence[] = $last[$i] - $last[$i - 1];
                    }
                    $sequences[] = $sequence;
                } while (count(array_filter($sequence)) > 0);

                return $sequences;

            })
        ;

    }

}

echo Day09::runOne() . PHP_EOL;
echo Day09::runTwo() . PHP_EOL;