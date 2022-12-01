<?php

namespace AOC;

require __DIR__ . '/../../collection.php';

echo (new Input(__DIR__ . '/input'))->group('')->map('array_sum')->max() . PHP_EOL;

echo (new Input(__DIR__ . '/input'))->group('')->map('array_sum')->rsort()->take(3)->sum() . PHP_EOL;