<?php
/**
 * Created by PhpStorm.
 * User: yzy
 * ZeroCost 入口
 */

define('ROOTPATH',dirname(__DIR__));
require_once ROOTPATH.'/Core/ZeroCost.php';
$core=new \ZeroCost\Core\ZeroCost();
$core->run();