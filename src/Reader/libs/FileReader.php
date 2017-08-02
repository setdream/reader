<?php
declare(strict_types=1);

namespace Reader\Libs;

use Reader\Helpers as Helpers;
use Reader\Interfaces\IReader;

class FileReader implements IReader {
    const READ_STRING_LENGTH = 4096;

    private $resource;

    function __construct(string $path) {
        $this->resource = fopen($path, "r");
    }

    public function read(callable $callback):void {
        $word = '';

        do {
            $char = fgetc($this->resource);

            if (Helpers\isSpecialChar($char)) {
                if (!empty($word)) {
                    $callback($word);

                    $word = '';
                }
            } else if (Helpers\isAlphaNumChar($char)) {
                $word .= $char;
            }

        } while (false !== $char);
    }

    public function readString(callable $callback):void {
        while (($buffer = fgets($this->resource, self::READ_STRING_LENGTH)) !== false) {
            foreach(str_word_count($buffer, 1) as $word) {
                $callback($word);
            }
        }
    }

    function __destruct() {
        if ($this->resource) {
            fclose($this->resource);
        }
   }
}