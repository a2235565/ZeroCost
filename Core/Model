<?php
namespace ZeroCost\Core;
class Model
{
    protected $db = null;
    function __construct(){
        $conf = include ROOTPATH . '/Config/conf.php';
        if($conf['debug']){
            //开发模式方便IDE提示
            $this->db =  new \Db\medoo(include ROOTPATH . '/Config/dbConf.php');
        }else{
            //部署模式使用
            $this->db =  \ZeroCost\Core\Register::get('db');
        }
    }

    /**
     * ide 方法提示
     * @return \Db\medoo
     */
    function functionList(){
        return new \Db\medoo(include ROOTPATH . '/Config/dbConf.php');
    }
}
