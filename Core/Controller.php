<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/14
 * Time: 23:47
 */
namespace Core;
//use ZeroCost\Core\Register;
class Controller{
   //protected $db;
    function __construct()
    {
        header("Content-Type: text/html; charset=utf8");
        //$this->db = Register::get('db');
    }

    function  display($file)
    {
        $file = ROOTPATH . "/View/{$file}.html";
        if (is_file($file)) {
            include $file;
//            $str = file_get_contents($file);
//            echo($str);
        } else {
            trigger_error('找不到模板' . $file, E_USER_ERROR);
        }
    }
}
