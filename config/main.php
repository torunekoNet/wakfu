<?php
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => "WaKfu",
    'preload' => array('log'),

    'import' => array(
        'application.models.*',
        'application.models.form.*',
        'application.components.*',
        'application.components.filters.*',
        'ext.yii-mail.YiiMailMessage',
        'ext.fraudmetrix.Fraudmetrix',
    ),

    'modules' => array(
        'admin' => array(
            'class' => 'application.modules.admin.AdminModule'
        )
    ),

    'components' => array(
        'user' => array(
            'allowAutoLogin' => true,
            'guestName' => '游客',
        ),

        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'urlSuffix' => '',
            'rules' => array(
                array('index/index', 'pattern' => 'index'),
                array('index/register', 'pattern' => 'register'),
                array('index/logout', 'pattern' => 'logout'),
                array('index/forget', 'pattern' => 'forget'),
                array('index/captcha', 'pattern' => 'captcha'),
                array('index/dashboard', 'pattern' => 'dashboard'),
                array('index/account', 'pattern' => 'account'),
                array('index/billing', 'pattern' => 'billing'),
                array('payment/index', 'pattern' => 'payment'),
                array('index/error', 'pattern' => 'error'),
            ),
        ),

        'db' => array(
            'connectionString' => 'mysql:host=127.0.0.1;port=3306;dbname=wakfu',
            'emulatePrepare' => true,
            'schemaCachingDuration' => 86400,
            'username' => "root",
            'password' => "toruneko",
            'charset' => 'utf8',
        ),

        'session' => array(
            'class' => 'CCacheHttpSession',
        ),

        'cache' => array(
            'class' => 'CRedisCache',
            'hostname' => '127.0.0.1',
            'port' => 6379,
            'database' => 0,
            'options' => STREAM_CLIENT_CONNECT,
        ),

        'mail' => array(
            'class' => 'ext.yii-mail.YiiMail',
            'transportType' => 'smtp',
            'transportOptions' => array(
                'host' => 'smtp.sina.com',
                'username' => 'toruneko@sina.com',
                'password' => '',
                'port' => '465',
                'encryption' => 'tls',
            ),
            'viewPath' => 'application.views.mail',
            'logging' => true,
            'dryRun' => false
        ),

        'thrift' => array(
            'class' => 'ThriftClient',
            'service' => array(
                // 服务名 => 服务所在URL
                'wakfuservice' => 'http://proxy.toruneko.net:9356/wakfu',
            ),
        ),

        'fraudmetrix' => array(
            'class' => 'ext.fraudmetrix.Fraudmetrix',
            'apiUrl' => 'https://api.tongdun.cn/riskService',
            'partnerCode' => 'kf_Qox',
            'secretKey' => '0c09a4607edf4bc0b1f7ce83a2ecb85d'
        ),

        'paypal' => array(
            'class' => 'ext.paypal.Paypal',
            'gateway' => 'https://www.paypal.com/cgi-bin/webscr',
            'buttonId' => 'H4EQ2PNQE8VJJ'
        ),

        'errorHandler' => array(
            'errorAction' => 'index/error',
        ),

        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning, info',
                ),
            ),
        ),
    ),

    'params' => array(
        'upload' => 'upload',
        'version' => 'V1.0',
        'secretKey' => 'FVezupo9WUjVrE3tzwcdBL9w3ZI95mYB',
        //上下级权限检测
        'allowCheck' => array(
            'auth' => array(
                'assign' => array(
                    array('role', 'role', 'post'),
                    array('operation', 'operation', 'post'),
                ),
                'assignGroup' => array(
                    array('auth', 'group', 'get'),
                    array('user', 'user', 'get'),
                ),
                'assignRole' => array(
                    array('auth', 'role', 'get'),
                    array('user', 'user', 'get')
                ),
            ),
            'user' => array(
                'edit' => array(
                    array('id', 'user', 'get'),
                    array(array('UserForm', 'id'), 'user', 'post'),
                )
            ),
        ),
    ),
);
