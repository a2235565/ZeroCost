<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/14
 * Time: 23:41
 */
namespace Project\Home;
use Core\Controller;

class Index extends Controller{
    function Index(){
        M('Index')->test();
    }
}