<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/14
 * Time: 23:47
 */
namespace Core;
use ZeroCost\Core\Register;
class Controller{
    protected $db;
    function __construct(){
      $this->db  =  Register::get('db');
    }
}