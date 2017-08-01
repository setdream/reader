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

    public function insertFromArray(array $data):void {
        $this->collection->insertMany($data);
    }

    public function aggregate():void {
        $this->collection->aggregate([
            ['$group' => ['_id' => '$word', 'count' => ['$sum' => '$count']]],
            ['$out' => 'data']
        ]);
    }

    public function each(int $limit, int $offset, callable $callback):int {
        $count = 0;

        foreach($this->collection->find([], [
                'limit' => $limit,
                'skip' => $offset
        ]) as $item) {
            $callback($item->_id, $item->count);
            $count++;
        }

        return $count;
    }
}
