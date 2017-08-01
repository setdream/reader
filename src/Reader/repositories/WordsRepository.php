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
        $item = $this->map->get($word);

        if (!is_null($item)) {
            $this->map->set($word, $item['count'] + 1);
        } else {
            if ($this->map->isFull()) {
                $this->sync();
            }

            $this->map->set($word, 1);
        }
    }

    public function sync():void {
        $this->map->each(function($item) {
            $this->storage->save($item['word'], $item['count']);
        });

        $this->map->clear();
    }

    public function each(callable $callback, int $offset = 0):void {
         while($this->map->init(
             $this->storage->getData($this->limit, $offset))->count() > 0) {
                $callback($this->map->toArray());
                $offset += $this->limit;
         }
    }
}