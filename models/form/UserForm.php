<?php

/**
 * File: UserForm.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 14/11/27 23:52
 * Description: 用户表单
 */
class UserForm extends CFormModel
{
    public $oldPassword;
    public $password;
    public $confirm;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        $labels = $this->attributeLabels();
        return array(
            array('oldPassword', 'required', 'message' => $labels['oldPassword'] . 'can not be blank.'),
            array('password', 'required', 'message' => $labels['password'] . 'can not be blank.'),
            array('confirm', 'required', 'message' => $labels['confirm'] . ' can not be blank.'),
            array('oldPassword', 'confirm', 'message' => 'Incorrect ' . $labels['oldPassword']),
            array('confirm', 'verify', 'message' => 'Incorrect ' . $labels['confirm'] . ' Password'),
            array('oldPassword, password', 'safe'),
        );
    }

    /**
     * 二次密码验证
     * @return bool
     */
    public function verify($attrbutes, $params)
    {
        $this->password = trim($this->password);
        if (empty($this->password)) {
            $this->addError($attrbutes, $params['message']);
        }
        if ($this->password != $this->confirm) {
            $this->addError($attrbutes, $params['message']);
        }
    }

    public function confirm($attrbutes, $params)
    {
        $user = User::model()->findByPk(Yii::app()->user->getId());
        if (!CPasswordHelper::verifyPassword($this->oldPassword, $user->password)) {
            $this->addError($attrbutes, $params['message']);
        }
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
            'oldPassword' => 'Old Password',
            'password' => 'Password',
            'confirm' => 'Confirm',
        );
    }

    public function save()
    {
        $app = Yii::app();

        $transaction = $app->db->beginTransaction();
        try {
            if (!$this->validate()) throw new CDbException('Parameter Error', 0, array());

            $user = User::model()->findByPk(Yii::app()->user->getId());
            if (!$user) {
                throw new CDbException('Parameter Error', 1, array());
            }

            $user->attributes = array(
                'password' => CPasswordHelper::hashPassword($this->password)
            );

            if ($user->save() === false) {
                throw new CDbException('Change Password Error', 30, $user->getErrors());
            }

            $transaction->commit();
        } catch (CDbException $e) {
            $transaction->rollback();
            $this->addErrors($e->errorInfo);
            return false;
        }

        return true;
    }
}
