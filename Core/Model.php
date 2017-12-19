<?php
namespace ZeroCost\Core;
class Model
{
    protected $db = null;
    function __construct(){
        //部署模式使用
        $this->db =  \ZeroCost\Core\Register::get('db');
    }
    /**
     * ide 方法提示
     * @return \Db\medoo
     */
    function functionList(){
        return new \Db\medoo(include ROOTPATH . '/Config/dbConf.php');
    }
}
