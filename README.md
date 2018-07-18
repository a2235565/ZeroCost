#  2017-3-15   code by yzy <br/>
目录结构  <br/>
Cache 缓存文件 <br/>
Task 队列文件夹 <br/>
&nbsp;&nbsp;|-TaskTest5.php 队列示例 <br/>
&nbsp;&nbsp;|-TaskTest7.php 队列示例 <br/>
Config 配置文件 <br/>
&nbsp;&nbsp;|-aotoLoad.php 自动加载项 <br/>
&nbsp;&nbsp;|-conf.php 系统配置项 <br/>
&nbsp;&nbsp;|-dbConf.php 数据库配置项 <br/>
Core 核心 <br/>
&nbsp;&nbsp;|-Autoload.php 自动加载函数 <br/>
&nbsp;&nbsp;|-Controller.php 控制器父类 <br/>
&nbsp;&nbsp;|-Error.php 报错监控类 <br/>
&nbsp;&nbsp;|-error.tpl 报错模板 <br/>
&nbsp;&nbsp;|-function.php 公共函数 <br/>
&nbsp;&nbsp;|-Register.php 注册树 <br/>
&nbsp;&nbsp;|-ZeroCost.php 核心 <br/>
&nbsp;&nbsp;|-Task_Php5.php 队列接口类 <br/>
&nbsp;&nbsp;|-Task_Php7.php 队列接口类 <br/>
Db 数据库 <br/>
&nbsp;&nbsp;|-medoo.php   medoo 数据库扩展类 <br/>
Log 日志 <br/>
Model 数据模型目录 <br/>
&nbsp;&nbsp;|-Index.php  测试实例model <br/>
Project 控制器目录  <br/>
&nbsp;&nbsp;|-Index 模块名 <br/>
&nbsp;&nbsp;&nbsp;&nbsp;|-Index.php 控制器 <br/>
&nbsp;&nbsp;|-System 模块名(系统内置) <br/>
&nbsp;&nbsp;&nbsp;&nbsp;|-TaskList.php Web队列基础 <br/>
Route 路由 <br/>
&nbsp;&nbsp;|-Route.php 路由文件 <br/>
WebRoot <br/>
&nbsp;&nbsp;|-index.php 网站入口 <br/>
View 视图层 <br/>
&nbsp;&nbsp;|-index.html 模板 <br/>
README.md <br/>
<br/>
根据 yzymvc修改<br/>
路由规则  get   ?m=xx&c=xx&a=xx <br/>


<pre>

This is ApacheBench, Version 2.3 <$Revision: 655654 $>
Copyright 1996 Adam Twiss, Zeus Technology Ltd, http://www.zeustech.net/
Licensed to The Apache Software Foundation, http://www.apache.org/

Benchmarking 127.0.0.1 (be patient)
Completed 50000 requests
Completed 100000 requests
Completed 150000 requests
Completed 200000 requests
Completed 250000 requests
Completed 300000 requests
Completed 350000 requests
Completed 400000 requests
Completed 450000 requests
Completed 500000 requests
Finished 500000 requests


Server Software:        nginx
Server Hostname:        ---------
Server Port:            80

Document Path:          /
Document Length:        162 bytes

Concurrency Level:      100
Time taken for tests:   33.491 seconds
Complete requests:      500000
Failed requests:        0
Write errors:           0
Non-2xx responses:      500000
Total transferred:      152500000 bytes
HTML transferred:       81000000 bytes
Requests per second:    14929.44 [#/sec] (mean)
Time per request:       6.698 [ms] (mean)
Time per request:       0.067 [ms] (mean, across all concurrent requests)
Transfer rate:          4446.76 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    0   0.5      0       5
Processing:     1    6   2.9      6     164
Waiting:        0    6   3.0      6     164
Total:          3    7   2.8      7     164

Percentage of the requests served within a certain time (ms)
  50%      7
  66%      8
  75%      8
  80%      8
  90%      9
  95%      9
  98%     10
  99%     11
 100%    164 (longest request)
</pre>
