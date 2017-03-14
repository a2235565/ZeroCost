<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/15
 * Time: 0:08
 */

namespace Model;


class Index {
    function test(){
        var_dump(M()->query('show databases'));
    }
}