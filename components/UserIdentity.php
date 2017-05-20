<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends RedUserIdentity
{
    const ERROR_NOT_LOGIN = 3;

    public $errorMessage = 'Unknown Error';

    public function authenticate()
    {
        $user = User::model()->with('service')->find('username=:u', array('u' => $this->username));
        $verifyPassword = false;
        if (empty($user)) {
            $state = 1;
        } else {
            $verifyPassword = CPasswordHelper::verifyPassword($this->password, $user->password);
            $state = $verifyPassword ? 0 : 1;
        }
        $result = Fraudmetrix::login($this->username, $state);
        if ($result['success'] == true && $result['final_decision'] != 'Accept') {
            if ($result['final_decision'] == 'Reject') {
                $this->errorCode = self::ERROR_UNKNOWN_IDENTITY;
                $this->errorMessage = 'Unknown Error';
            }

            if (isset($result["policy_set"])) {
                $content = '您的邮箱账号在北京时间:' . date("Y-m-d H:i:s") . "\n";
                foreach ($result["policy_set"] as $policy) {
                    if (isset($policy["hit_rules"])) {
                        $content .= '发生' . $policy["policy_name"] . '行为:' . "\n";
                        foreach ($policy["hit_rules"] as $idx => $rule) {
                            $content .= '  (' . ($idx + 1) . ') ' . $rule["name"] . "\n";
                        }
                    }
                }
                $title = $result['final_decision'] == 'Reject' ? '[夸父]拒绝登录提示' : '[夸父]异常登录提示';
                $content .= "\n" . '登录处理结果:' . ($result['final_decision'] == 'Reject' ? '拒绝登录' : '允许登录') . "\n";
                $content .= '如有疑问，请联系管理员' . "\n\t" . '敬上，夸父';
                Mail::quickSend($this->username, $title, $content);
            }
        }
        if ($result['success'] == true && $result['final_decision'] != 'Reject') {
            if (empty($user)) {
                $this->errorCode = self::ERROR_USERNAME_INVALID;
                $this->errorMessage = 'Email Not Exists';
            } else {
                if ($user->state == 1) {
                    $this->errorCode = self::ERROR_NOT_LOGIN;
                    $this->errorMessage = 'Email Locked';
                } elseif (!$verifyPassword) {
                    $this->errorCode = self::ERROR_PASSWORD_INVALID;
                    $this->errorMessage = 'Password Error';
                } else {
                    $server = Setting::model()->get('wakfu', 'server');
                    $this->errorCode = self::ERROR_NONE;
                    $this->setPersistentStates(array_merge($user->getAttributes(), array(
                        'last_login_time' => $user->last_login_time,
                        'last_login_ip' => $user->last_login_ip,
                        'sign_up_time' => $user->sign_up_time,
                        'sign_up_ip' => $user->sign_up_ip,
                        'server' =>
                            (isset($server[$user->service->server]) ? $server[$user->service->server] : $user->service->server),
                        'port' => $user->service->port
                    )));
                    $this->afterLogin($user);
                }
            }
        }
        return !$this->errorCode;
    }

    public function afterLogin($db)
    {
        $db->attributes = array(
            'last_login_time' => time(),
            'last_login_ip' => Yii::app()->request->getUserHostAddress(),
        );
        $db->update();
    }
}