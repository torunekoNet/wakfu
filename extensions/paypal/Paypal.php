<?php

/**
 * File: Paypal.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 16/2/26 13:43
 * Description:
 */
class Paypal extends CApplicationComponent
{

    public $gateway;
    public $buttonId;

    public function verify(array $post, $timeout = 30000, $connection_timeout = 30000)
    {
        $request = array(
            'cmd' => '_notify-validate'
        );
        foreach ($post as $key => $value) {
            $request[$key] = urldecode($value);
        }

        $options = array(
            CURLOPT_POST => 1,              // 请求方式为POST
            CURLOPT_URL => $this->gateway,  // 请求URL
            CURLOPT_RETURNTRANSFER => 1,    // 获取请求结果
            CURLOPT_FORBID_REUSE => 1,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            // -----------请确保启用以下两行配置------------
            CURLOPT_SSL_VERIFYPEER => 1,    // 验证证书
            CURLOPT_SSL_VERIFYHOST => 2,    // 验证主机名
            // -----------否则会存在被窃听的风险------------
            CURLOPT_POSTFIELDS => http_build_query($request) // 注入接口参数
        );
        if (defined(CURLOPT_TIMEOUT_MS)) {
            $options[CURLOPT_NOSIGNAL] = 1;
            $options[CURLOPT_TIMEOUT_MS] = $timeout;
        } else {
            $options[CURLOPT_TIMEOUT] = ceil($timeout / 1000);
        }
        if (defined(CURLOPT_CONNECTTIMEOUT_MS)) {
            $options[CURLOPT_CONNECTTIMEOUT_MS] = $connection_timeout;
        } else {
            $options[CURLOPT_CONNECTTIMEOUT] = ceil($connection_timeout / 1000);
        }

        $ch = curl_init();
        curl_setopt_array($ch, $options);
        $response = curl_exec($ch);
        curl_close($ch);

        if (!$response) {
            Yii::log("Can't connect to PayPal to validate IPN message: " . curl_error($ch), CLogger::LEVEL_ERROR);
            return false;
        }

        $tokens = explode("\r\n\r\n", trim($response));
        $res = trim(end($tokens));

        return strcmp($res, "VERIFIED") == 0;
    }
}