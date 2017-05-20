<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends RedLoginForm
{

    public function rules()
    {
        $labels = $this->attributeLabels();
        return array(
            // username and password are required
            array('username', 'required', 'message' => $labels['username'] . ' can not be blank'),
            array('password', 'required', 'message' => $labels['password'] . ' can not be blank'),
            // password needs to be authenticated
            array('password', 'authenticate'),
            array('remember', 'required')
        );
    }

    public function attributeLabels()
    {
        return array(
            'username' => 'Email',
            'password' => 'Password',
            'remember' => 'Remember me'
        );
    }

    /**
     * Authenticates the password.
     * This is the 'authenticate' validator as declared in rules().
     */
    public function authenticate($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $this->_identity = new UserIdentity($this->username, $this->password);
            if (!$this->_identity->authenticate()) {
                switch ($this->_identity->errorCode) {
                    case UserIdentity::ERROR_USERNAME_INVALID:
                        $name = 'username';
                        break;
                    case UserIdentity::ERROR_PASSWORD_INVALID:
                        $name = 'password';
                        break;
                    case UserIdentity::ERROR_NOT_LOGIN:
                        $name = 'username';
                        break;
                    case UserIdentity::ERROR_UNKNOWN_IDENTITY:
                        $name = 'username';
                        break;
                    default:
                        $name = 'success';
                        break;
                }
                $this->addError($name, $this->_identity->errorMessage);
            }
        }
    }
}
