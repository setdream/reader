<?php
declare(strict_types=1);

namespace Reader\Interfaces;

interface IStorage
{
    public function clear():void;
    public function insertFromArray(array $data):void;
    public function each(int $limit, int $offset, callable $callback):int;
}