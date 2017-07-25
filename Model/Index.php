<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/15
 * Time: 0:08
 */

namespace Model;

class Index {
    protected $db = null;
    function __construct(){
    	 $conf = include ROOTPATH . '/Config/conf.php';
    	 if($conf['debug']){
        //开发模式方便提示
         $this->db =  new \Db\medoo(include ROOTPATH . '/Config/dbConf.php');
    	 }else{
        //部署模式使用
        $this->db =  \ZeroCost\Core\Register::get('db');
        }
    }

    function delRoom($data){
        $saveData=$this->CheckOpenid($data['open_id']);
        $table = 'wx_room';
        if($saveData) {
            $where=array('AND'=>array('open_id'=>$data['open_id'],'id'=>$data['id']));
            return $this->db->update($table, array('status'=>0), $where);
        }
        return 0;
    }

    function CheckOpenid($open_id=null){
        if(!$open_id) return false;
        $table = 'wx_user';
        $columns = '*';
        $where=array('open_id'=>$open_id);
        return   $this->db->select($table, $columns, $where);
    }
    function getRoom($open_id=null){
        if(!$open_id) return false;
        $table = 'wx_room';
        $columns = '*';
        $where=array('AND'=>array('open_id'=>$open_id,'status'=>1));
        $temp=$this->db->select($table, $columns, $where);
        $reten=array();
        foreach($temp as $v){
            $temptag=explode(',',$v['tag']);
            $rs= array();
            foreach($temptag as $k1=>$v1){
                $rs[]=array('keys'=>($k1%3)+1,'tag'=>$v1);
            }
            $v['tag']=$rs;
            $reten[]=$v;
        }
        return  $reten;
    }

    function saveUser($data){
        if($data['open_id']){
            $saveData=$this->CheckOpenid($data['open_id']);
            $table = 'wx_user';
            if($saveData){
                $saveData=$data;
                $where=array('open_id'=>$data['open_id']);
                return $this->db->update($table,$saveData,$where);
            }else{
                return  $this->db->insert($table,$data);
            }
        }
        return false;
    }
    function AddRoom($data){
        if($data['open_id']){
            $saveData=$this->CheckOpenid($data['open_id']);
            $table = 'wx_room';
            if($saveData){
                return $this->db->insert($table,$data);
            }else{
                return 0;
            }
        }
        return false;
    }
    function addOrder($data){
        if($data){
            $table = 'wx_order';
             return $this->db->insert($table,$data);
        }
        return false;
    }

    function saveImg($open_id,$img){
        if($open_id){
            if($this->CheckOpenid($open_id)){
                $table = 'wx_user';
                $where=array('open_id'=>$open_id);
                return $this->db->update($table,array('img'=>$img),$where);
            }else{
                return false;
            }
        }
        return false;
    }

}
