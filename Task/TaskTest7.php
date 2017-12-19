<?php
namespace Task;
use ZeroCost\Core\Task_Php7;

class TaskTest7 implements Task_Php7 {
    function run(int $page): bool
    {
        // TODO: Implement run() method.
    }
    function isException(\Exception $e)
    {
        // TODO: Implement isException() method.
    }
    function go(){
        //运行入口
        taskForWebRun('\Task\TaskTest7',100);
    }
}
