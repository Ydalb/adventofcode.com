<?php

/*
 * A/X: Rock     1pt
 * B/Y: Paper    2pt
 * C/Z: Scissors 3pt
 *
 * Lost: 0pt
 * Draw: 3pt
 * Win: 6pt
 */
class Day02 {

    const WHO_WINS = [
        'A' => 'C',
        'B' => 'A',
        'C' => 'B',
    ];

    const POINTS = [
        'A' => 1,
        'B' => 2,
        'C' => 3,
    ];

    static public function runOne() : int {

        $total = 0;

        foreach (self::input() as [$him, $me]) {
            $me = str_replace(['X', 'Y', 'Z'], ['A', 'B', 'C'], $me);
            if (self::WHO_WINS[$me] === $him) {
                $total+= self::POINTS[$me] + 6;
            } else if ($me === $him) {
                $total+= self::POINTS[$me] + 3;
            } else if (self::WHO_WINS[$him] === $me) {
                $total+= self::POINTS[$me] + 0;
            } else {
                throw new \Exception("Unhandled versus {$him} vs {$me}");
            }
        }

        return $total;

    }

    static public function runTwo() : int {

        $total = 0;

        foreach (self::input() as [$him, $what_should_I_do]) {

            if ($what_should_I_do === 'X') { //lose
                $total+= self::POINTS[self::WHO_WINS[$him]] + 0;
            } else if ($what_should_I_do === 'Y') { //draw
                $total+= self::POINTS[$him] + 3;
            } else if ($what_should_I_do === 'Z') { //win
                $total+= self::POINTS[array_search($him, self::WHO_WINS)] + 6;
            } else {
                throw new \Exception("Unhandled versus {$him} vs {$what_should_I_do}");
            }

        }

        return $total;

    }

    static private function input() : array {

        $rounds = [];

        foreach (file(__DIR__ . '/input', FILE_IGNORE_NEW_LINES) as $line) {
            $rounds[] = explode(' ', $line);
        }

        return $rounds;

    }

}

echo Day02::runOne() . PHP_EOL;
echo Day02::runTwo() . PHP_EOL;