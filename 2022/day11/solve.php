<?php

class Day11 {

    static public function runOne() : int {

        return self::run(1);

    }

    static public function runTwo() : int {

        return self::run(2);

    }

    static public function run(int $part) : int {

        $monkeys = self::input();

        $reducer = array_reduce($monkeys, function(int $carry, array $monkey) {
            return $carry * $monkey['divisible_by'];
        }, $carry = 1);

        $nb_round = ($part === 1 ? 20 : 10000);

        for ($round = 1; $round <= $nb_round; $round++) {

            for ($i = 0; $i < count($monkeys); $i++) {

                foreach ($monkeys[$i]['items'] as $item) {

                    $monkeys[$i]['num_inspections'] = $monkeys[$i]['num_inspections'] + 1;

                    $value = call_user_func($monkeys[$i]['operation'], $item) % $reducer;
                    if ($part === 1) {
                        $value = floor($value / 3);
                    }

                    if (($value % $monkeys[$i]['divisible_by']) == 0) {
                        $give_to = $monkeys[$i]['if_true'];
                    } else {
                        $give_to = $monkeys[$i]['if_false'];
                    }

                    $monkeys[$give_to]['items'][] = $value;

                }

                $monkeys[$i]['items'] = [];

            }

        }

        usort($monkeys, function ($monkey_a, $monkey_b) { return $monkey_b['num_inspections'] - $monkey_a['num_inspections']; });

        return $monkeys[0]['num_inspections'] * $monkeys[1]['num_inspections'];

    }

    static private function input() : array {

        return [
            [ //0
                'items' => [85, 77, 77],
                'operation' => fn($old) => $old * 7,
                'divisible_by' => 19,
                'if_true' => 6,
                'if_false' => 7,
                'num_inspections' => 0,
            ],
            [ //1
                'items' => [80, 99],
                'operation' => fn($old) => $old * 11,
                'divisible_by' => 3,
                'if_true' => 3,
                'if_false' => 5,
                'num_inspections' => 0,
            ],
            [ //2
                'items' => [74, 60, 74, 63, 86, 92, 80],
                'operation' => fn($old) => $old + 8,
                'divisible_by' => 13,
                'if_true' => 0,
                'if_false' => 6,
                'num_inspections' => 0,
            ],
            [ //3
                'items' => [71, 58, 93, 65, 80, 68, 54, 71],
                'operation' => fn($old) => $old + 7,
                'divisible_by' => 7,
                'if_true' => 2,
                'if_false' => 4,
                'num_inspections' => 0,
            ],
            [ //4
                'items' => [97, 56, 79, 65, 58],
                'operation' => fn($old) => $old + 5,
                'divisible_by' => 5,
                'if_true' => 2,
                'if_false' => 0,
                'num_inspections' => 0,
            ],
            [ //5
                'items' => [77],
                'operation' => fn($old) => $old + 4,
                'divisible_by' => 11,
                'if_true' => 4,
                'if_false' => 3,
                'num_inspections' => 0,
            ],
            [ //6
                'items' => [99, 90, 84, 50],
                'operation' => fn($old) => $old * $old,
                'divisible_by' => 17,
                'if_true' => 7,
                'if_false' => 1,
                'num_inspections' => 0,
            ],
            [ //7
                'items' => [50, 66, 61, 92, 64, 78],
                'operation' => fn($old) => $old + 3,
                'divisible_by' => 2,
                'if_true' => 5,
                'if_false' => 1,
                'num_inspections' => 0,
            ],
        ];

//        return [
//            [
//                'items' => [79, 98],
//                'operation' => fn($old) => $old *  19,
//                'divisible_by' => 23,
//                'if_true' => 2,
//                'if_false' => 3,
//                'num_inspections' => 0,
//            ],
//            [
//                'items' => [54, 65, 75, 74],
//                'operation' => fn($old) => $old +  6,
//                'divisible_by' => 19,
//                'if_true' => 2,
//                'if_false' => 0,
//                'num_inspections' => 0,
//            ],
//            [
//                'items' => [79, 60, 97],
//                'operation' => fn($old) => $old *  $old,
//                'divisible_by' => 13,
//                'if_true' => 1,
//                'if_false' => 3,
//                'num_inspections' => 0,
//            ],
//            [
//                'items' => [74],
//                'operation' => fn($old) => $old +  3,
//                'divisible_by' => 17,
//                'if_true' => 0,
//                'if_false' => 1,
//                'num_inspections' => 0,
//            ],
//        ];

    }

}

echo Day11::runOne() . PHP_EOL;
echo Day11::runTwo() . PHP_EOL;