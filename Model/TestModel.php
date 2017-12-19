<?php
namespace Model;
use \ZeroCost\Core\Model;
class TestModel extends Model
{
    function test(){
        //单例
        $this->db->select();
        //提示
        $this->functionList()->select();
    }
}
