<?php

use AOC\Input;

require __DIR__ . '/../../collection.php';


class Day09 {

    static public function runOne() : int {

        $data = self::input();

        $disk = [];
        $is_file = true;
        for ($i = 0; $i < strlen($data); $i++) {
            for ($j = 0; $j < $data[$i]; $j++) {
                if ($is_file) {
                    $disk[] = $i / 2;
                } else {
                    $disk[] = '.';
                }
            }
            $is_file = !$is_file;
        }

        $i = 0;
        for ($j = count($disk) - 1; $j > $i - 1; $j--) {

            if ($disk[$j] === '.') {
                continue;
            }

            while (($disk[$i] ?? '') !== '.') {
                if (!isset($disk[$i])) {
                    break 2;
                }
                $i++;
            }

            if ($i >= $j) {
                break;
            }

            $tmp = $disk[$j];
            $disk[$j] = $disk[$i];
            $disk[$i] = $tmp;

        }

        $sum = 0;
        foreach ($disk as $id => $value) {
            if ($value === '.') {
                continue;
            }
            $sum+= $id * $value;
        }

        return $sum;

    }

    static public function runTwo() : int {

        $data = self::input();

        $disk = [];
        $is_file = true;
        for ($i = 0; $i < strlen($data); $i++) {
            if ($is_file) {
                $disk[] = ['id' => $i / 2, 'size' => $data[$i]];
            } else {
                $disk[] = ['id' => '.', 'size' => $data[$i]];
            }
            $is_file = !$is_file;
        }

        for ($j = count($disk) - 1; $j > 0; $j--) {

            if (str_contains($disk[$j]['id'], '.')) { //lookfor file
                continue;
            }

            $filesize = $disk[$j]['size'];

            for ($i = 0; $i < $j; $i++) {

                if (!str_contains($disk[$i]['id'], '.')) { //lookfor freespace
                    continue;
                }

                $memory_size = $disk[$i]['size'];

                if ($memory_size >= $filesize) {

                    $remaining_free_space = $memory_size - $filesize;

                    $tmp = $disk[$j];
                    $disk[$j] = [
                        'id' => '.',
                        'size' => $memory_size - $remaining_free_space,
                    ];
                    $disk[$i] = $tmp;

                    array_splice($disk, $i + 1, 0, [[
                        'id' => '.',
                        'size' => $remaining_free_space,
                    ]]);

                    break;

                }

            }

        }

        $sum = 0;
        $i = 0;
        foreach ($disk as $value) {
            if ($value['id'] !== '.') {
                while ($value['size'] > 0) {
                    $sum+= $i * $value['id'];
                    $value['size']--;
                    $i++;
                }
            } else {
                $i+= $value['size'];
            }

        }

        return $sum;

    }

    static private function input() : string {
        return (new Input(__DIR__ . '/input'))->toArray()[0];
    }

}

echo Day09::runOne() . PHP_EOL;
echo Day09::runTwo() . PHP_EOL;