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

        $seeds = [];
        $results = [];
        (new Input(__DIR__ . '/input'))
            ->group()
            ->each(function(array $data, $i) use(&$seeds, &$results) : void {
                if ($i === 0) {
                    preg_match_all('/\d+/', $data[0], $matches);
                    $matches = array_map('intval', $matches[0]);
                    for ($j = 0; $j < count($matches) - 1; $j = $j + 2) {
                        $seeds[] = [
                            'start' => $matches[$j],
                            'length' => $matches[$j + 1],
                        ];
                    }
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

                    usort($map, function($a, $b) {
                        return $a['source'] <=> $b['source'];
                    });

                    self::convert($seeds, $map, $results);

                    $seeds = $results;

                }

            })
        ;

        $min_location = PHP_INT_MAX;
        foreach ($results as $result) {
            if ($result['start'] < $min_location) {
                $min_location = $result['start'];
            }
        }
        return $min_location;

    }

    static private function convert(array $seeds_to_convert, array $map, array &$result, bool $append = false) : void {

        $new_generated_seeds = [];

        foreach ($seeds_to_convert as &$seed) {

            foreach ($map as $convert_rule) {

                $seed_start = $seed['start'];
                $seed_end = $seed_start + $seed['length'] - 1;

                $source_from = $convert_rule['source'];
                $source_to = $source_from + $convert_rule['length'] - 1;

                // Intervalle seed inclus complètement
                if ($seed_start >= $source_from && $seed_end <= $source_to) {

                    $delta = $seed_start - $source_from;
                    $seed['start'] = $convert_rule['destination'] + $delta;

                    break;

                }
                // Intervalle seed inclus partiellement (plus petit) : besoin de splitter l'intervalle et de convertir la partie en dehors
                else if ($seed_end >= $source_from && $seed_end <= $source_to) {

                    $new_generated_seeds[] = [
                        'start' => $seed_start,
                        'length' => $source_from - $seed_start,
                    ];
                    $delta = $seed_end - $source_from;

                    $seed['length'] = $seed_end - $source_from + 1;
                    $seed['start'] = $convert_rule['destination'] + $delta;

                    break;

                }
                // Intervalle seed inclus partiellement (plus grand) : besoin de splitter l'intervalle et de convertir la partie en dehors
                else if ($seed_start >= $source_from && $seed_start <= $source_to) {

                    $new_generated_seeds[] = [
                        'start' => $source_to + 1,
                        'length' => $seed_end - $source_to,
                    ];
                    $delta = $seed_start - $source_from;

                    $seed['length'] = $source_to - $seed_start + 1;
                    $seed['start'] = $convert_rule['destination'] + $delta;

                    break;

                }

            }

        }


        if ($append) {
            $result = array_merge($result, $seeds_to_convert);
        } else {
            $result = $seeds_to_convert;
        }

        if (count($new_generated_seeds)) {
            self::convert($new_generated_seeds, $map, $result, true);
        }

    }

}

echo Day05::runOne() . PHP_EOL;
echo Day05::runTwo() . PHP_EOL;