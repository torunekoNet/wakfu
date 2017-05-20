<?php

/**
 * File: RegisterForm.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 14/11/28 18:25
 * Description: 注册表单
 */
class RegisterForm extends CFormModel
{
    public $username;
    public $password;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        $labels = $this->attributeLabels();
        return array(
            array('username', 'required', 'message' => $labels['username'] . 'can not be blank.'),
            array('password', 'required', 'message' => $labels['password'] . ' can not be blank.'),
            array('username', 'unique', 'message' => $labels['username'] . ' has been registered.'),
            array('username', 'email', 'message' => 'Incorrect ' . $labels['username'] . ' address.'),
        );
    }

    public function unique($attrbutes, $params)
    {
        if (User::model()->exists($attrbutes . '=:u', array('u' => $this->username))) {
            $this->addError($attrbutes, $params['message']);
        }
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
            'username' => 'Email',
            'password' => 'Password',
        );
    }

    public function save()
    {
        $app = Yii::app();

        $transaction = $app->db->beginTransaction();
        try {
            if ($this->validate() == false) throw new CDbException('Parameter Error', 0, array());
            preg_match('/^(.*)@/', $this->username, $match);
            $password = CPasswordHelper::hashPassword($this->password);

            $result = Fraudmetrix::register($this->username, $this->username, $password);
            if ($result['success'] == true && $result['final_decision'] == 'Reject') {
                throw new CDbException('Registration Failed', 100, array());
            }

            $user = new User();
            $user->attributes = array(
                'username' => $this->username,
                'realname' => isset($match[1]) ? $match[1] : '无',
                'nickname' => isset($match[1]) ? $match[1] : '无',
                'email' => $this->username,
                'password' => $password,
                'sign_up_time' => time(),
                'sign_up_ip' => Yii::app()->request->getUserHostAddress(),
                'approved' => 5,
                'state' => 0,
            );

            if ($user->save() === false) throw new CDbException('Registration Failed', 10, $user->getErrors());
            $user->uuid = $app->getSecurityManager()->generateUUID($user->id . $user->password);
            if ($user->save() === false) throw new CDbException('Registration Failed', 10, $user->getErrors());
            //写入service
            $service = new Service();
            $service->attributes = array(
                'uid' => $user->id,
                'email' => $user->username,
                'status' => 1,
                'traffic' => 100 * 100,
                'left' => 100 * 100,
            );
            if ($service->save()) {
                WakfuQueue::apiCreate($user->id);
            }

            $transaction->commit();
        } catch (CDbException $e) {
            $transaction->rollback();
            $this->addErrors($e->errorInfo);
            return false;
        }

        Mail::quickSend($this->username, 'Welcome to register Wakfu', "Please take care of your password：" . $this->password);

        return true;
    }
}