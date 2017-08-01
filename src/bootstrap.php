<?php

function isExist($path)
{
    return file_exists($path) ? include $path : false;
}

if (!$loader = isExist(__DIR__.'/../vendor/autoload.php')) {
    echo 'Выполни команду `composer install`'.PHP_EOL;
    exit(1);
}

return $loader;