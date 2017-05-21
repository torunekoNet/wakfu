<?php

/**
 * File: TaskController.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 15/6/6 23:07
 * Description:
 */
class TaskController extends RedController
{

    private function checkAccessKey()
    {
        $accessKey = $this->request->getPost('accessKey', false);
        $secretKey = Yii::app()->params['secretKey'];
        if ($accessKey != $secretKey) {
            Yii::log("[" . $accessKey . "]API accessKey auth fail", CLogger::LEVEL_INFO);
            Yii::app()->end();
        }
    }

    public function actionDequeue()
    {
        $this->checkAccessKey();

        echo WakfuQueue::dequeue();
    }

    public function actionComplete()
    {
        $this->checkAccessKey();

        $id = $this->request->getPost('id');
        if (WakfuQueue::complete($id)) {
            echo "success";
        }
    }

    public function actionPac()
    {
        $this->checkAccessKey();

        $services = Service::model()->findAllByAttributes(array('status' => 0));
        $task = array();
        $url = $this->app->createUrl('api/pac');
        foreach ($services as $service) {
            if ($service->uid == 1 || $service->uid == 2) continue;
            $task[] = WakfuQueue::createTask($url, $service->uid);
        }

        if (WakfuQueue::enqueue($task)) {
            echo "Success";
        } else {
            echo "Failed";
        }
    }

    public function actionChrome()
    {
        $this->checkAccessKey();

        $services = Service::model()->findAllByAttributes(array('status' => 0));
        $task = array();
        $url = $this->app->createUrl('api/chrome');
        foreach ($services as $service) {
            if ($service->uid == 1 || $service->uid == 2) continue;
            $task[] = WakfuQueue::createTask($url, $service->uid);
        }

        if (WakfuQueue::enqueue($task)) {
            echo "Success";
        } else {
            echo "Failed";
        }
    }

    public function actionView()
    {
        $this->checkAccessKey();

        $services = Service::model()->findAllByAttributes(array('status' => 0));
        $task = array();
        $url = $this->app->createUrl('api/view');
        foreach ($services as $service) {
            $task[] = WakfuQueue::createTask($url, $service->uid);
        }

        if (WakfuQueue::enqueue($task)) {
            echo "Success";
        } else {
            echo "Failed";
        }
    }

    public function actionSave()
    {
        $this->checkAccessKey();

        $services = Service::model()->findAllByAttributes(array('status' => 0));
        $task = array();
        $url = $this->app->createUrl('api/trafficSave');
        foreach ($services as $service) {
            if ($service->used == 0) continue;
            $task[] = WakfuQueue::createTask($url, $service->uid);
        }
        if (WakfuQueue::enqueue($task)) {
            echo "Success";
        } else {
            echo "Failed";
        }
    }
}