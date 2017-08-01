<?php
declare(strict_types=1);

namespace Reader\ReaderServiceTest;

use PHPUnit\Framework\TestCase;
use Reader\Services\ReaderService;

/*
* @covers Reader Service
*/
class ReaderServiceTest extends TestCase
{
    protected static $readerService;
    protected static $client;

    public static function setUpBeforeClass()
    {
        self::$client = new \MongoDB\Client("mongodb://localhost:27017");
        self::$readerService = new ReaderService(
            __DIR__.'/fixtures/awesome.txt', 
            self::$client,
            1000
        );
    }

    public function testSmallFileRead():void
    {
        self::$readerService->load();

        $total = 0;
        $cb = function($word, $count) use (&$total) {
            $total += $count;
        };

        self::$readerService->read(function($map) use ($cb) {
            $map->each($cb);
        });

        $this->assertEquals($total, 13);
    }

    public static function tearDownAfterClass()
    {
        self::$readerService = null;
    }
}