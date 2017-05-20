<?php

/**
 * File: PaymentController.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 16/2/25 22:33
 * Description:
 */
class PaymentController extends RedController
{
    public function actionIndex()
    {
        $query = array('uid' => $this->user->getId());
        $model = Payment::model();
        $model->attributes = $query;
        $condition = array('condition' => 'uid=:uid', 'params' => array('uid' => $query['uid']));
        $pager = new CPagination($model->count($condition));
        $pager->setPageSize(20);
        $condition['offset'] = $pager->getOffset();
        $condition['limit'] = $pager->getLimit();
        $condition['order'] = 'datetime desc';
        $data = $model->findAll($condition);
        $paypal = $this->app->getComponent('paypal');
        $this->render('index', array(
            'data' => new RedArrayDataProvider($data),
            'pager' => $pager,
            'gateway' => $paypal->gateway,
            'buttonId' => $paypal->buttonId
        ));
    }

    public function actionSuccess()
    {
        $request = $this->request;
        $tx = $request->getQuery('tx');
        $item_number = $request->getQuery('item_number');
        $item = $this->getTraffic($item_number);
        $amount = urldecode($request->getQuery('amt'));
        if (empty($tx) || empty($item) || empty($amount)) {
            $this->redirect($this->createUrl('index'));
        }
        $payment = Payment::model()->find('txn_id=:tx', array('tx' => $tx));
        if (empty($payment)) {
            $this->render('success', array(
                'success' => false,
                'message' => 'Payment Order are processed，Waiting a minutes',
                'item' => $item,
                'amount' => $amount,
            ));
        } else {
            $this->render('success', array(
                'success' => true,
                'message' => 'Order Completed',
                'item' => $item,
                'amount' => $amount,
            ));
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

    public function allowGuest()
    {
        if (Yii::app()->user->isGuest) {
            $this->redirect($this->app->createAbsoluteUrl('index'));
        }
    }
}