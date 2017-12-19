<?php
namespace ZeroCost\Core;
interface  Task_Php5
{
    /**
     * @param $page 当前任务页码
     * @return true: 当前执行成功 false ：任务结束
     */
    function run($page)  ;

    /**
     * 异常处理
     * @return mixed
     */
    function isException(\Exception $e);
}
