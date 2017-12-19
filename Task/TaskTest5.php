<?php
namespace Task;
use ZeroCost\Core\Task_Php5;

class TaskTest5 implements Task_Php5 {
    function run($page)
    {
        echo $page;
        for($i=0;$i<1000000;$i++)
        {
            rand(1,1000)*rand(1,99999);
        }
        if($page==100){
            return false;
        }
        return true;
        // TODO: Implement run() method.
    }
    function isException(\Exception $e)
    {
        echo 'ok';
        // TODO: Implement isException() method.
    }
    function go(){
        //运行入口
        taskForWebRun('\Task\TaskTest5',100);
    }
}
