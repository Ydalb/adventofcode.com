<?php

$lines = file(__DIR__ . '/input', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$numbers_drawn = array_shift($lines);
$numbers_drawn = array_map('intval', explode(',', $numbers_drawn));

$boards = array_chunk($lines, 5);
$boards = array_map(function($rows) {
    foreach ($rows as &$row) {
        if (!preg_match_all('/\d+/', $row, $matches)) {
            die('Could not find numbers on line ' . $row);
        }
        $row = array_map('intval', $matches[0]);
    }
    return $rows;
}, $boards);

$mark_number = function(array &$board, int $number_drawn) : bool {
    $marked_numbers_by_column = [];
    foreach ($board as &$numbers) {
        $line_solved = true;
        foreach ($numbers as $column_index => &$number) {
            if (!isset($marked_numbers_by_column[$column_index])) {
                $marked_numbers_by_column[$column_index] = 0;
            }
            if (is_float($number)) {
                $marked_numbers_by_column[$column_index] += 1;
            } else if ($number === $number_drawn) {
                $number = (float)$number;
                $marked_numbers_by_column[$column_index] += 1;
            } else {
                $line_solved = false;
            }
        }
        if ($line_solved) {
            return true;
        }
    }
    foreach ($marked_numbers_by_column as $num_marked_numbers) {
        if ($num_marked_numbers == count($board[0])) {
            return true;
        }
    }
    return false;
};


foreach ($numbers_drawn as $i => $number_drawn) {
    foreach ($boards as &$board) {
        if ($result = $mark_number($board, $number_drawn)) {
            $sum_unmarked_numbers = 0;
            foreach ($board as $numbers) {
                foreach ($numbers as $number) {
                    if (!is_float($number)) {
                        $sum_unmarked_numbers+= $number;
                    }
                }
            }
            echo '$number_drawn=' . $number_drawn . PHP_EOL;
            echo '$sum_unmarked_numbers=' . $sum_unmarked_numbers . PHP_EOL;
            echo 'result=' . ($number_drawn * $sum_unmarked_numbers);
            exit;
        }
    }
}