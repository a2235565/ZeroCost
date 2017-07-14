<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/14
 * Time: 23:41
 */
namespace Project\Home;

use Core\Controller;

class Index extends Controller
{
    function Index()
    {
        $opend_id = getOption('get', 'open_id');
        $rsData = M('Index')->CheckOpenid($opend_id);
        if (!empty($rsData)){
            if($arr= M('Index')->getRoom($opend_id)){
                $rsData[0]['array']=$arr;
            }
            return array('code'=>200,'data'=>$rsData[0]);
        }
        else
            return array('msg' => '您未注册请前往注册', 'code' => 500);
    }

    function getOpen_id(){
        $get=getOption('get');
        $url="https://api.weixin.qq.com/sns/jscode2session?appid={$get['appid']}&secret={$get['secret']}&grant_type=authorization_code&js_code={$get['js_code']}";
        $json = file_get_contents($url);
        return json_decode($json,1);
    }
    function room(){
        $opend_id = getOption('get', 'open_id');
        $rsData = M('Index')->getRoom($opend_id);
        if (!empty($rsData))
            return array('code'=>200,'data'=>$rsData);
        else
            return array('code'=>200,'data'=>array());
    }
    function delRoom(){
        $option = getOption('get');
        return M('Index')->delRoom($option);

    }
    function add()
    {
        $data = getOption('get');
        return M('Index')->saveUser($data);
    }
    function addRoom()
    {
        $data = getOption('get');
        return M('Index')->AddRoom($data);
    }

    function notify(){

    }

}