<?php

/**
 * File: Fraudmetrix.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 15/9/21 15:02
 * Description:
 */
class Fraudmetrix extends CApplicationComponent
{

    public $apiUrl;
    public $partnerCode;
    public $secretKey;

    public function invoke(array $params, $timeout = 1000, $connection_timeout = 1000)
    {
        $options = array(
            CURLOPT_POST => 1,            // 请求方式为POST
            CURLOPT_URL => $this->apiUrl,      // 请求URL
            CURLOPT_RETURNTRANSFER => 1,  // 获取请求结果
            // -----------请确保启用以下两行配置------------
            CURLOPT_SSL_VERIFYPEER => 1,  // 验证证书
            CURLOPT_SSL_VERIFYHOST => 2,  // 验证主机名
            // -----------否则会存在被窃听的风险------------
            CURLOPT_POSTFIELDS => http_build_query($this->build($params)) // 注入接口参数
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
        if (!($response = curl_exec($ch))) {
            // 错误处理，按照同盾接口格式fake调用结果
            Yii::log(curl_error($ch), CLogger::LEVEL_ERROR, "fraudmetrix");
            return array(
                "success" => "false",
                "reason_code" => "000:调用API时发生错误[" . curl_error($ch) . "]"
            );
        }
        curl_close($ch);
        return json_decode($response, true);
    }

    private function build(array $param)
    {
        $app = Yii::app();
        $request = $app->request;
        $param = array_merge($param, array(
            'partner_code' => $this->partnerCode,
            'secret_key' => $this->secretKey,
            'token_id' => $app->session->getSessionID(),
            'ip_address' => $request->getUserHostAddress(),
            'user_agent_cust' => $request->getUserAgent(),
            'refer_cust' => $request->getUrlReferrer()
        ));
        return $param;
    }

    public static function login($username, $state = 0)
    {
        $fraudmetrix = Yii::app()->getComponent("fraudmetrix");
        if ($fraudmetrix) {
            return $fraudmetrix->invoke(array(
                'event_id' => 'login_web',
                'account_login' => $username,
                'state' => $state,
            ));
        } else {
            return array('success' => true, 'final_decision' => 'Accept');
        }
    }

    public static function register($username, $email, $password)
    {
        $fraudmetrix = Yii::app()->getComponent('fraudmetrix');
        if ($fraudmetrix) {
            return Yii::app()->fraudmetrix->invoke(array(
                'event_id' => 'register_web',
                'account_login' => $username,
                'account_email' => $email,
                'account_password' => $password
            ));
        } else {
            return array('success' => true, 'final_decision' => 'Accept');
        }
    }
}