<?php

class Day10 {

    static public function runOne() : int {

        [$signal_strength, ] = self::run(
            $compute_signal_strength = function(int $total_cycles, int $x, int &$signal_strength) {
                if (in_array($total_cycles, [20, 60, 100, 140, 180, 220])) {
                    $signal_strength+= $total_cycles * $x;
                }
            }
        );

        return $signal_strength;
    }

    static public function runTwo() : void {

        [, $pixels] = self::run(
            $compute_signal_strength = function(int $total_cycles, int $x, int &$signal_strength, array &$pixels) {
                static $screen_line = 0;
                $total_cycles_modulo = ($total_cycles - 1) % 40;
                if ($total_cycles_modulo === 0) {
                    $screen_line++;
                }
                if (in_array($total_cycles_modulo, [$x - 1, $x, $x + 1])) {
                    $pixel = '#';
                } else {
                    $pixel = '·';
                }
                $pixels[$screen_line][] = $pixel;
            }
        );

        foreach ($pixels as $line) {
            echo join('', $line) . PHP_EOL;
        }

    }

    static private function run(callable $callable) : array {

        $x = 1;
        $total_cycles = 0;
        $signal_strength = 0;
        $pixels = [];

        foreach (self::input() as [$instruction, $cycle]) {

            if ($instruction === 'noop') {
                $total_cycles+= 1;
                $callable($total_cycles, $x, $signal_strength, $pixels);
            } else if ($instruction === 'addx') {
                for ($i = 1; $i <= 2; $i++) {
                    $total_cycles++;
                    $callable($total_cycles, $x, $signal_strength, $pixels);
                }
                $x+= $cycle;
            }

        }

        return [$signal_strength, $pixels];

    }

    static private function input() : array {

        $input = file(__DIR__ . '/input', FILE_IGNORE_NEW_LINES);

        $moves = [];
        foreach ($input as $line) {
            $tmp = explode(' ', $line);
            $moves[] = [$tmp[0], $tmp[1] ?? 0];
        }

        return $moves;

    }

}

echo Day10::runOne() . PHP_EOL;
echo Day10::runTwo() . PHP_EOL;