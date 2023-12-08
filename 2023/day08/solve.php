<?php

use AOC\Input;

require __DIR__ . '/../../collection.php';


class Day08 {

    static public function runOne() {

        [$instructions, $data] = self::input();
        $node = 'AAA';
        $instruction_index = 0;

        while ($node !== 'ZZZ') {
            $next_instruction = $instructions[$instruction_index % strlen($instructions)];
            $node = $data[$node][$next_instruction];
            $instruction_index++;
        }

        return $instruction_index;

    }

    static public function runTwo() {

        [$instructions, $data] = self::input();

        $nodes = [];
        foreach ($data as $node => $destination) {

            if (str_ends_with($node, 'A')) {

                $nodes[$node] = [];

                $start_node = $node;
                $instruction_index = 0;
                while (true) {

                    $next_instruction = $instructions[$instruction_index % strlen($instructions)];
                    $start_node = $data[$start_node][$next_instruction];
                    $instruction_index++;

                    if (str_ends_with($start_node, 'Z')) {
                        $nodes[$node] = $instruction_index;
                        break;
                    }

                }

            }
        }

        while (count($nodes) > 1) {
            $number_1 = array_shift($nodes);
            $number_2 = array_shift($nodes);
            $lcm = gmp_lcm($number_1, $number_2);
            array_unshift($nodes, $lcm);
        }

        return reset($nodes);

    }

    static private function input() : array {

        $total_winnings = 0;

        $data = (new Input(__DIR__ . '/input', FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES));

        $instructions = $data->shift();

        $data
            ->by(function(string $line) : string {
                preg_match('/(\w+) =/', $line, $matches);
                return $matches[1];
            })
            ->map(function(string $line) : array {
                preg_match('/\w+ = \((\w+), (\w+)\)/', $line, $matches);
                return [
                    'L' => $matches[1],
                    'R' => $matches[2]
                ];
            })
        ;

        return [$instructions, $data->toArray()];

    }

}

echo Day08::runOne() . PHP_EOL;
echo Day08::runTwo() . PHP_EOL;