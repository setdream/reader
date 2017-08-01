<?php
declare(strict_types=1);

namespace Reader\Interfaces;

interface IMap
{
    public function set(string $key, $value):void;
    public function get(string $key);
    public function has(string $key):bool;
    public function each(callable $callback):void;
    public function count():int;
    public function clear():void;
    public function isFull():bool;
}