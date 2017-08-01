<?php
declare(strict_types=1);

namespace Reader\Interfaces;

interface IStorage
{
    public function clear():void;
    public function save(string $word, int $count):void;
    public function has(string $word):bool;
    public function count():int;
    public function getData(int $limit, int $offset):array;
}