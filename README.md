#  2017-3-15   code by yzy
目录结构 
Config 配置文件
	|-aotoLoad.php 自动加载项
	|-conf.php 系统配置项
	|-dbConf.php 数据库配置项
Core 核心
	|-Autoload.php 自动加载函数
	|-Controller.php 控制器父类
	|-Error.php 报错监控类
	|-error.tpl 报错模板
	|-function.php 公共函数
	|-Register.php 注册树
	|-ZeroCost.php 核心
Db 数据库
	|-medoo.php   medoo 数据库扩展类
Log 日志
Model 数据模型目录
	|-Index.php  测试实例model
Project 控制器目录 
	|-Index 模块名
		|-Index.php 控制器
Route 路由
	|-Route.php 路由文件
WebRoot
	|-index.php 网站入口
README.md

根据 yzymvc修改 阉割 V 层 
路由规则  get   ?m=xx&c=xx&a=xx