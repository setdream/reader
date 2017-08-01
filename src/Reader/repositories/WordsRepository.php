<?php
declare(strict_types=1);

namespace Reader\Repositories;

use Reader\Libs\Map;

class WordsRepository {
    private $storage;
    private $map;
    private $limit;

    function __construct(
        \Reader\Libs\Storage $storage, 
        int $maxlen) 
    {
        $this->storage = $storage;
        $this->limit = $maxlen;
        $this->map = new Map($maxlen);
    }

    public function save(string $word):void {
        if ($this->map->has($word)) {
            $this->map->set($word, $this->map->get($word) + 1);
        } else {
            if ($this->map->isFull()) {
                $this->sync();
            }

            $this->map->set($word, 1);
        }
    }

    public function sync():void {
        $this->storage->insertFromArray($this->map->toArray(function($word, $count) {
            return [
                'word' => (string) $word,
                'count' => $count
            ];
        }));

        $this->map->clear();
    }

    public function each(callable $callback, int $offset = 0):void {
        while($this->map->clear() || $this->storage->each($this->limit, $offset, function($word, $count) {
            $this->map->set($word, $count);
        }) > 0) {
            $callback($this->map);
            $offset += $this->limit;
        }
    }
}