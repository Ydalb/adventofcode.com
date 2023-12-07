<?php

use AOC\Input;

require __DIR__ . '/../../collection.php';


class Day07 {

    static public function runOne() {
        return self::run(allow_joker: false);
    }

    static public function runTwo() {
        return self::run(allow_joker: true);
    }

    static private function run(bool $allow_joker) : int {

        $total_winnings = 0;

        (new Input(__DIR__ . '/input'))
            ->map(function(string $line) use($allow_joker) : array {

                [$hand, $bid] = explode(' ', $line);

                $get_sortable_hand = function(string $hand, bool $allow_joker) : string {
                    $pairs = 0;
                    $three_of_a_kind = false;
                    $four_of_a_kind = false;
                    $five_of_a_kind = false;
                    $num_jokers = 0;

                    $count_chars = count_chars($hand, 1);
                    if ($allow_joker && isset($count_chars[ord('J')])) {
                        $num_jokers = $count_chars[ord('J')];
                        unset($count_chars[ord('J')]);
                    }

                    arsort($count_chars);

                    if (count($count_chars)) {
                        foreach ($count_chars as $card => $count) {
                            $count+= $num_jokers;
                            if ($count === 5) {
                                $five_of_a_kind = true;
                            } else if ($count === 4) {
                                $four_of_a_kind = true;
                            } else if ($count === 3) {
                                $three_of_a_kind = true;
                            } else if ($count === 2) {
                                $pairs++;
                            }
                            $num_jokers = 0;
                        }
                    } else {
                        $five_of_a_kind = true;
                    }

                    $replace_cards = function(string $hand, bool $allow_joker) : string {
                        return str_replace(
                            ['A', 'K', 'Q', 'J', 'T',],
                            ['Z', 'Y', 'X', ($allow_joker ? '0' : 'W'), 'T',],
                            $hand
                        );
                    };

                    if ($five_of_a_kind) {
                        return $replace_cards('7' . $hand, $allow_joker);
                    } else if ($four_of_a_kind) {
                        return $replace_cards('6' . $hand, $allow_joker);
                    } else if ($three_of_a_kind && $pairs === 1) {
                        return $replace_cards('5' . $hand, $allow_joker);
                    } else if ($three_of_a_kind) {
                        return $replace_cards('4' . $hand, $allow_joker);
                    } else if ($pairs === 2) {
                        return $replace_cards('3' . $hand, $allow_joker);
                    } else if ($pairs === 1) {
                        return $replace_cards('2' . $hand, $allow_joker);
                    } else {
                        return $replace_cards('1' . $hand, $allow_joker);
                    }
                };

                return [
                    'hand' => $hand,
                    'value' => $get_sortable_hand(hand: $hand, allow_joker: $allow_joker),
                    'bid' => (int)$bid,
                ];

            })
            ->sort(function(array $hand_a, array $hand_b) {
                return $hand_a['value'] <=> $hand_b['value'];
            })
            ->each(function(array $hand, int $rank) use(&$total_winnings) {
                $total_winnings+= $hand['bid'] * ($rank + 1);
            })
        ;

        return $total_winnings;

    }

}

echo Day07::runOne() . PHP_EOL;
echo Day07::runTwo() . PHP_EOL;