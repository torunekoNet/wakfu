<?php

/**
 * File: PurchaseAction.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 15/6/3 11:36
 * Description:
 */
class PurchaseAction extends RedAction
{

    public function run()
    {
        $uid = $this->request->getQuery('uid', false);
        if ($uid) {
            $this->render('purchase', array('uid' => $uid));
        } else {
            $uid = $this->request->getPost('uid', 0);
            $traffic = $this->request->getPost('traffic', 0);
            $service = Service::model()->findByPk($uid);
            if (!empty($service) && is_numeric($traffic)) {
                $service->traffic += ($traffic * 100);
                $service->left += ($traffic * 100);
                if ($service->save()) {
                    //保存payment
                    $payment = new Payment();
                    $payment->attributes = array(
                        'uid' => $uid,
                        'email' => $service->email,
                        'txn_id' => "wakfu" . time(),
                        'traffic' => $traffic / 1000,
                        'datetime' => date('Y-m-d H:i:s'),
                        'activity' => $this->user->username
                    );
                    $payment->save();
                    $this->response(200, ':) Success');
                } else {
                    $this->response(500, ':( failed');
                }
            } else {
                $this->response(404, 'Not Found!');
            }
        }
    }
}