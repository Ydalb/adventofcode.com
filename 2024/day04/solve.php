<?php

use AOC\Input;

require __DIR__ . '/../../collection.php';


class Day04 {

    static public function runOne() : int {

        $data = self::input()->toArray();

        $sum = 0;
        for ($y = 0; $y < count($data); $y++) {
            for ($x = 0; $x < count($data[$y]); $x++) {

                if ($data[$y][$x] === 'X') {

                    $words = [];
                    $words[] = $data[$y][$x] //right
                        . ($data[$y][$x + 1] ?? '')
                        . ($data[$y][$x + 2] ?? '')
                        . ($data[$y][$x + 3] ?? '')
                    ;
                    $words[] = $data[$y][$x] //bottom
                        . ($data[$y + 1][$x] ?? '')
                        . ($data[$y + 2][$x] ?? '')
                        . ($data[$y + 3][$x] ?? '')
                    ;
                    $words[] = $data[$y][$x] //top
                        . ($data[$y - 1][$x] ?? '')
                        . ($data[$y - 2][$x] ?? '')
                        . ($data[$y - 3][$x] ?? '')
                    ;
                    $words[] = $data[$y][$x] //left
                        . ($data[$y][$x - 1] ?? '')
                        . ($data[$y][$x - 2] ?? '')
                        . ($data[$y][$x - 3] ?? '')
                    ;
                    $words[] = $data[$y][$x] //top-right
                        . ($data[$y + 1][$x + 1] ?? '')
                        . ($data[$y + 2][$x + 2] ?? '')
                        . ($data[$y + 3][$x + 3] ?? '')
                    ;
                    $words[] = $data[$y][$x] //top-left
                        . ($data[$y + 1][$x - 1] ?? '')
                        . ($data[$y + 2][$x - 2] ?? '')
                        . ($data[$y + 3][$x - 3] ?? '')
                    ;
                    $words[] = $data[$y][$x] //bottom-right
                        . ($data[$y - 1][$x + 1] ?? '')
                        . ($data[$y - 2][$x + 2] ?? '')
                        . ($data[$y - 3][$x + 3] ?? '')
                    ;
                    $words[] = $data[$y][$x] //bottom-left
                        . ($data[$y - 1][$x - 1] ?? '')
                        . ($data[$y - 2][$x - 2] ?? '')
                        . ($data[$y - 3][$x - 3] ?? '')
                    ;
                    $count_values = array_count_values($words);
                    $sum+= ($count_values['XMAS'] ?? 0);
                }

            }
        }

        return $sum;

    }

    static public function runTwo() : int {

        $data = self::input()->toArray();

        $sum = 0;
        for ($y = 0; $y < count($data); $y++) {
            for ($x = 0; $x < count($data[$y]); $x++) {

                if ($data[$y][$x] === 'A') {

                    $words = [];
                    $words[] = ($data[$y - 1][$x - 1] ?? '') //top-left bottom-right
                        . $data[$y][$x]
                        . ($data[$y + 1][$x + 1] ?? '')
                    ;
                    $words[] = ($data[$y + 1][$x - 1] ?? '') //bottom-left top-right
                        . $data[$y][$x]
                        . ($data[$y - 1][$x + 1] ?? '')
                    ;
                    $words[] = ($data[$y + 1][$x + 1] ?? '') //bottom-right top-left
                        . $data[$y][$x]
                        . ($data[$y - 1][$x - 1] ?? '')
                    ;
                    $words[] = ($data[$y - 1][$x + 1] ?? '') //top-right bottom-left
                        . $data[$y][$x]
                        . ($data[$y + 1][$x - 1] ?? '')
                    ;
                    $count_values = array_count_values($words);
                    $sum+= (($count_values['MAS'] ?? 0) >= 2) ? 1 : 0;
                }

            }
        }

        return $sum;

    }

    static private function input() : Input {
        return (new Input(__DIR__ . '/input'))->map('str_split');
    }

}

echo Day04::runOne() . PHP_EOL;
echo Day04::runTwo() . PHP_EOL;