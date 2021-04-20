<?php

namespace Beautinow\Fedex;


class Request {

    protected $url = "https://fcblogin.fedex.com/API/?version=3.0";

    protected $body;

    protected $live_mode = false;

    public function __construct($live_mode = false)
    {
        $this->live_mode = $live_mode;
    }


    public function setBody($body) {
        $this->body = $body;
    }


    public function send() {

        if ($this->live_mode == false) {
            $this->url = $this->url . '&testMode=1';
        }

        //初始一个curl会话
        $curl = curl_init();

        //设置url
        curl_setopt($curl, CURLOPT_URL,$this->url);

        //设置发送方式：post
        curl_setopt($curl, CURLOPT_POST, true);

        //设置发送数据
        curl_setopt($curl, CURLOPT_POSTFIELDS, $this->body);

        //TRUE 将curl_exec()获取的信息以字符串返回，而不是直接输出
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);

        //执行cURL会话 ( 返回的数据为xml )
        $return_xml = curl_exec($curl);

        //关闭cURL资源，并且释放系统资源
        curl_close($curl);

        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        //先把xml转换为simplexml对象，再把simplexml对象转换成 json，再将 json 转换成数组。
        $value_array = json_decode(json_encode(simplexml_load_string($return_xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);

        return $value_array;
    }

}