<?php

/**
 * File: WakfuQueue.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 15/6/8 23:13
 * Description:
 */
class WakfuQueue
{
    public static function enqueue($task)
    {
        $create = date('Y-m-d H:i:s');

        $length = count($task);
        for ($i = 0; $i < $length; $i++) {
            $task[$i]['gmt_create'] = $create;
        }

        $db = Yii::app()->db;
        $db->setActive(true);
        $command = new RedDbCommand($db);
        return $command->insertSeveral('queue', $task);
    }

    public static function  dequeue()
    {
        $records = Yii::app()->db->createCommand()
            ->select()->from('queue')
            ->where('status=0')
            ->queryAll();

        foreach ($records as $record) {
            Yii::app()->db->createCommand()
                ->update('queue', array(
                    'status' => 1
                ), 'id=:id', array(
                    'id' => $record['id']
                ));
        }

        return CJSON::encode($records);
    }

    public static function complete($id)
    {
        return Yii::app()->db->createCommand()
            ->update('queue', array(
                'status' => 2,
                'gmt_modified' => date('Y-m-d H:i:s')
            ), 'id=:id', array(
                'id' => $id
            ));
    }

    public static function createTask($url, $uid)
    {
        $accessKey = Yii::app()->params['secretKey'];
        return array(
            'url' => $url,
            'postdata' => CJSON::encode(array('uid' => $uid, 'accessKey' => $accessKey))
        );
    }

    public static function apiCreate($uid)
    {
        $task = WakfuQueue::createTask('create', $uid);
        return WakfuQueue::enqueue(array($task));
    }

    public static function apiReset($uid)
    {
        $task = WakfuQueue::createTask('reset', $uid);
        return WakfuQueue::enqueue(array($task));
    }

    public static function apiOpen($uid)
    {
        $url = Yii::app()->createUrl('api/open');
        $task = WakfuQueue::createTask($url, $uid);
        return WakfuQueue::enqueue(array($task));
    }

    public static function apiClose($uid)
    {
        $url = Yii::app()->createUrl('api/close');
        $task = WakfuQueue::createTask($url, $uid);
        return WakfuQueue::enqueue(array($task));
    }

    public static function apiPac($uid)
    {
        $url = Yii::app()->createUrl('api/pac');
        $task = WakfuQueue::createTask($url, $uid);
        WakfuQueue::enqueue(array($task));
    }
}