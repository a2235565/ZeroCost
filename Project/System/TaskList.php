<?php
/**
 * Created by yzy.
 * User: Administrator
 * Date: 2017/3/14
 * Time: 23:41
 */
namespace Project\System;
use Core\Controller;
class TaskList extends Controller{
    protected $nowRunWhere;
    protected $runUrlPre;
    protected $go;
    protected $taskName;
    function __construct()
    {
        parent::__construct();
        $this->nowRunWhere = 0;
        $nowPage = intval($_GET['page']);
        $taskName = getOption('get','taskName');
        $this->taskName = $taskName;
        $oldPage = getCache($taskName.'pageGoWhere');
        $runUrlPre = '?m=System&c=TaskList&a=run&taskName='.$taskName.'&';
        if($nowPage<$oldPage){
            $this->go = $runUrlPre."page=".$oldPage+2;
            $this->nowRunWhere = $oldPage+1;
            return true;
        }else{
            $this->nowRunWhere = $nowPage;
        }
        $goWhere = $this->nowRunWhere+1;
        $this->go = $runUrlPre."page=".$goWhere;
    }
    function run(){
        $taskList = getCache('task-'.$this->taskName);
        $arr = json_decode($taskList,true);
        if(empty($arr)){
            echo "任务异常Cache未找到";
            return false;
        }
        $file=str_replace('\\','/',$arr['callback']);
        if(file_exists(ROOTPATH . '/' .$file.'.php')){
            $func = new $arr['callback']();
        }else{
            echo "任务异常";
            return false;
        }
        try{
            $power = $func->run($this->nowRunWhere);
        }catch (\Exception $e){
            unlink(ROOTPATH.'/Cache/'.$this->taskName.'pageGoWhere');
            unlink(ROOTPATH.'/Cache/task-'.$this->taskName);
            echo '<br/>任务失败:已执行isException方法';
            $func->isException($e);
            return false;
        }
        if($power){
            if($this->nowRunWhere<$arr['size']){
                setCache($this->taskName .'pageGoWhere',$this->nowRunWhere);
                echo "<script>setTimeout('location=\"{$this->go}\"',500)</script>";
                return true;
            }else{
                unlink(ROOTPATH.'/Cache/'.$this->taskName.'pageGoWhere');
                unlink(ROOTPATH.'/Cache/task-'.$this->taskName);
                echo '<br/>任务完成';
                return true;
            }
        }else{
            unlink(ROOTPATH.'/Cache/'.$this->taskName.'pageGoWhere');
            unlink(ROOTPATH.'/Cache/task-'.$this->taskName);
            echo '<br/>任务完成';
            return true;
        }
    }
}
