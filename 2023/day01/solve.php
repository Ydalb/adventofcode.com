<?php

use AOC\Input;

require __DIR__ . '/../../collection.php';


class Day01 {

    static public function runOne() : int {

        return self::input()
            ->map(function(string $line) : int {
                $number = (int)preg_replace('/[^0-9]/', '', $line);
                return substr($number, 0, 1) . substr($number, -1);
            })
            ->sum()
        ;

    }

    static public function runTwo() {

        return self::input()
            ->map(function(string $line) : int {
                $first = $last = null;
                $length = strlen($line);
                $formatter = new NumberFormatter("en", NumberFormatter::SPELLOUT);
                for ($i = 0; $i < $length; $i++) {
                    $offset = $i;
                    if (($number = $formatter->parse($line, NumberFormatter::TYPE_INT32, $offset))) {
                        $first = $number;
                        break;
                    }
                }
                for ($i = $length - 1; $i >= 0; $i--) {
                    $offset = $i;
                    if (($number = $formatter->parse($line, NumberFormatter::TYPE_INT32, $offset))) {
                        $last = $number;
                        break;
                    }
                }
                return (int)(substr($first, 0, 1) . substr($last, -1));
            })
            ->sum()
        ;

    }

    static private function input() : Input {

        return (new Input(__DIR__ . '/input'));

    }

}

echo Day01::runOne() . PHP_EOL;
echo Day01::runTwo() . PHP_EOL;