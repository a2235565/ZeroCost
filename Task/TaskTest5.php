<?php
namespace Task;
use ZeroCost\Core\Task_Php5;

class TaskTest5 implements Task_Php5 {
    function run($page)
    {
        // TODO: Implement run() method.
    }
    function isException(\Exception $e)
    {
        // TODO: Implement isException() method.
    }
    function go(){
        //运行入口
        taskForWebRun('\Task\TaskTest5',100);
    }
}
