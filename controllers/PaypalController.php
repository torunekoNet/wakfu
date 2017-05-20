<?php

/**
 * File: PaypalController.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 16/2/25 19:52
 * Description:
 */
class PaypalController extends RedController
{

    public function actionNotify()
    {
        $paypal = $this->app->getComponent('paypal');
        $post = CJSON::encode($_POST);
        if ($paypal->verify($_POST)) {
            $uid = $_POST['custom'];
            $username = $_POST['item_name'];
            $item = $_POST['item_number'];
            $status = $_POST['payment_status'];
            $txnId = $_POST['txn_id'];

            if ($status == "Completed") {
                //验证uid和item
                $service = Service::model()->findByPk($uid);
                $traffic = $this->getTraffic($item);
                if (empty($service) || $traffic == 0) {
                    Yii::log("payment message error " . $post, CLogger::LEVEL_ERROR);
                    return;
                }
                //处理流量
                $service->traffic += ($traffic * 100000);
                $service->left += ($traffic * 100000);
                if (!$service->save()) {
                    Yii::log("traffic update error " . $post, CLogger::LEVEL_ERROR);
                    return;
                }
                //保存payment
                $payment = new Payment();
                $payment->attributes = array(
                    'uid' => $uid,
                    'email' => $username,
                    'txn_id' => $txnId,
                    'traffic' => $traffic,
                    'datetime' => date('Y-m-d H:i:s'),
                    'activity' => $post
                );
                if (!$payment->save()) {
                    Yii::log("payment save error " . $post, CLogger::LEVEL_ERROR);
                }
            }
        } else {
            Yii::log("paypal verify failed" . $post, CLogger::LEVEL_ERROR);
        }
    }

    private function getTraffic($item)
    {
        switch ($item) {
            case "10002":
                return 2;
            case "10011":
                return 11;
            case "10025":
                return 25;
            case "10060":
                return 60;
            default:
                return 0;
        }
    }
}