<?php

/**
 * File: ApiController.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 15/6/5 10:05
 * Description:
 */
class ApiController extends RedController
{
    const SUCCESS = "success";

    private $wakfu = null;

    public function init()
    {
        parent::init();

        $this->wakfu = new WakfuService();
    }

    public function actionClose()
    {
        $service = $this->getServiceByUid();
        if ($this->wakfu->close($service)) {
            if ($service->save()) {
                echo self::SUCCESS;
            } else {
                Yii::log("[" . $service->uid . "]API::CLOSE save failed", CLogger::LEVEL_INFO);
            }
        } else {
            Yii::log("[" . $service->uid . "]API::CLOSE failure", CLogger::LEVEL_INFO);
        }
    }

    public function actionRemove()
    {
        $service = $this->getServiceByUid();
        $this->wakfu->remove($service);
        if ($service->save()) {
            echo self::SUCCESS;
        } else {
            Yii::log("[" . $service->uid . "]API::REMOVE save failed", CLogger::LEVEL_INFO);
        }
    }

    public function actionCreate()
    {
        $service = $this->getServiceByUid();
        if ($this->wakfu->create($service)) {
            if ($service->save()) {
                echo self::SUCCESS;
            } else {
                Yii::log("[" . $service->uid . "]API::CREATE save failed", CLogger::LEVEL_INFO);
            }
        } else {
            Yii::log("[" . $service->uid . "]API::CREATE failure", CLogger::LEVEL_INFO);
        }
    }

    public function actionPac()
    {
        $service = $this->getServiceByUid();
        $pac = $this->wakfu->pac($service);
        if ($pac) {
            $url = $this->wakfu->savePac($service, $pac);
            if ($url) {
                if ($service->pac != $url) {
                    $service->pac = $url;
                    if ($service->save()) {
                        echo self::SUCCESS;
                    } else {
                        Yii::log("[" . $service->uid . "]API::PAC save failed", CLogger::LEVEL_INFO);
                    }
                } else {
                    echo self::SUCCESS;
                }
            } else {
                Yii::log("[" . $service->uid . "]API::PAC write storage fail", CLogger::LEVEL_INFO);
            }
        } else {
            Yii::log("[" . $service->uid . "]API::PAC failure", CLogger::LEVEL_INFO);
        }
    }

    public function actionChrome()
    {
        $service = $this->getServiceByUid();
        if ($this->wakfu->createChromeBak($service)) {
            echo self::SUCCESS;
        } else {
            Yii::log("[" . $service->uid . "]API::CHROME create failed", CLogger::LEVEL_INFO);
        }
    }

    public function actionOpen()
    {
        $service = $this->getServiceByUid();
        if ($this->wakfu->open($service)) {
            if ($service->save()) {
                echo self::SUCCESS;
            } else {
                Yii::log("[" . $service->uid . "]API::OPEN save failed", CLogger::LEVEL_INFO);
            }
        } else {
            Yii::log("[" . $service->uid . "]API::OPEN failure", CLogger::LEVEL_INFO);
        }
    }

    public function actionView()
    {
        $service = $this->getServiceByUid();
        if ($this->wakfu->view($service)) {
            if ($service->save()) {
                echo self::SUCCESS;
            } else {
                Yii::log("[" . $service->uid . "]API::VIEW save failed", CLogger::LEVEL_INFO);
            }
        } else {
            Yii::log("[" . $service->uid . "]API::VIEW failure", CLogger::LEVEL_INFO);
        }
    }

    public function actionTrafficSave()
    {
        $service = $this->getServiceByUid();
        $traffic = new Traffic();
        $traffic->attributes = array(
            'uid' => $service->uid,
            'email' => $service->email,
            'date' => date('Y-m-d', strtotime('yesterday')),
            'traffic' => $service->used
        );
        $traffic->save();
        echo self::SUCCESS;
    }

    public function actionMail()
    {
        $request = $this->request;
        $accessKey = $request->getPost('accessKey', false);
        $secretKey = Yii::app()->params['secretKey'];
        if ($accessKey != $secretKey) {
            Yii::log("[" . $accessKey . "]API accessKey auth fail", CLogger::LEVEL_INFO);
            Yii::app()->end();
        }
        $email = $request->getPost('uid');
        $content = $request->getPost('content');
        $title = $request->getPost('title');
        Mail::quickSend($email, $title, $content);
        echo self::SUCCESS;
    }

    private function getServiceByUid()
    {
        $accessKey = $this->request->getPost('accessKey', false);
        $secretKey = Yii::app()->params['secretKey'];
        if ($accessKey != $secretKey) {
            Yii::log("[" . $accessKey . "]API accessKey auth fail", CLogger::LEVEL_INFO);
            Yii::app()->end();
        }

        $uid = $this->request->getPost('uid');
        $service = Service::model()->findByPk($uid);
        if (empty($service)) {
            Yii::log("[" . $uid . "]API UID Not found", CLogger::LEVEL_INFO);
            Yii::app()->end();
        }
        return $service;
    }
}