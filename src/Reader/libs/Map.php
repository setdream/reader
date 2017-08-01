<?php
declare(strict_types=1);

namespace Reader\Libs;

class Map {
    private $size;
    private $data = [];

    function __construct(int $size) {
        $this->size = $size;
    }

    public function init(array $data):Map {
        $this->data = $data;

        return $this;
    }

    private function search(string $key) {
        return array_search($key, array_column($this->data, 'word'));
    }

    public function set(string $key, int $value):void {
        $index = $this->search($key);

        if ($index) {
            $this->data[$index]['count'] = $value;
        } else {
            array_push($this->data, [
                'count' => $value,
                'word' => $key
            ]);
        }
    }
    
    public function get(string $key) {
        $index = $this->search($key);

        return $index ? $this->data[$index] : null;
    }

    public function has(string $key):bool {
        return !is_null($this->get($key));
    }

    public function each(callable $callback):void {
        foreach($this->data as $item) {
            $callback($item);
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

    public function toArray():array {
        return $this->data;
    }
}