<?php

class Day05 {

    static public function runOne() : string {

        ['stacks' => $stacks, 'orders' => $orders] = self::input();

        foreach ($orders as $order) {

            $crates = array_splice($stacks[$order['from']], -1 * $order['quantity']);

            array_push($stacks[$order['to']], ...array_reverse($crates));

        }

        return self::result($stacks);
    }

    static public function runTwo() : string {

        ['stacks' => $stacks, 'orders' => $orders] = self::input();


        foreach ($orders as $order) {

            self::display($stacks, $order);

            $crates = array_splice($stacks[$order['from']], -1 * $order['quantity']);

            array_push($stacks[$order['to']], ...$crates);

        }

        self::display($stacks, null);

        return self::result($stacks);

    }

    static private function display(array $stacks, ?array $order) : void {

        system('clear');

        foreach ($stacks as $i => $stack) {
            echo "{$i}. " . join(' ', array_map(fn($crate) => "[{$crate}]", $stack)) . PHP_EOL;
        }

        if ($order) {
            echo "move {$order['quantity']} from {$order['from']} to {$order['to']}\n";
        }

        usleep(30000);

    }

    static private function result(array $stacks) : string {
        $return = '';
        foreach ($stacks as $stack) {
            $return.= end($stack);
        }
        return $return;
    }

    static private function input() : array {

        $stacks = [];
        $orders = [];

        foreach (file(__DIR__ . '/input', FILE_IGNORE_NEW_LINES) as $line) {

            if (str_contains($line, '[')) {
                preg_match_all('/(\s{4}|[A-Z])/', $line, $matches);
                foreach ($matches[1] as $index => $match) {
                    if (!isset($stacks[$index + 1])) {
                        $stacks[$index + 1] = [];
                    }
                    if (in_array($match, range('A', 'Z'))) {
                        $stacks[$index + 1][] = $match;
                    }
                }
            } else if (preg_match('/move (\d+) from (\d+) to (\d+)/', $line, $match)) {
                $orders[] = [
                    'quantity' => (int)$match[1],
                    'from' => (int)$match[2],
                    'to' => (int)$match[3],
                ];
            }

        }

        foreach ($stacks as &$stack) {
            $stack = array_reverse($stack);
        }

        return [
            'stacks' => $stacks,
            'orders' => $orders,
        ];

    }

}

echo Day05::runOne() . PHP_EOL;
echo Day05::runTwo() . PHP_EOL;