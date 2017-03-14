<?php
namespace ZeroCost\Core;
class Autoload
{
    static function  autoload($class)
    {
        $class = ROOTPATH . '/' . $class . '.php';
        $class = str_replace('\\', '/', $class);
        if (file_exists($class)) require_once $class;
    }
}