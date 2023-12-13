<?php

use AOC\Input;

require __DIR__ . '/../../collection.php';


class Day13 {

    static public function runOne() {

        $getReflectionLine = function(array $rows, bool $with_smudge = false) : ?int {

            $num_rows = count($rows);

            $match = false;

            for ($i = 0; $i < $num_rows; $i++) {
                //            echo "i={$i}\n";
                $j = $i;
                $k = $i + 1;

                do {

                    $current = $rows[$j] ?? null;
                    $next = $rows[$k] ?? null;

                    if ($current == null || $next == null) {
                        break;
                    }

                    if ($current == $next) {
                        $match = true;
                    } else {
                        $match = false;
                    }
                    //                echo "{$j} vs {$k} = " . (int)$match . PHP_EOL;
                    $j--;
                    $k++;

                } while ($match && ($j >= 0 || $k < $num_rows));

                if ($match) {
                    break;
                }

            }
            if ($match) {
                return $i + 1;
            } else {
                return null;
            }

        };

        return self::input()
            ->reduce(function(int $sum, array $data) use($getReflectionLine) {

                [$rows, $columns] = $data;

                $line = $getReflectionLine($rows);
                if ($line == null) {
                    $line = $getReflectionLine($columns);
                    $sum+= $line;
                } else {
                    $sum+= $line * 100;
                }

                echo "line={$line}\n";

                return $sum;

            }, $carry = 0)

        ;

    }

    static public function runTwo() {

        $getReflectionLine = function(array $rows) : ?int {

            $rows_backup = $rows;
            $num_rows = count($rows);
            $line_length = strlen($rows[0]);

            for ($x = 0; $x < $num_rows; $x++) {

                for ($y = 0; $y < $line_length; $y++) {

                    echo "x,y={$x},{$y}\n";

                    $rows = $rows_backup;
                    $rows[$x][$y] = ($rows[$x][$y] == '#' ? '.' : '#');

                    $match = false;


                    for ($i = 0; $i < $num_rows; $i++) {

                        echo "i={$i}\n";

                        $j = $i;
                        $k = $i + 1;

                        $ignored_lines = [];

                        do {

                            $current = $rows[$j] ?? null;
                            $next = $rows[$k] ?? null;

                            if ($current == null || $next == null) {
                                $ignored_lines[] = $j;
                                $ignored_lines[] = $k;
                                break;
                            }

                            if ($current == $next) {
                                $match = true;
                            } else {
                                $match = false;
                            }

//                            if ($i == 0) {
//                                echo "{$j} {$current} vs {$k} {$next} = " . (int)$match . PHP_EOL;
//                            }

                            $j--;
                            $k++;

                        } while ($match && ($j >= 0 || $k <= $num_rows));

                        if ($match && !in_array($x, $ignored_lines)) {
//                            echo "MATCH\n";
//                            var_dump($x, $ignored_lines);
                            break;
                        }

                    }

                    if ($match) {
                        return $i + 1;
                    }

                }
            }

            return null;

        };

        return self::input()
            ->reduce(function(int $sum, array $data) use($getReflectionLine) {

                [$rows, $columns] = $data;

                $line = $getReflectionLine($rows);
                if ($line == null) {
                    $line = $getReflectionLine($columns);
                    $sum+= $line;
                } else {
                    $sum+= $line * 100;
                }

                echo "line={$line}\n";

                return $sum;

            }, $carry = 0)

            ;

    }

    static public function input() : Input {

        return (new Input(__DIR__ . '/input'))
            ->group()
            ->map(function(array $rows) {

                $columns = [];
                foreach ($rows as $line) {
                    //temp build columns in order to regroup them later
                    foreach (str_split($line) as $i => $col) {
                        if (!isset($columns[$i])) {
                            $columns[$i] = '';
                        }
                        $columns[$i].= $col;
                    }
                }

                return [$rows, $columns];

            })
        ;

    }

}

//echo Day13::runOne() . PHP_EOL;
echo Day13::runTwo() . PHP_EOL;