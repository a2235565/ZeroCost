#  2017-3-15   code by yzy <br/>
目录结构  <br/>
Cache 缓存文件 <br/>
Task 队列文件夹 <br/>
&nbsp;&nbsp;|-TaskTest.php 队列示例 <br/>
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
