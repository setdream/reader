<?php
declare(strict_types=1);

namespace Reader\Interfaces;

interface IReader
{
    public function read(callable $callback):void;
}