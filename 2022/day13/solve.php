<?php

class Day13 {

    static public function runOne() : int {

        $pairs = self::input();
        $num_ordered_indices = 0;

        foreach ($pairs as $indice => $pair) {
            [$left, $right] = $pair;
            if (self::isLower($left, $right) === -1) {
                $num_ordered_indices+= $indice + 1;
            }
        }

        return $num_ordered_indices;

    }

    static public function runTwo() : int {

        $pairs = self::input();
        return 0;

    }

    static private function isLower($left, $right) : int {

        echo json_encode($left) . ' vs ' . json_encode($right) . PHP_EOL;

        if (is_int($left) && is_int($right)) {
            return $left <=> $right;
        } else if (is_array($left) && is_array($right)) {
            foreach ($left as $i => $l) {
                if (!isset($right[$i])) {
                    return 1;
                } else if (($result = self::isLower($l, $right[$i])) !== 0) {
                    return $result;
                }
            }
            if (count($left) < count($right)) {
                return -1;
            } else {
                return 0;
            }
        } else if (is_int($left)) {
            return self::isLower([$left], $right);
        } else if (is_int($right)) {
            return self::isLower($left, [$right]);
        } else {
            throw new \Exception('Should not happened');
        }
    }

    static private function input() : array {

        $input = file_get_contents(__DIR__ . '/input');
        $input = explode("\n\n", $input);
        $input = array_map(function(string $line) {
            $pair = explode("\n", $line);
            return [
                json_decode($pair[0]),
                json_decode($pair[1]),
            ];
        }, $input);
        return $input;

    }

}

echo Day13::runOne() . PHP_EOL;
//echo Day13::runTwo() . PHP_EOL;