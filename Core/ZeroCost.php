<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/14
 * Time: 21:39
 */

namespace ZeroCost\Core;
include_once 'function.php';

class ZeroCost
{
    protected $conf;

    function __construct()
    {
        header("X-Powered-By:ZeroCost");
        $this->conf = include ROOTPATH . '/Config/conf.php';
        $this->autoLoadding();
        spl_autoload_register(array("ZeroCost\\Core\\Autoload", 'autoload'));
        $this->erro();
    }

    function erro(){
        // 设定错误和异常处理
        register_shutdown_function('ZeroCost\Core\Common_Error::fatalError');
        set_error_handler('ZeroCost\Core\Common_Error::ErrorHandler');
        set_exception_handler('ZeroCost\Core\Common_Error::appException');
        date_default_timezone_set('PRC');
    }

    public function run()
    {
      $route =new  \Route\Route();
      $route->run();
    }

    function autoLoadding()
    {
        foreach (include ROOTPATH . '/Config/aotoLoad.php' as $k => $v) {
            $v && require_once ROOTPATH . '/' . $k . '.php';
        }
        class_exists('Db\medoo') && Register::set('db', new \Db\medoo(include ROOTPATH . '/Config/dbConf.php'));
    }
}