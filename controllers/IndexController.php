<?php

/**
 * file:IndexController.php
 * author:Toruneko@outlook.com
 * date:2014-7-6
 * desc: 主站
 */
class IndexController extends RedController
{

    public function getActions()
    {
        return array(
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'foreColor' => 0x3D3D3D,
                'height' => 34,
                'width' => 100,
                'testLimit' => 1,
                'padding' => 0,
                'offset' => 3,
                'minLength' => 4,
                'maxLength' => 6,
            ),
        );
    }

    public function actionIndex()
    {
        $this->layout = '/layouts/index';
        if (!Yii::app()->user->isGuest) {
            $this->redirect($this->createUrl('index/dashboard'));
        }

        $model = new LoginForm();
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            if ($model->validate() && $model->login()) {
                $this->redirect($this->createUrl('index/dashboard'));
            }
        }

        $this->render('index', array('model' => $model));
    }

    public function actionAccount()
    {
        $model = new UserForm();

        if (($post = $this->request->getPost('UserForm', false)) != false) {
            $model->attributes = $post;
            if ($model->save()) {
                $this->user->logout();
                $this->redirect($this->createUrl('index'));
            }
        }

        $this->render('account', array(
            'model' => $model,
            'service' => Service::model()->findByPk($this->user->getId())
        ));
    }

    public function actionBilling()
    {
        $query = array('uid' => $this->user->getId());
        $model = Traffic::model();
        $model->attributes = $query;
        $condition = array('condition' => 'uid=:uid', 'params' => array('uid' => $query['uid']));
        $pager = new CPagination($model->count($condition));
        $pager->setPageSize(20);
        $condition['offset'] = $pager->getOffset();
        $condition['limit'] = $pager->getLimit();
        $condition['order'] = 'date desc';
        $data = $model->findAll($condition);
        $this->render('billing', array(
            'data' => new RedArrayDataProvider($data),
            'pager' => $pager,
        ));
    }

    public function actionLogout()
    {
        $this->user->logout();
        $this->redirect($this->createUrl('index'));
    }

    public function actionRegister()
    {
        $this->layout = '/layouts/index';
        $model = new RegisterForm();

        if (($post = $this->request->getPost('RegisterForm', false)) != false) {
            $model->attributes = $post;
            if ($model->save()) {
                $login = new LoginForm();
                $post['remember'] = 0;
                $login->attributes = $post;
                if ($login->validate() && $login->login()) {
                    $this->redirect($this->createUrl('index/dashboard'));
                } else {
                    $this->redirect($this->createUrl('index'));
                }
            }
        }

        $this->render('register', array('model' => $model));
    }

    public function actionForget()
    {
        $this->layout = '/layouts/index';
        $model = new ForgetForm();

        if (($post = $this->request->getPost('ForgetForm', false)) != false) {
            $post['password'] = $this->grantePassword();
            $model->attributes = $post;
            if ($model->save()) {
                $this->render('forget', array(
                    'model' => $model,
                    'success' => true
                ));
            } else {
                $this->render('forget', array(
                    'model' => $model,
                    'success' => false
                ));
            }
            return;
        }

        $this->render('forget', array('model' => $model));
    }

    public function actionDashboard()
    {
        $service = Service::model()->with('user')->findByPk($this->user->getId());

        if (($post = $this->request->getPost('Service', false)) != false) {
            $service->rules = $post['rules'];
            if ($service->save()) {
                WakfuQueue::apiPac($service->uid);
            }
        }

        $this->render('dashboard', array(
            'service' => $service,
        ));
    }

    public function getStatusDisplay($status)
    {
        $display = array('Normal', 'Overdue', 'Forbidden', 'Survival');
        return $display[$status];
    }

    public function actionError()
    {
        $this->layout = '/layouts/master';
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest) {
                echo $error['message'];
            } else {
                $this->render('error', $error);
            }
        } else {
            $this->render('error');
        }
    }

    public function allowGuest()
    {
        $actionId = $this->getAction()->getId();
        $arr = array('index', 'register', 'captcha', 'error', 'forget');
        if (in_array($actionId, $arr)) return true;
        if (Yii::app()->user->isGuest) {
            $this->redirect($this->createUrl('index'));
        }
    }

    private function grantePassword($length = 10)
    {
        // 密码字符集，可任意添加你需要的字符
        $chars = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h',
            'i', 'j', 'k', 'l', 'm', 'n', 'p', 'q', 'r', 's',
            't', 'u', 'v', 'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D',
            'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N',
            'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
            '1', '2', '3', '4', '5', '6', '7', '8', '9',
            '1', '2', '3', '4', '5', '6', '7', '8', '9',
            '1', '2', '3', '4', '5', '6', '7', '8', '9');

        // 在 $chars 中随机取 $length 个数组元素键名
        shuffle($chars);
        $keys = array_rand($chars, $length);
        $password = '';
        foreach ($keys as $key) {
            $password .= $chars[$key];
        }

        return $password;
    }
}