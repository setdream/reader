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
            __DIR__.'/fixtures/big.txt', 
            self::$client,
            1000
        );
    }

    public function testSmallFileRead():void
    {
        self::$readerService->load();

        $count = 0;

        self::$readerService->read(function($items) use (&$count) {
            $count += array_reduce($items, function($acc, $item) {
                return $acc + $item['count'];
            }, 0);
        });

        $this->assertEquals($count, 13);
    }

    public static function tearDownAfterClass()
    {
        self::$readerService = null;
    }
}