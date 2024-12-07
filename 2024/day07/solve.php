<?php

use AOC\Input;

require __DIR__ . '/../../collection.php';


class Day07 {

    static public function runOne() : int {

        $sum = 0;

        self::input()->each(function(array $data) use(&$sum) {

            $expected_result = array_shift($data);
            $carry = array_shift($data);

            if (self::compute($expected_result, $data, $carry, $allow_concat_operator = false)) {
                $sum+= $expected_result;
            }

        });

        return $sum;

    }

    static public function runTwo() : int {

        $sum = 0;

        self::input()->each(function(array $data) use(&$sum) {

            $expected_result = array_shift($data);
            $carry = array_shift($data);

            if (self::compute($expected_result, $data, $carry, $allow_concat_operator = true)) {
                $sum+= $expected_result;
            }

        });

        return $sum;

    }

    static private function compute(int $expected_result, array $numbers, int $carry, bool $allow_concat_operator) {

        if (count($numbers) === 0) {

            return ($carry == $expected_result);

        } else if ($carry > $expected_result) {

            return false;

        } else {

            $number = array_shift($numbers);

            return self::compute($expected_result, $numbers, $carry * $number, $allow_concat_operator)
                || self::compute($expected_result, $numbers, $carry + $number, $allow_concat_operator)
                || ($allow_concat_operator ? self::compute($expected_result, $numbers, $carry . $number, $allow_concat_operator) : false)
            ;

        }

    }

    static private function input() : Input {

        return (new Input(__DIR__ . '/input'))
            ->map(function(string $row) : array {
                return array_map('intval', preg_split('/:\s|\s+/', $row));
            })
        ;

    }

}

echo Day07::runOne() . PHP_EOL;
echo Day07::runTwo() . PHP_EOL;