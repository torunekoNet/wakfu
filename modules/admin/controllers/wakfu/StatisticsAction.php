<?php

/**
 * File: StatisticsAction.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 15/8/13 21:56
 * Description:
 */
class StatisticsAction extends RedAction
{

    public function run()
    {
        $operationType = $this->request->getQuery('operationType', 'load');
        if (method_exists($this, $operationType)) {
            call_user_func([$this, $operationType]);
        } else {
            $this->load();
        }
    }

    public function load()
    {
        $this->render('statistics');
    }

    public function traffic()
    {
        $traffic = Service::model()->sum('traffic');
        $serv1 = Service::model()->findByPk(1);
        $serv2 = Service::model()->findByPk(2);
        $traffic -= ($serv1->traffic + $serv2->traffic);
        $left = Service::model()->sum('left');
        $left -= ($serv1->left + $serv2->left);
        $used = $traffic - $left;

        $this->response(200, 'success', array(
            array('name' => '收益', 'value' => array(
                '总额' => round($traffic / 100 / 1024 * 0.8, 2),
                '销售' => round($used / 100 / 1024 * 0.8, 2),
                '库存' => round($left / 100 / 1024 * 0.8, 2)
            )),
            array('name' => '已使用', 'value' => $used / 100),
            array('name' => '未使用', 'value' => $left / 100)
        ));
    }

    public function dailyTraffic()
    {
        $begin = strtotime('first day of this month midnight');
        $end = time();
        $trafficList = Traffic::model()->findAll("date between :begin and :end", array(
            'begin' => date('Y-m-d', $begin),
            'end' => date('Y-m-d', $end)
        ));

        $emailList = array();
        $trafficMap = array();
        foreach ($trafficList as $traffic) {
            $explode = explode('@', $traffic->email);
            $email = $explode[0];
            if (!in_array($email, $emailList)) {
                $emailList[] = $email;
            }
            $trafficMap[$email][$traffic->date] = $traffic->traffic / 100;
        }

        $dayList = array();
        for ($i = $begin; $i <= $end; $i += 86400) {
            $dayList[] = date('Y-m-d', $i);
        }

        $seriesMap = array();
        foreach ($trafficMap as $email => $traffics) {
            foreach ($dayList as $day) {
                $seriesMap[$email][] = isset($traffics[$day]) ? $traffics[$day] : 0;
            }
        }

        $this->response(200, 'success', array(
            'emailList' => $emailList,
            'dayList' => $dayList,
            'seriesMap' => $seriesMap
        ));
    }
}