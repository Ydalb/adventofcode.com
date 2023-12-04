<?php

use AOC\Input;

require __DIR__ . '/../../collection.php';


class Day04 {

    static public function runOne() : int {

        return self::input()
            ->reduce(function(int $carry, string $line) : int {
                [$game_id, $num_winner_numbers] = self::countPoints($line);
                if ($num_winner_numbers === 1) {
                    $points = 1;
                } else if ($num_winner_numbers > 1) {
                    $points = pow(2, $num_winner_numbers - 1);
                } else {
                    $points = 0;
                }
                return $carry + $points;
            }, $count = 0)
            ;

    }

    static public function runTwo() : int {

        $data = self::input();
        $pile = array_fill(0, $data->getSize() + 1, 1);
        $data->each(function(string $line, $i) use(&$pile, $data) : void {
            [$game_id, $num_winner_numbers] = self::countPoints($line);
            if ($num_winner_numbers > 0) {
                $copies = $pile[$i + 1];
                for ($j = 2; $j <= min($num_winner_numbers + 1, $data->getSize() + 1); $j++) {
                    $pile[$i + $j]+= $copies;
                }
            }
        });

        return array_sum($pile) - 1;

    }

    static private function countPoints(string $line) : array {

        preg_match('/Card\s+(\d+):(.+)\|(.+)/', $line, $matches);
        [, $game_id, $winning_numbers, $numbers] = $matches;

        preg_match_all('/\d+/', $winning_numbers, $matches_w);
        preg_match_all('/\d+/', $numbers, $matches_n);

        $winning_numbers = array_map('intval', $matches_w[0]);
        $numbers = array_map('intval', $matches_n[0]);
        $num_winner_numbers = count(array_intersect($winning_numbers, $numbers));

        return [(int)$game_id, $num_winner_numbers];
    }

    static private function input() : Input {

        return (new Input(__DIR__ . '/input'));

    }

}

echo Day04::runOne() . PHP_EOL;
echo Day04::runTwo() . PHP_EOL;