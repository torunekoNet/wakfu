<?php

/**
 * File: WakfuController.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 15/5/29 18:49
 * Description:
 */
class WakfuController extends Controller
{

    public function getActions()
    {
        return array(
            'service', 'traffic', 'pac',
            'switch', 'reset', 'purchase',
            'statistics', 'mail', 'queue'
        );
    }

    public function createSearchCriteria($data = array())
    {
        $condition = '';
        $params = array();
        if (!empty($data)) {
            $con = array();
            foreach ($data as $key => $value) {
                if (empty($value)) continue;
                $con[] = $key . '=:' . $key;
                $params[$key] = $value;
            }
            $condition = join(' AND ', $con);
        }
        return array('condition' => $condition, 'params' => $params);
    }

    public function getStatusDisplay($status)
    {
        $display = array('正常', '欠费', '禁用', '幸存');
        return $display[$status];
    }
}