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
            'connectionString' => 'mysql:host=sqld.duapp.com;port=4050;dbname=SyNBrwwRNaxibCvnbITx',
            'emulatePrepare' => true,
            'schemaCachingDuration' => 86400,
            'username' => "77d93fa2c471405191d15571c02e508f",
            'password' => "9e7170398e164dfbb1bfeb5378269697",
            'charset' => 'utf8',
        ),

        'cache' => array(
            'class' => 'BaeMemCache',
            'host' => 'redis.duapp.com',
            'port' => '80',
            'username' => '77d93fa2c471405191d15571c02e508f',
            'password' => '9e7170398e164dfbb1bfeb5378269697',
            'dbname' => 'DATjkLvSSAgDtATmsWbw'
        ),

        'mail' => array(
            'class' => 'ext.yii-mail.YiiMail',
            'transportType' => 'smtp',
            'transportOptions' => array(
                'host' => 'smtp.sina.com',
                'username' => 'toruneko@sina.com',
                'password' => 'waitjh041025~!',
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
            'apiUrl' => 'https://api.fraudmetrix.cn/riskService',
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
                    'class' => 'BaeLogRoute',
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
