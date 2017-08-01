<?php
declare(strict_types=1);

namespace Reader\Helpers;


function isAlphaNumChar($char):bool {
    return ctype_alnum($char);
}

function isSpecialChar($char):bool {
    return $char === "\n" || $char === "\t" || $char === " " || $char === false;
}