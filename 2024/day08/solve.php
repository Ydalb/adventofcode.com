<?php

use AOC\Input;

require __DIR__ . '/../../collection.php';


class Day08 {

    static public function runOne() : int {

        [$rows, $height, $width] = self::input();

        $antinodes = [];

        foreach ($rows as $antennas) {

            if (count($antennas) <= 1) {
                continue;
            }

            for ($i = 0; $i < count($antennas) - 1; $i++) {

                for ($j = $i + 1; $j < count($antennas); $j++) {

                    $antenna_a = $antennas[$i];
                    $antenna_b = $antennas[$j];

                    self::calculateAntinodes($height, $width, $antenna_a, $antenna_b, $antinodes);

                }

            }

        }

        return count($antinodes);

    }

    static public function runTwo() : int {

        [$rows, $height, $width] = self::input();

        $antinodes = [];

        foreach ($rows as $antennas) {

            if (count($antennas) <= 1) {
                continue;
            }

            for ($i = 0; $i < count($antennas) - 1; $i++) {

                for ($j = $i + 1; $j < count($antennas); $j++) {

                    $antenna_a = $antennas[$i];
                    $antenna_b = $antennas[$j];

                    self::calculateAntinodes($height, $width, $antenna_a, $antenna_b, $antinodes, true);

                }

            }

        }

        return count($antinodes);

    }

    static private function calculateAntinodes(
        int $height,
        int $width,
        array $antenna_a,
        array $antenna_b,
        array &$antinodes,
        bool $with_harmonics = false) : void {

        [$y1, $x1] = $antenna_a;
        [$y2, $x2] = $antenna_b;

        $distance_y = $y2 - $y1;
        $distance_x = $x2 - $x1;

        $antinode_y1 = $y1;
        $antinode_y2 = $y2;
        $antinode_x1 = $x1;
        $antinode_x2 = $x2;

        if ($with_harmonics) {
            $antinodes[$antinode_y1 . ',' . $antinode_x1] = '#';
            $antinodes[$antinode_y2 . ',' . $antinode_x2] = '#';
        }

        do {

            if ($distance_y > 0) {
                $antinode_y1-= $distance_y;
                $antinode_y2+= $distance_y;
            } else if ($distance_y < 0) {
                $antinode_y1-= $distance_y;
                $antinode_y2+= $distance_y;
            }

            if ($distance_x > 0) {
                $antinode_x1-= $distance_x;
                $antinode_x2+= $distance_x;
            } else if ($distance_x < 0) {
                $antinode_x1-= $distance_x;
                $antinode_x2+= $distance_x;
            }

            if ($antinode_y1 >= 0 && $antinode_y1 < $height && $antinode_x1 >= 0 && $antinode_x1 < $width) {
                $antinodes[$antinode_y1 . ',' . $antinode_x1] = '#';
                $continue = true;
            } else {
                $continue = false;
            }

            if ($antinode_y2 >= 0 && $antinode_y2 < $height && $antinode_x2 >= 0 && $antinode_x2 < $width) {
                $antinodes[$antinode_y2 . ',' . $antinode_x2] = '#';
                $continue = true;
            } else {
                $continue = $continue || false;
            }

        } while ($continue && $with_harmonics);


    }

    static private function input() : array {

        $antennas = [];

        $data = (new Input(__DIR__ . '/input'))
            ->map('str_split')
            ->toArray()
        ;
        for ($y = 0; $y < count($data); $y++) {
            for ($x = 0; $x < count($data[$y]); $x++) {

                $value = $data[$y][$x];

                if ($data[$y][$x] !== '.') {
                    if (!isset($antennas[$value])) {
                        $antennas[$value] = [];
                    }
                    $antennas[$value][] = [$y, $x];
                }

            }
        }

        return [$antennas, count($data), count($data[0])];

    }

}

echo Day08::runOne() . PHP_EOL;
echo Day08::runTwo() . PHP_EOL;