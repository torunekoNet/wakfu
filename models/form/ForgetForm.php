<?php

/**
 * File: ForgetForm.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 14/11/28 18:25
 * Description: 注册表单
 */
class ForgetForm extends CFormModel
{
    public $username;
    public $password;
    public $verifyCode;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        $labels = $this->attributeLabels();
        return array(
            array('username', 'required', 'message' => $labels['username'] . ' can not be blank.'),
            array('password', 'required', 'message' => $labels['password'] . ' can not be blank.'),
            array('username', 'unique', 'message' => $labels['username'] . ' not found.'),
            array('username', 'email', 'message' => 'Incorrect ' . $labels['username'] . ' address.'),
            array('verifyCode', 'captcha', 'allowEmpty' => !CCaptcha::checkRequirements(), 'message' => 'Incorrect ' . $labels['verifyCode']),
        );
    }

    public function unique($attrbutes, $params)
    {
        if (!User::model()->exists($attrbutes . '=:u', array('u' => $this->username))) {
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
            'verifyCode' => 'captcha'
        );
    }

    public function save()
    {
        $app = Yii::app();

        $transaction = $app->db->beginTransaction();
        try {
            if ($this->validate() == false) throw new CDbException('Parameter Error', 0, array());

            $user = User::model()->findByAttributes(array(
                'username' => $this->username,
            ));
            if (empty($user)) throw new CDbException('Email Not Found', 10, $user->getErrors());

            $user->password = CPasswordHelper::hashPassword($this->password);
            if ($user->save() === false) throw new CDbException('Retrieve Password Error', 10, $user->getErrors());

            $transaction->commit();
        } catch (CDbException $e) {
            $transaction->rollback();
            $this->addErrors($e->errorInfo);
            return false;
        }

        Mail::quickSend($this->username, 'Retrieve Password', "Please login Wakfu and change your password as soon as possible：" . $this->password);

        return true;
    }
}