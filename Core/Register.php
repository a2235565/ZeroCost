<?php
namespace ZeroCost\Core;
class Register
{
    protected  static  $obj;
    static function  set($name,$bbj)
    {
        self::$obj[$name]=$bbj;
    }
    static  public function get($name)
    {
        return( self::$obj[$name]);
    }
    static  public function _unset($name)
    {
        unset( self::$obj[$name]);
    }
}