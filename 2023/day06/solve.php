<?php

use AOC\Input;

require __DIR__ . '/../../collection.php';


class Day06 {

    static public function runOne() {

        $games = [];

        (new Input(__DIR__ . '/input'))
            ->each(function(string $line) use(&$games) {
                preg_match_all('/\d+/', $line, $matches);
                $key = str_starts_with($line, 'Time:') ? 'time' : 'distance';
                foreach ($matches[0] as $i => $number) {
                    if (!isset($games[$i])) {
                        $games[$i] = [
                            'time' => 0,
                            'distance' => 0,
                        ];
                    }
                    $games[$i][$key] = (int)$number;
                }
            })
        ;

        return array_reduce($games, function(int $carry, array $game) {
            return $carry * self::computeNumWaysToBeatRecord($game);
        }, $carry = 1);

    }

    static public function runTwo() {

        $game = [
            'time' => 0,
            'distance' => 0,
        ];

        (new Input(__DIR__ . '/input'))
            ->each(function(string $line) use(&$game) {
                preg_match_all('/\d+/', $line, $matches);
                $key = str_starts_with($line, 'Time:') ? 'time' : 'distance';
                $game[$key] = (int) join('', $matches[0]);
            })
        ;

        return self::computeNumWaysToBeatRecord($game);

    }

    static private function computeNumWaysToBeatRecord(array $game) : int {

        $count = 0;
        for ($speed = 0; $speed <= $game['time']; $speed++) {
            $distance = ($game['time'] - $speed) * $speed;
            if ($distance > $game['distance']) {
                $count++;
            }
        }
        return $count;

    }

}

echo Day06::runOne() . PHP_EOL;
echo Day06::runTwo() . PHP_EOL;