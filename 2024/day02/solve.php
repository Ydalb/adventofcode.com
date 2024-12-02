<?php

use AOC\Input;

require __DIR__ . '/../../collection.php';


class Day02 {

    static private function checkLevels(array $levels) : bool {
        $direction = null;
        for ($i = 0; $i < count($levels) - 1; $i++) {
            $a = $levels[$i];
            $b = $levels[$i + 1];
            $diff = $b - $a;
            if ($direction === null) {
                $direction = ($diff > 0 ? 1 : -1);
            }
            if ($direction === 1 && ($diff < 1 || $diff > 3) || $direction === -1 && ($diff < -3 || $diff > -1)) {
                return false;
            }
        }
        return true;
    }

    static public function runOne() : int {

        return self::input()
            ->reduce(function(int $sum, array $levels) {

                if (self::checkLevels($levels)) {
                    $sum++;
                }

                return $sum;

            }, $init = 0)
        ;

    }

    static public function runTwo() : int {

        return self::input()
           ->reduce(function(int $sum, array $levels) {

               $is_safe = false;

               for ($i = -1; $i < count($levels); $i++) {

                   if ($i === -1) {
                       if (self::checkLevels($levels)) {
                           $is_safe = true;
                           break;
                       }
                   } else {
                       $new_levels = $levels;
                       unset($new_levels[$i]);
                       if (self::checkLevels(array_values($new_levels))) {
                           $is_safe = true;
                           break;
                       }
                   }

               }

               if ($is_safe) {
                   echo join(' ', $levels) . ' safe ' . PHP_EOL;
                   $sum++;
               } else {
                   echo join(' ', $levels) . ' UNSAFE ' . PHP_EOL;
               }

               return $sum;

           }, $init = 0)
        ;

    }

    static private function input() : Input {

        return (new Input(__DIR__ . '/input'))
            ->map(function(string $row) {
                return explode(' ', $row);
            })
        ;

    }

}

echo Day02::runOne() . PHP_EOL;
echo Day02::runTwo() . PHP_EOL;