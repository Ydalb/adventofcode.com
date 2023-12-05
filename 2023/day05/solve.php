<?php

use AOC\Input;

require __DIR__ . '/../../collection.php';


class Day05 {

    static public function runOne() : int {

        $seeds = [];
        (new Input(__DIR__ . '/input'))
            ->group()
            ->each(function(array $data, $i) use(&$seeds) : void {
                if ($i === 0) {
                    preg_match_all('/\d+/', $data[0], $matches);
                    $seeds = array_map('intval', $matches[0]);
                    var_dump($seeds);
                } else {
                    $map = [];
                    array_shift($data); //pop useless map name
                    foreach ($data as $numbers) {
                        $numbers = explode(' ', $numbers);
                        $numbers = array_map('intval', $numbers);
                        [$destination_range_start, $source_range_start, $range_length] = $numbers;
                        $map[] = [
                            'source' => $source_range_start,
                            'destination' => $destination_range_start,
                            'length' => $range_length,
                        ];
                    }
                    foreach ($seeds as &$seed) {
                        foreach ($map as $info) {
                            $source_from = $info['source'];
                            $source_to = $source_from + $info['length'] - 1;
                            if ($seed >= $source_from && $seed <= $source_to) {
                                $delta = $seed - $source_from;
                                $seed = $info['destination'] + $delta;
                                break;
                            }
                        }
                    }
                }
            })
        ;

        return min($seeds);

    }

    static public function runTwo() : int {

    }

}

echo Day05::runOne() . PHP_EOL;
//echo Day05::runTwo() . PHP_EOL;