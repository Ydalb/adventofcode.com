<?php

class Day08 {

    static public function runOne() : int {

        $map = self::input();
        $n = count($map);
        $num_visible = 4 * ($n - 1); // edges

       for ($y = 1; $y < ($n - 1); $y++) {
           for ($x = 1; $x < ($n - 1); $x++) {

               $tree = $map[$y][$x];

               //left
               $is_visible_left = true;
               $xx = $x - 1;
               $yy = $y;
               while ($xx >= 0) {
                   if ($map[$yy][$xx] >= $tree) {
                       $is_visible_left = false;
                       break;
                   }
                   $xx--;
               }

               if (!$is_visible_left) {

                   //bottom
                   $is_visible_bottom = true;
                   $xx = $x;
                   $yy = $y + 1;
                   while ($yy <= ($n - 1)) {
                       if ($map[$yy][$xx] >= $tree) {
                           $is_visible_bottom = false;
                           break;
                       }
                       $yy++;
                   }

                   if (!$is_visible_bottom) {

                       //right
                       $is_visible_right = true;
                       $xx = $x + 1;
                       $yy = $y;
                       while ($xx <= ($n - 1)) {
                           if ($map[$yy][$xx] >= $tree) {
                               $is_visible_right = false;
                               break;
                           }
                           $xx++;
                       }

                       if (!$is_visible_right) {

                           //top
                           $is_visible_top = true;
                           $xx = $x;
                           $yy = $y - 1;
                           while ($yy >= 0) {
                               if ($map[$yy][$xx] >= $tree) {
                                   $is_visible_top = false;
                                   break;
                               }
                               $yy--;
                           }

                       }

                   }

               }

               if ($is_visible_left || $is_visible_bottom || $is_visible_right || $is_visible_top) {
                   $num_visible++;
               }

           }
        }

        return $num_visible;

    }

    static public function runTwo() : int {

        $map = self::input();
        $n = count($map);
        $scenic_score_max = 0;

        for ($y = 1; $y < ($n - 1); $y++) {
            for ($x = 1; $x < ($n - 1); $x++) {

                $tree = $map[$y][$x];

                //distance left
                $distance_left = 0;
                $xx = $x - 1;
                $yy = $y;
                while ($xx >= 0) {
                    $distance_left++;
                    if ($map[$yy][$xx] >= $tree) {
                        break;
                    }
                    $xx--;
                }

                //bottom
                $distance_bottom = 0;
                $xx = $x;
                $yy = $y + 1;
                while ($yy <= ($n - 1)) {
                    $distance_bottom++;
                    if ($map[$yy][$xx] >= $tree) {
                        break;
                    }
                    $yy++;
                }

                //right
                $distance_right = 0;
                $xx = $x + 1;
                $yy = $y;
                while ($xx <= ($n - 1)) {
                    $distance_right++;
                    if ($map[$yy][$xx] >= $tree) {
                        break;
                    }
                    $xx++;
                }

                //left
                $distance_top = 0;
                $xx = $x;
                $yy = $y - 1;
                while ($yy >= 0) {
                    $distance_top++;
                    if ($map[$yy][$xx] >= $tree) {
                        break;
                    }
                    $yy--;
                }

                $scenic_score = $distance_top * $distance_right * $distance_bottom * $distance_left;
                if ($scenic_score > $scenic_score_max) {
                    $scenic_score_max = $scenic_score;
                }

            }

        }

        return $scenic_score_max;

    }

    static private function input() : array {

        $input = file(__DIR__ . '/input', FILE_IGNORE_NEW_LINES);

        $map = [];
        foreach ($input as $i => $line) {
            $map[$i] = str_split($line);
        }

        return $map;

    }

}

echo Day08::runOne() . PHP_EOL;
echo Day08::runTwo() . PHP_EOL;