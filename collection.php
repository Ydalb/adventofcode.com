<?php

namespace AOC;

class Input {

    protected $items;

    public function __construct(string $path, int $flags = FILE_IGNORE_NEW_LINES) {
        $this->items = file($path, $flags);
    }

    private function _call($item, $index, $func) {
        if (is_object($item) && is_string($func) && method_exists($item, $func)) {
            return $item->$func();
        } else if (is_array($item) && (is_string($func) || is_int($func)) && array_key_exists($func, $item)) {
            return $item[$func];
        } else if (is_string($func) && class_exists($func)) {
            return new $func($item);
        } else if (is_callable($func)) {
            if (is_a($func, 'Closure')) {
                return $func($item, $index);
            } else {
                return $func($item);
            }
        } else {
            throw new \Exception('Illegal callable: ' . var_export($func, true));
        }
    }

    private function _key($item, $index, $key_by) {
        if (is_object($item) && is_string($key_by) && method_exists($item, $key_by)) {
            $key = $item->$key_by();
        } else if (is_array($item) && (is_string($key_by) || is_int($key_by)) && array_key_exists($key_by, $item)) {
            $key = $item[$key_by];
        } else if (is_callable($key_by)) {
            if (is_a($key_by, 'Closure')) {
                $key = $key_by($item, $index);
            } else {
                $key = $key_by($item);
            }
        } else {
            throw new \Exception('Illegal key: ' . var_export($key_by, true));
        }
        if (!is_string($key) && !is_int($key)) {
            throw new \Exception('Invalid key type. Expecting string or integer, got: ' . var_export(gettype($key), true));
        }
        return $key;
    }

    public function by($key_by) : self {
        $new_items = [];
        foreach ($this->items as $index => $item) {
            $new_items[$this->_key($item, $index, $key_by)] = $item;
        }
        $this->items = $new_items;
        return $this;
    }

    public function keyByValues() : self {
        $new_items = [];
        foreach ($this->items as $item) {
            if (!is_string($item) && !is_int($item)) {
                throw new \Exception('Invalid key type. Expecting string or integer, got: ' . var_export(gettype($item), true));
            }
            $new_items[$item] = $item;
        }
        $this->items = $new_items;
        return $this;
    }

    public function fill($value) : self {
        foreach ($this->items as $key => $item) {
            $this->items[$key] = $value;
        }
        return $this;
    }

    public function flattenKeys(callable $transform_keys) : self {
        $this->items = $this->flattenKeysRecursive($this->items, $transform_keys);
        return $this;
    }

    private function flattenKeysRecursive(array $array, callable $transform_keys, string $prefix = '') : array {
        $result = [];
        foreach ($array as $key => $value) {
            $new_key = $transform_keys($prefix, $key);
            if (is_array($value)) {
                $result = array_merge($result, $this->flattenKeysRecursive($value, $transform_keys, $new_key));
            } else {
                $result[$new_key] = $value;
            }
        }
        return $result;
    }

    public function flattenByKeys(array $keys) : self {
        $depth = count($keys);
        if ($depth <= 0) {
            throw new \Exception('At least one key must be provided.');
        }
        $keys = array_values($keys);
        $new_items = [];
        foreach ($this->items as $index => $item) {
            $v = &$new_items;
            for ($i = 0; $i < $depth; $i++) {
                $key = $this->_key($item, $index, $keys[$i]);
                if ($i < $depth - 1) {
                    if (!isset($v[$key])) {
                        $v[$key] = [];
                    }
                    $v = &$v[$key];
                } else {
                    $v[$key] = $item;
                }
            }
        }
        $this->items = $new_items;
        return $this;
    }

    public function max() : mixed {
        return max($this->items);
    }

    public function group(string $sep = '') : self {
        $result = [];
        $i = 0;
        foreach ($this->items as $item) {
            if ($item === $sep) {
                $i++;
            } else {
                $result[$i][] = $item;
            }
        }
        $this->items = $result;
        return $this;
    }

    public function groupByKeys(array $keys) : self {
        $depth = count($keys);
        if ($depth <= 0) {
            throw new \Exception('At least one key must be provided.');
        }
        $keys = array_values($keys);
        $new_items = [];
        foreach ($this->items as $index => $item) {
            $v = &$new_items;
            for ($i = 0; $i < $depth; $i++) {
                $key = $this->_key($item, $index, $keys[$i]);
                if ($i < $depth - 1) {
                    if (!isset($v[$key])) {
                        $v[$key] = [];
                    }
                    $v = &$v[$key];
                } else {
                    $v[$key][] = $item;
                }
            }
        }
        $this->items = $new_items;
        return $this;
    }

    public function groupByKey($key) : self {
        return $this->groupByKeys([$key]);
    }

    public function groupKeysByValue() : self {
        $new_items = [];
        foreach ($this->items as $key => $value) {
            if (!is_string($value) && !is_int($value)) {
                throw new \Exception('Invalid key type. Expecting string or integer, got: ' . var_export(gettype($value), true));
            }
            if (!isset($new_items[$value])) {
                $new_items[$value] = [];
            }
            $new_items[$value][] = $key;
        }
        $this->items = $new_items;
        return $this;
    }

    public function groupByKeyValue($key_func, $value_func) : self {
        $new_items = [];
        foreach ($this->items as $key => $item) {
            $new_key = $this->_call($item, $key, $key_func);
            if (!is_string($new_key) && !is_int($new_key)) {
                throw new \Exception('Invalid key type. Expecting string or integer, got: ' . var_export(gettype($new_key), true));
            }
            if (!isset($new_items[$new_key])) {
                $new_items[$new_key] = [];
            }
            $new_value = $this->_call($item, $key, $value_func);
            $new_items[$new_key][] = $new_value;
        }
        $this->items = $new_items;
        return $this;
    }

    public function groupByKeyValueObject(callable $func) : self {
        $new_items = [];
        foreach ($this->items as $key => $item) {
            $obj = $func($item, $key);
            if (!is_object($obj) || !property_exists($obj, 'key') || !property_exists($obj, 'value')) {
                throw new \Exception('Callback must return an object with <key> and <value> properties.');
            }
            $new_key = $obj->key;
            if (!is_string($new_key) && !is_int($new_key)) {
                throw new \Exception('Invalid key type. Expecting string or integer, got: ' . var_export(gettype($new_key), true));
            }
            if (!isset($new_items[$new_key])) {
                $new_items[$new_key] = [];
            }
            $new_items[$new_key][] = $obj->value;
        }
        $this->items = $new_items;
        return $this;
    }

    public function isset($key) : bool {
        return isset($this->items[$key]);
    }

    public function keyExists($key) : bool {
        return array_key_exists($key, $this->items);
    }

    public function keysExist(array $keys) : bool {
        foreach ($keys as $key) {
            if (!array_key_exists($key, $this->items)) {
                return false;
            }
        }
        return true;
    }

    public function contains($var) : bool {
        return in_array($var, $this->items);
    }

    public function first(string $error_message = null) {
        return reset($this->items);
    }

    public function last(string $error_message = null) {
        return end($this->items);
    }

    private function _values(array $items, int $depth) : array {
        if ($depth <= 0) {
            throw new \Exception('Invalid depth: ' . var_export($depth, true));
        }
        if ($depth === 1) {
            return array_values($items);
        } else {
            $values = [];
            foreach ($items as $item) {
                if (is_array($item)) {
                    $values = array_merge($values, $this->_values($item, $depth - 1));
                } else {
                    throw new \Exception('Invalid depth, found scalar value.');
                }
            }
            return $values;
        }
    }

    public function values(int $depth = 1) : self {
        $this->items = $this->_values($this->items, $depth);
        return $this;
    }

    public function deduplicate() : self {
        $new_items = [];
        foreach ($this->items as $key => $item) {
            if (!in_array_strict($item, $new_items)) {
                $new_items[$key] = $item;
            }
        }
        $this->items = is_array_list($this->items) ? array_values($new_items) : $new_items;
        return $this;
    }

    public function reverse() : self {
        //only numerical keys are not preserved, thus array lists remain array lists
        $this->items = array_reverse($this->items, $preserve_keys = false);
        return $this;
    }

    public function filter($func) : self {
        $new_items = [];
        foreach ($this->items as $key => $item) {
            if ($this->_call($item, $key, $func)) {
                $new_items[$key] = $item;
            }
        }
        $this->items = is_array_list($this->items) ? array_values($new_items) : $new_items;
        return $this;
    }

    public function findFirst($func) {
        foreach ($this->items as $key => $item) {
            if ($this->_call($item, $key, $func)) {
                return $item;
            }
        }
        return null;
    }

    public function findLast($func) {
        $result = null;
        foreach ($this->items as $key => $item) {
            if ($this->_call($item, $key, $func)) {
                $result = $item;
            }
        }
        return $result;
    }

    public function all($func) : bool {
        foreach ($this->items as $key => $item) {
            if (!$this->_call($item, $key, $func)) {
                return false;
            }
        }
        return true;
    }

    public function exists($func) : bool {
        foreach ($this->items as $key => $item) {
            if ($this->_call($item, $key, $func)) {
                return true;
            }
        }
        return false;
    }

    public function map($func) : self {
        foreach ($this->items as $key => $item) {
            $this->items[$key] = $this->_call($item, $key, $func);
        }
        return $this;
    }

    public function each(callable $func) : self {
        $index = 0;
        $total = count($this->items);
        foreach ($this->items as $key => $item) {
            $info = (object)[
                'is_first' => ($key === array_key_first($this->items)),
                'is_last' => ($key === array_key_last($this->items)),
                'index' => $index,
                'total' => $total,
            ];
            $index++;
            $func($item, $key, $info);
        }
        return $this;
    }

    public function concatArrayItems() : self {
        $new_items = [];
        foreach ($this->items as $elements) {
            if (!is_array($elements)) {
                throw new \Exception('Collection must contain arrays only.');
            }
            $new_items = $this->merge($new_items, $elements);
        }
        $this->items = $new_items;
        return $this;
    }

    public function reduce(callable $callback, $initial = null) {
        return array_reduce($this->items, $callback, $initial);
    }

    public function sum() : int {
        return array_sum($this->items);
    }

    public function take(int $take) : self {
        array_splice($this->items, $take);
        return $this;
    }

    public function sort(/*callable|int|array|null*/ $compare_func = null) : self {
        if ($compare_func === null) {
            $compare_func = SORT_REGULAR;
        }
        $is_array_list = is_array_list($this->items);
        if (is_int($compare_func)) {
            asort($this->items, $compare_func);
        } else if (is_callable($compare_func)) {
            uasort($this->items, $compare_func);
        } else if (is_array($compare_func)) {
            uasort($this->items, function($a, $b) use($compare_func) : int {
                $i_a = array_search($a, $compare_func, $strict = true);
                if ($i_a === false) {
                    throw new \Exception('Value not found in sorting array: ' . var_export($a, true));
                }
                $i_b = array_search($b, $compare_func, $strict = true);
                if ($i_b === false) {
                    throw new \Exception('Value not found in sorting array: ' . var_export($b, true));
                }
                return ($i_a <=> $i_b);
            });
        } else {
            throw new \Exception('Invalid comparison function: ' . var_export($compare_func, true));
        }
        if ($is_array_list) {
            $this->items = array_values($this->items);
        }
        return $this;
    }

    public function rsort(/*callable|int|array|null*/ $compare_func = null) : self {
        if ($compare_func === null) {
            $compare_func = SORT_REGULAR;
        }
        rsort($this->items, $compare_func);
        return $this;
    }

    public function ksort(/*callable|int*/ $compare_func = null) : self {
        if ($compare_func === null) {
            $compare_func = SORT_REGULAR;
        }
        $is_array_list = is_array_list($this->items);
        if (is_int($compare_func)) {
            ksort($this->items, $compare_func);
        } else if (is_callable($compare_func)) {
            uksort($this->items, $compare_func);
        } else {
            throw new \Exception('Invalid comparison function: ' . var_export($compare_func, true));
        }
        if ($is_array_list) {
            $this->items = array_values($this->items);
        }
        return $this;
    }

    public function keys() : self {
        $this->items = array_keys($this->items);
        return $this;
    }

    public function keepKeys(array $keep_keys) : self {
        foreach ($this->items as $key => $value) {
            if (!in_array_strict($key, $keep_keys)) {
                unset($this->items[$key]);
            }
        }
        return $this;
    }

    public function removeKeys(array $remove_keys) : self {
        foreach ($this->items as $key => $value) {
            if (in_array_strict($key, $remove_keys)) {
                unset($this->items[$key]);
            }
        }
        return $this;
    }

    public function keepValues(array $keep_values) : self {
        $is_array_list = is_array_list($this->items);
        foreach ($this->items as $key => $value) {
            if (!in_array_strict($value, $keep_values)) {
                unset($this->items[$key]);
            }
        }
        if ($is_array_list) {
            $this->items = array_values($this->items);
        }
        return $this;
    }

    public function removeValues(array $remove_values) : self {
        $is_array_list = is_array_list($this->items);
        foreach ($this->items as $key => $value) {
            if (in_array_strict($value, $remove_values)) {
                unset($this->items[$key]);
            }
        }
        if ($is_array_list) {
            $this->items = array_values($this->items);
        }
        return $this;
    }

    public function copy() : self {
        return new self($this->items);
    }

    public function prefix(string $prefix) : self {
        foreach ($this->items as $key => $item) {
            $this->items[$key] = $prefix . ((string)$item);
        }
        return $this;
    }

    public function suffix(string $suffix) : self {
        foreach ($this->items as $key => $item) {
            $this->items[$key] = ((string)$item) . $suffix;
        }
        return $this;
    }

    public function wrap(string $str) : self {
        return $this->prefix($str)->suffix($str);
    }

    private function &_pend(array $keys) : array {
        $pend_to = &$this->items;
        foreach ($keys as $key) {
            if (!is_string($key) && !is_int($key)) {
                throw new \Exception('Invalid key type. Expecting string or integer, got: ' . var_export(gettype($key), true));
            }
            if (!array_key_exists($key, $pend_to)) {
                $pend_to[$key] = [];
            }
            if (!is_array($pend_to[$key])) {
                throw new \Exception('Specified key does not point to an array: ' . $key);
            }
            $pend_to = &$pend_to[$key];
        }
        return $pend_to;
    }

    private function merge(array $arr1, array $arr2) : array {
        if (is_array_list($arr1) && is_array_list($arr2)) {
            return array_merge($arr1, $arr2);
        } else {
            foreach ($arr2 as $key => $value) {
                $arr1[$key] = $value;
            }
            return $arr1;
        }
    }

    public function unshift($element) : self {
        array_unshift($this->items, $element);
        return $this;
    }

    public function push($element) : self {
        array_push($this->items, $element);
        return $this;
    }

    public function prepend(array $arr, array $subkeys = []) : self {
        $prepend_to = &$this->_pend($subkeys);
        $prepend_to = $this->merge($arr, $prepend_to);
        return $this;
    }

    public function prependIf(array $arr, /*bool|callable*/ $test, array $subkeys = []) : self {
        if (is_callable($test)) {
            $test = $test($this);
        }
        if ($test) {
            return $this->prepend($arr, $subkeys);
        } else {
            return $this;
        }
    }

    public function append(array $arr, array $subkeys = []) : self {
        $append_to = &$this->_pend($subkeys);
        $append_to = $this->merge($append_to, $arr);
        return $this;
    }

    public function appendIf(array $arr, /*bool|callable*/ $test, array $subkeys = []) : self {
        if (is_callable($test)) {
            $test = $test($this);
        }
        if ($test) {
            return $this->append($arr, $subkeys);
        } else {
            return $this;
        }
    }

    public function dump() : void {
        var_dump($this->items);
    }

    public function shift() {
        return array_shift($this->items);
    }

    public function pop() {
        return array_pop($this->items);
    }

    public function toArray() : array {
        return $this->items;
    }

    public function implode(string $glue) : string {
        return implode($glue, $this->items);
    }

    public function toJson() : string {
        return json_encode_utf8($this->items);
    }

    public function isEmpty() : bool {
        return (count($this->items) === 0);
    }

    public function isNotEmpty() : bool {
        return (count($this->items) > 0);
    }

    public function getSize() : int {
        return count($this->items);
    }

    public function find(/*int|string*/ $key, $default_value = null) {
        if (is_string($key) || is_int($key)) {
            if (array_key_exists($key, $this->items)) {
                return $this->items[$key];
            } else {
                return $default_value;
            }
        } else {
            throw new \Exception('Invalid key type. Expecting string or integer, got: ' . var_export(gettype($key), true));
        }
    }

    public function get(/*int|string*/ $key) {
        return $this->items[$key];
    }

}

