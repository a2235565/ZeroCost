<?php
namespace Model;
 class WxPay
{
    /* 首先在服务器端调用微信【统一下单】接口，返回prepay_id和sign签名等信息给前端，前端调用微信支付接口 */
    public function Pay($total_fee, $openid, $order_id,$conf)
    {
        if(empty($conf)){
            echo json_encode(array('code' => 300, 'Msg' => '配置文件未输入'));
            exit;
        }
        if (empty($total_fee)) {
            echo json_encode(array('code' => 301, 'Msg' => '金额有误'));
            exit;
        }
        if (empty($openid)) {
            echo json_encode(array('code' => 302, 'Msg' => '登录失效，请重新登录(openid参数有误)'));
            exit;
        }
        if (empty($order_id)) {
            echo json_encode(array('code' => 303, 'Msg' => '自定义订单有误'));
            exit;
        }
        $appid = $conf['appId'];//如果是公众号 就是公众号的appid;小程序就是小程序的appid
        $body = $conf['orderCon'];
        $mch_id = $conf['mch_id'];
        $KEY = $conf['key'];
        $nonce_str = $conf['nonceStr'];//随机字符串
        $notify_url = $conf['appId'];  //支付完成回调地址url,不能带参数
        $out_trade_no = $order_id;//商户订单号
        $spbill_create_ip = $_SERVER['SERVER_ADDR'];
        $trade_type = 'JSAPI';//交易类型 默认JSAPI

        //这里是按照顺序的 因为下面的签名是按照(字典序)顺序 排序错误 肯定出错
        $post['appid'] = $appid;
        $post['body'] = $body;
        $post['mch_id'] = $mch_id;
        $post['nonce_str'] = $nonce_str;//随机字符串
        $post['notify_url'] = $notify_url;
        $post['openid'] = $openid;
        $post['out_trade_no'] = $out_trade_no;
        $post['spbill_create_ip'] = $spbill_create_ip;//服务器终端的ip
        $post['total_fee'] = intval($total_fee);        //总金额 最低为一分钱 必须是整数
        $post['trade_type'] = $trade_type;
        $sign = $this->MakeSign($post, $KEY);              //签名
        $this->sign = $sign;

        $post_xml = '<xml>
               <appid>' . $appid . '</appid>
               <body>' . $body . '</body>
               <mch_id>' . $mch_id . '</mch_id>
               <nonce_str>' . $nonce_str . '</nonce_str>
               <notify_url>' . $notify_url . '</notify_url>
               <openid>' . $openid . '</openid>
               <out_trade_no>' . $out_trade_no . '</out_trade_no>
               <spbill_create_ip>' . $spbill_create_ip . '</spbill_create_ip>
               <total_fee>' . $total_fee . '</total_fee>
               <trade_type>' . $trade_type . '</trade_type>
               <sign>' . $sign . '</sign>
            </xml> ';

        //统一下单接口prepay_id
        $url = 'https://api.mch.weixin.qq.com/pay/unifiedorder';
        $xml = $this->http_request($url, $post_xml);     //POST方式请求http
        $array = $this->xml2array($xml);               //将【统一下单】api返回xml数据转换成数组，全要大写
        if ($array['RETURN_CODE'] == 'SUCCESS' && $array['RESULT_CODE'] == 'SUCCESS') {
            $time = time();
            $tmp = '';                            //临时数组用于签名
            $tmp['appId'] = $appid;
            $tmp['nonceStr'] = $nonce_str;
            $tmp['package'] = 'prepay_id=' . $array['PREPAY_ID'];
            $tmp['signType'] = 'MD5';
            $tmp['timeStamp'] = "$time";
            $data['code'] = 200;
            $data['timeStamp'] = "$time";           //时间戳
            $data['nonceStr'] = $nonce_str;         //随机字符串
            $data['signType'] = 'MD5';              //签名算法，暂支持 MD5
            $data['package'] = 'prepay_id=' . $array['PREPAY_ID'];   //统一下单接口返回的 prepay_id 参数值，提交格式如：prepay_id=*
            $data['paySign'] = $this->MakeSign($tmp, $KEY);       //签名,具体签名方案参见微信公众号支付帮助文档;
            $data['out_trade_no'] = $out_trade_no;

        } else {
            $data['code'] = 304;
            $data['text'] = "错误";
            $data['RETURN_CODE'] = $array['RETURN_CODE'];
            $data['RETURN_MSG'] = $array['RETURN_MSG'];
        }
        return $data;
    }

    /**
     * 生成签名, $KEY就是支付key
     * @return 签名
     */
    public function MakeSign($params, $KEY)
    {
        //签名步骤一：按字典序排序数组参数
        ksort($params);
        $string = $this->ToUrlParams($params);  //参数进行拼接key=value&k=v
        //签名步骤二：在string后加入KEY
        $string = $string . "&key=" . $KEY;
        //签名步骤三：MD5加密
        $string = md5($string);
        //签名步骤四：所有字符转为大写
        $result = strtoupper($string);
        return $result;
    }

    /**
     * 将参数拼接为url: key=value&key=value
     * @param $params
     * @return string
     */
    public function ToUrlParams($params)
    {
        $string = '';
        if (!empty($params)) {
            $array = array();
            foreach ($params as $key => $value) {
                $array[] = $key . '=' . $value;
            }
            $string = implode("&", $array);
        }
        return $string;
    }

    /**
     * 调用接口， $data是数组参数
     * @return 签名
     */
    public function http_request($url, $data = null, $headers = array())
    {
        $curl = curl_init();
        if (count($headers) >= 1) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        }
        curl_setopt($curl, CURLOPT_URL, $url);

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);

        if (!empty($data)) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }

//获取xml里面数据，转换成array
    private function xml2array($xml)
    {
        $p = xml_parser_create();
        xml_parse_into_struct($p, $xml, $vals, $index);
        xml_parser_free($p);
        $data = "";
        foreach ($index as $key => $value) {
            if ($key == 'xml' || $key == 'XML') continue;
            $tag = $vals[$value[0]]['tag'];
            $value = $vals[$value[0]]['value'];
            $data[$tag] = $value;
        }
        return $data;
    }
}