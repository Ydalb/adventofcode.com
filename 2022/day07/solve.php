<?php

class Day07 {

    static public function runOne() : int {

        $map = self::input();

        $total_size = 0;
        foreach ($map as $folder => $size) {
            if ($size <= 100000) {
                $total_size+= $size;
            }
        }

        return $total_size;

    }

    static public function runTwo() : int {

        $map = self::input();

        $total_disk_space_available = 70000000;
        $size_root = $map['/'];

        $unused_space = $total_disk_space_available - $size_root;
        $look_for_space = 30000000 - $unused_space;

        asort($map);
        foreach ($map as $folder => $size) {
            if ($size > $look_for_space) {
                return $size;
            }
        }

        throw new \Exception('should not happen');

    }

    static private function input() : array {

        $input = file(__DIR__ . '/input', FILE_IGNORE_NEW_LINES);

        $map = []; // /path/to/folder => total size
        $current_path = '';

        foreach ($input as $line) {

            $args = explode(' ', $line);

            if ($args[0] === '$') {

                if ($args[1] === 'cd') {
                    if ($args[2] === '/') {
                        $current_path = '/';
                    } else if ($args[2] === '..') {
                        $current_path = self::getParent($current_path);
                    } else if (isset($args[2])) {
                        $current_path = rtrim($current_path, '/') . '/' . $args[2];
                    } else {
                        throw new \Exception('Un supported argument: ' . $line);
                    }

//                    echo 'Current folder: ' . $current_path . PHP_EOL;

                }

            } else if (is_numeric($args[0])) {

                $tmp_path = $current_path;

                do {

                    if (!isset($map[$tmp_path])) {
                        $map[$tmp_path] = 0;
                    }
                    $map[$tmp_path]+= $args[0];

                    $tmp_path = self::getParent($tmp_path);

                } while ($tmp_path !== null);

            }

        }

        return $map;

    }

    static private function getParent(string $path) : ?string {
        if ($path === '/') {
            return null;
        } else {
            return dirname($path);
        }
    }

}

echo Day07::runOne() . PHP_EOL;
echo Day07::runTwo() . PHP_EOL;