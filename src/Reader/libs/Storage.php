<?php
declare(strict_types=1);

namespace Reader\Libs;

use Reader\Interfaces\IStorage;

class Storage implements IStorage {
    private $client;
    private $collection;

    function __construct($client) {
        $this->client = $client;
        
        $this->initCollection();
        $this->clear();
    }

    private function initCollection():void {
        $this->collection = $this->client->reader->data;
    }

    public function clear():void {
        $this->collection->drop();
    }

    public function save(string $word, int $count):void {
        if ($this->has($word)) {
            $this->collection->updateOne(
                ['word' => $word],
                ['$inc' => [
                        'count' => $count
                    ]
                ]
            );
        } else {
            $this->collection->insertOne([
                'word' => $word,
                'count' => $count
            ]);
        }
    }

    public function count():int {
        return $this->collection->count();
    }

    public function getData(int $limit, int $offset):array {
        return array_map(function($item) {
            return [
                'count' => $item->count,
                'word' => $item->word
            ];
        }, $this->collection->find(
            [],
            [
                'limit' => $limit,
                'skip' => $offset
            ]
        )->toArray());
    }

    public function has(string $word):bool {
        return !is_null($this->collection->findOne(['word' => $word]));
    }
}
