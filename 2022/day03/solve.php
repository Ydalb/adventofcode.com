<?php

class Day03 {

    static public function runOne() : int {

        $input = [];
        foreach (file(__DIR__ . '/input', FILE_IGNORE_NEW_LINES) as $line) {
            $half = strlen($line) / 2;
            $input[] = [
                str_split(substr($line, 0, $half)),
                str_split(substr($line,  $half)),
            ];
        }

        $conversion = array_combine(
            [...range('a', 'z'), ...range('A', 'Z')],
            range(1, 52)
        );

        $priority = 0;
        foreach ($input as $rubsack) {
            $priority+= array_reduce(
                $common_items = array_unique(array_intersect(...$rubsack)),
                function(int $carry, string $item) use($conversion) : int {
                    $carry+= $conversion[$item];
                    return $carry;
                },
                $carry = 0
            );
        }

        return $priority;

    }

    static public function runTwo() : int {

        $input = array_map('str_split', file(__DIR__ . '/input', FILE_IGNORE_NEW_LINES));
        $conversion = array_combine(
            [...range('a', 'z'), ...range('A', 'Z')],
            range(1, 52)
        );

        $priority = 0;
        foreach (array_chunk($input, 3) as $rubsacks) {

            $priority+= array_reduce(
                $common_items = array_unique(array_intersect(...$rubsacks)),
                function(int $carry, string $item) use($conversion) : int {
                    $carry+= $conversion[$item];
                    return $carry;
                },
                $carry = 0
            );
        }

        return $priority;

    }

}

echo Day03::runOne() . PHP_EOL;
echo Day03::runTwo() . PHP_EOL;