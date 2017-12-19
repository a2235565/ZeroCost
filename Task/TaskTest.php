<?php
namespace Task;
use ZeroCost\Core\Task;
class TaskTest implements Task{
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
        taskForWebRun('\Task\TaskTest',100);
    }
}
