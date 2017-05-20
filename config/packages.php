<?php
/**
 * file:packages.php
 * author:Toruneko@outlook.com
 * date:2014-7-19
 * desc: assets包
 */
return array(
    'jquery'=>array(
        'js'=>array('jquery-1.11.1.min.js'),
        'baseUrl' => 'http://wakfu.toruneko.net/assets/jquery',
    ),
    'yii' => array(
        'js' => array('jquery.yii.js'),
        'depends' => array('jquery'),
        'baseUrl' => 'http://wakfu.toruneko.net/assets/js',
    ),
    'yiitab' => array(
        'js' => array('jquery.yiitab.js'),
        'depends' => array('jquery'),
        'baseUrl' => 'http://wakfu.toruneko.net/assets/yiitab',
    ),
    'yiiactiveform' => array(
        'js' => array('jquery.yiiactiveform.js'),
        'depends' => array('jquery'),
        'baseUrl' => 'http://wakfu.toruneko.net/assets/js',
    ),
    'jquery.ui' => array(
        'js' => array('jquery-ui.min.js'),
        'depends' => array('jquery'),
        'baseUrl' => 'http://wakfu.toruneko.net/assets/jui/js',
    ),
    'bgiframe' => array(
        'js' => array('jquery.bgiframe.js'),
        'depends' => array('jquery'),
        'baseUrl' => 'http://wakfu.toruneko.net/assets/js',
    ),
    'ajaxqueue' => array(
        'js' => array('jquery.ajaxqueue.js'),
        'depends' => array('jquery'),
        'baseUrl' => 'http://wakfu.toruneko.net/assets/js',
    ),
    'autocomplete' => array(
        'js' => array('jquery.autocomplete.js'),
        'depends' => array('jquery', 'bgiframe', 'ajaxqueue'),
        'baseUrl' => 'http://wakfu.toruneko.net/assets/autocomplete',
    ),
    /*'maskedinput'=>array(
        'js'=>array('jquery.maskedinput.min.js'),
        'depends'=>array('jquery'),
        'baseUrl' => 'http://wakfu.toruneko.net/assets/js',
    ),*/
    'maskedinput' => array(
        'js' => array('jquery.maskedinput.min.js'),
        'depends' => array('jquery'),
        'baseUrl' => 'http://cdn.bootcss.com/jquery.maskedinput/1.3.1',
    ),
    /*'cookie'=>array(
        'js'=>array('jquery.cookie.js'),
        'depends'=>array('jquery'),
        'baseUrl' => 'http://wakfu.toruneko.net/assets/js',
    ),*/
    'cookie' => array(
        'js' => array('jquery.cookie.min.js'),
        'depends' => array('jquery'),
        'baseUrl' => 'http://cdn.bootcss.com/jquery-cookie/1.4.1',
    ),
    'treeview' => array(
        'js' => array('jquery.treeview.js', 'jquery.treeview.edit.js', 'jquery.treeview.async.js'),
        'css' => array('jquery.treeview.css'),
        'depends' => array('jquery', 'cookie'),
        'baseUrl' => 'http://wakfu.toruneko.net/assets/treeview',
    ),
    'multifile' => array(
        'js' => array('jquery.multifile.js'),
        'depends' => array('jquery'),
        'baseUrl' => 'http://wakfu.toruneko.net/assets/js',
    ),
    'rating' => array(
        'js' => array('jquery.rating.js'),
        'depends' => array('jquery', 'metadata'),
        'baseUrl' => 'http://wakfu.toruneko.net/assets/rating',
    ),
    'metadata' => array(
        'js' => array('jquery.metadata.js'),
        'depends' => array('jquery'),
        'baseUrl' => 'http://wakfu.toruneko.net/assets/js',
    ),
    /*'bbq'=>array(
        'js'=>array('jquery.ba-bbq.min.js'),
        'depends'=>array('jquery'),
        'baseUrl' => 'http://wakfu.toruneko.net/assets/js',
    ),*/
    'bbq' => array(
        'js' => array('jquery.ba-bbq.min.js'),
        'depends' => array('jquery'),
        'baseUrl' => 'http://cdn.bootcss.com/jquery.ba-bbq/1.2.1',
    ),
    /*'history'=>array(
        'js'=>array('jquery.history.js'),
        'depends'=>array('jquery'),
        'baseUrl' => 'http://wakfu.toruneko.net/assets/js',
    ),*/
    'history' => array(
        'js' => array('jquery.history.min.js'),
        'depends' => array('jquery'),
        'baseUrl' => 'http://cdn.bootcss.com/history.js/1.8/bundled/html5',
    ),
    /*'punycode'=>array(
        'js'=>array('punycode.min.js'),
        'baseUrl' => 'http://wakfu.toruneko.net/assets/js',
    ),*/
    'punycode' => array(
        'js' => array('punycode.min.js'),
        'baseUrl' => 'http://cdn.bootcss.com/punycode/1.3.1',
    ),
    'bootstrap'=>array(
        'js'=>array('js/bootstrap.min.js'),
        'css'=>array('css/bootstrap.min.css'),
        'depends'=>array('jquery'),
        'baseUrl' => 'http://wakfu.toruneko.net/assets/bootstrap-3.2.0',
    ),
    'ztree' => array(
        'js' => array('js/jquery.ztree.all-3.5.min.js'),
        'css' => array('css/zTreeStyle/zTreeStyle.css'),
        'baseUrl' => 'http://wakfu.toruneko.net/assets/zTree_v3',
    ),
    'kindeditor' => array(
        'js' => array('kindeditor-min.js', 'lang/zh_CN.js'),
        'css' => array('themes/default/default.css'),
        'baseUrl' => 'http://wakfu.toruneko.net/assets/kindeditor-4.1.10'
    ),
    'facebox' => array(
        'js' => array('facebox.js'),
        'css' => array('facebox.css'),
        'depends' => array('jquery'),
        'baseUrl' => 'http://wakfu.toruneko.net/assets/facebox'
    ),
    'admin' => array(
        'js' => array('jquery.admin.js'),
        'css' => array('admin.css'),
        'depends' => array('jquery'),
        'baseUrl' => 'http://wakfu.toruneko.net/assets/admin',
    ),
    'prettify' => array(
        'js' => array('prettify.min.js'),
        //'css'=>array('prettify.min.css'),
        'depends' => array('sunburst'),
        'baseUrl' => 'http://cdn.bootcss.com/prettify/r298',
    ),
    'sunburst' => array(
        'css' => array('sunburst.css'),
        'baseUrl' => 'http://wakfu.toruneko.net/assets/main',
    ),
    'moment' => array(
        'js' => array('moment-with-locales.min.js'),
        'baseUrl' => 'http://cdn.bootcss.com/moment.js/2.10.3',
    ),
    /*'datetimepicker'=>array(
        'css'=>array('css/bootstrap-datetimepicker.min.css'),
        'js'=>array('js/bootstrap-datetimepicker.min.js'),
        'depends'=>array('bootstrap','moment'),
        'baseUrl'=>'http://cdn.bootcss.com/bootstrap-datetimepicker/4.7.14',
    ),*/
    'datetimepicker' => array(
        'css' => array('css/bootstrap-datetimepicker.min.css'),
        'js' => array('js/bootstrap-datetimepicker.min.js', 'js/locales/bootstrap-datetimepicker.zh-CN.js'),
        'depends' => array('bootstrap', 'moment'),
        'baseUrl' => 'http://wakfu.toruneko.net/assets/datetimepicker',
    ),
    'index' => array(
        'baseUrl' => 'http://wakfu.toruneko.net/assets/main',
        'depends' => array('bootstrap'),
        'css' => array('index.css'),
    ),
    'echarts' => array(
        'js' => array('echarts-all.js'),
        'baseUrl' => 'http://cdn.bootcss.com/echarts/2.2.3'
    ),
);