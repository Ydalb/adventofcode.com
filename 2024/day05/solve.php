<?php

use AOC\Input;

require __DIR__ . '/../../collection.php';


class Day05 {

    static public function runOne() : int {

        [$rules, $page_numbers] = self::input()->toArray();

        $sum = 0;

        foreach ($page_numbers as $pages) {
            $pages = explode(',', $pages);
            $pages_mapping = array_flip($pages);
            if (self::isCorrectOrder($pages, $rules, $pages_mapping) === true) {
                $sum+= $pages[(count($pages) - 1) / 2];
            }
        }

        return $sum;

    }

    static public function runTwo() : int {

        [$rules, $page_numbers] = self::input()->toArray();

        $sum = 0;

        foreach ($page_numbers as $pages) {
            $pages = explode(',', $pages);
            $pages_mapping = array_flip($pages);

            $rule = self::isCorrectOrder($pages, $rules, $pages_mapping);

            if ($rule !== true) {

                do {

                    [$rule_left, $rule_right] = explode('|', $rule);

                    $page_left = array_search($rule_left, $pages);
                    $page_right = array_search($rule_right, $pages);
                    $pages[$page_left] = $rule_right;
                    $pages[$page_right] = $rule_left;

                    $mapping_left = $pages_mapping[$rule_left];
                    $mapping_right = $pages_mapping[$rule_right];

                    $pages_mapping[$rule_left] = $mapping_right;
                    $pages_mapping[$rule_right] = $mapping_left;


                } while (($rule = self::isCorrectOrder($pages, $rules, $pages_mapping)) !== true);

                $sum+= $pages[(count($pages) - 1) / 2];

            }

        }

        return $sum;

    }

    static private function isCorrectOrder(array $pages, array $rules, array $pages_mapping) : bool|string {

        foreach ($rules as $rule) {
            [$rule_left, $rule_right] = array_map(function(string $number) use($pages_mapping) : ?int {
                return ($pages_mapping[$number] ?? null);
            }, explode('|', $rule));
            if ($rule_left === null || $rule_right === null) {
                continue;
            }
            if ($rule_left > $rule_right) {
                return $rule;
            }
        }

        return true;

    }

    static private function input() : Input {
        return (new Input(__DIR__ . '/input'))->group('');

    }

}

//echo Day05::runOne() . PHP_EOL;
echo Day05::runTwo() . PHP_EOL;