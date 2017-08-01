<?php
declare(strict_types=1);

namespace Reader\Libs;

use Reader\Interfaces\IMap;

class Map implements IMap {
    private $size;
    private $data = [];

    function __construct(int $size) {
        $this->size = $size;
    }

    public function set(string $key, $value):void {
        $this->data[$key] = $value;
    }
    
    public function get(string $key) {
        return $this->data[$key];
    }

    public function has(string $key):bool {
        return array_key_exists($key, $this->data);
    }

    public function each(callable $callback):void {
        foreach($this->data as $key => $value) {
            $callback($key, $value);
        }
    }

    public function isFull():bool {
        return $this->count() >= $this->size;
    }

    public function count():int {
        return count($this->data);
    }

    public function clear():void {
        $this->data = [];
    }

    public function toArray(callable $callback):array {
        $data = [];

        foreach($this->data as $key => $value) {
            array_push($data, $callback($key, $value));
        }

        return $data;
    }
}