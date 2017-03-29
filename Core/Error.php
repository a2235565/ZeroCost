<?php
namespace ZeroCost\Core;
class Common_Error
{
    /**
     * 先定义一个错误处理函数，也可以定义在其他的文件中，再用require()调用
     *
     * @param $errno 错误编号
     * @param $errstr 错误消息
     * @param $errfile 错误所在的文件
     * @param $errline 错误所在的行
     * @return bool
     */
    static public function ErrorHandler($errno, $errstr, $errfile, $errline) {
        // 为了安全起见，不暴露出真实物理路径，下面两行过滤实际路径
        $config = include(ROOTPATH . "/Config/conf.php");
        if(!$config['debug'])die();
        if($config['is_api']){
            echo json_encode(array('code'=>$errno,'info'=>$errline));
            die();
        }
        $errfile = str_replace(getcwd(), "", $errfile);
        $errstr = str_replace(getcwd(), "", $errstr);
        $error = '<br />';
        switch ($errno) {
            case E_USER_ERROR:
                $error .= "<b>My ERROR</b> [$errno] $errstr<br />";
                break;
            case E_USER_WARNING:
                $error .=  "<b>My WARNING</b> [$errno] $errstr<br />";
                break;
            case E_USER_NOTICE:
                $error .=  "<b>My NOTICE</b> [$errno] $errstr<br />";
                break;
            case 8192:
                return true;
                break;
            default:
                $error .=  "Unknown error type: [$errno] $errstr<br />";
                break;
        }
        $error .= "Fatal error on line ".$errline." in file $errfile";
        $error .= ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />";
        @ob_end_clean();
        // 包含异常页面模板
        require_once('error.tpl');

        return true;


    }
    // 致命错误捕获
    static public function fatalError() {
        if ($e = error_get_last()) {
            switch($e['type']){
                case E_ERROR:
                case E_PARSE:
                case E_CORE_ERROR:
                case E_COMPILE_ERROR:
                case E_USER_ERROR:
                if (ob_get_contents()) ob_end_clean();
                    self::halt($e);
                    break;
            }
        }
    }


    /**
     * 错误输出
     * @param mixed $e 错误
     * @return void
     */
    static public function halt($e) {
        $str = array();
        //调试模式下输出错误信息
        if (!is_array($e)) {
            $trace          = debug_backtrace();
            $str['message']   = $e;
            $str['file']      = $trace[0]['file'];
            $str['line']      = $trace[0]['line'];
            ob_start();
            debug_print_backtrace();
            $e['trace']     = ob_get_clean();
        } else {
            $str              = $e;
        }
        $error = '<br />';
        $error .= "<b>My ERROR</b> " . $str['message'] . "<br />";
        $error .= "Fatal error on line " . $str['file'] . " in file " . $str['line'] . "";
        $error .= ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />";
        // 包含异常页面模板
        require_once('error.tpl');
        exit;
    }
    /**
     * 自定义异常处理
     * @access public
     * @param mixed $e 异常对象
     */
    static public function appException($e) {
        $error = array();
        $error['message']   =   $e->getMessage();
        $trace              =   $e->getTrace();
        if('E'==$trace[0]['function']) {
            $error['file']  =   $trace[0]['file'];
            $error['line']  =   $trace[0]['line'];
        }else{
            $error['file']  =   $e->getFile();
            $error['line']  =   $e->getLine();
        }
        $error['trace']     =   $e->getTraceAsString();
        // 发送404信息
        header('HTTP/1.1 404 Not Found');
        header('Status:404 Not Found');
        self::halt($error);
    }

}

