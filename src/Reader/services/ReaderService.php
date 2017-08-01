<?php
/*
 *  Достойно ль
 *  Смиряться под ударами судьбы,
 *  Иль надо оказать сопротивленье
 *  И в смертной схватке с целым морем бед
 *  Покончить с ними? Умереть. Забыться. ... (У. Шекспир)
*/
declare(strict_types=1);

namespace Reader\Services;

use Reader\Libs\FileReader;
use Reader\Libs\Storage;
use Reader\Repositories\WordsRepository;

class ReaderService {
    private $fileReader;
    private $storage;
    private $repository;

    function __construct(string $path, \MongoDB\Client $client, int $maxSize) {
        $this->fileReader = new FileReader($path);
        $this->storage = new Storage($client);
        $this->repository = new WordsRepository($this->storage, $maxSize);
    }

    public function load():void {
        $this->fileReader->read(function($word) {
            $this->repository->save($word);
        });

        $this->repository->sync();
        $this->storage->aggregate();
    }

    public function read(callable $callback):void {
        $this->repository->each($callback);
    }
}