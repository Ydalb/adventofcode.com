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
                echo "Game {$game_id} POINTS: {$points}\n";
                return $carry + $points;
            }, $count = 0)
        ;

    }

    static public function runTwo() : int {

        $total_cards = 0;
        $data = self::input();
        $data->each(function(string $line, $line_number) use(&$total_cards, $data) : void {
            $total_cards+= self::countPointsRec($line_number, $data);
        });

        return $total_cards;

    }

    static private function countPointsRec(int $line_number, Input $data) : int {
        [$game_id, $num_winner_numbers] = self::countPoints($data->get($line_number));
        $cards = 1;
        for ($i = 1; $i <= $num_winner_numbers; $i++) {
            $cards+= self::countPointsRec($line_number + $i, $data);
        }
        return $cards;
    }

    static private function countPoints(string $line) : array {

        preg_match('/Card\s+(\d+):(.+)\|(.+)/', $line, $matches);
        [, $game_id, $winning_numbers, $numbers] = $matches;

        preg_match_all('/\d+/', $winning_numbers, $matches_w);
        preg_match_all('/\d+/', $numbers, $matches_n);

        $winning_numbers = array_map('intval', $matches_w[0]);
        $numbers = array_map('intval', $matches_n[0]);

        echo "Game {$game_id} WINNING: " . implode(' ', $winning_numbers) . "\n";
        echo "Game {$game_id} NUMBERS: " . implode(' ', $numbers) . "\n";

        $num_winner_numbers = count(array_intersect($winning_numbers, $numbers));

        return [(int)$game_id, $num_winner_numbers];
    }

    static private function input() : Input {

        return (new Input(__DIR__ . '/input'));

    }

}

echo Day04::runOne() . PHP_EOL;
echo Day04::runTwo() . PHP_EOL;