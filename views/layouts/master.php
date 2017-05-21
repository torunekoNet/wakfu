<?php
/**
 * file:main.php
 * author:wakfu@outlook.com
 * date:2014-7-6
 * desc:主视图
 */
$this->cs->registerPackage('bootstrap');
$this->cs->registerPackage('index');
$this->cs->registerScript('fraudmetrix', '
(function() {
    _fmOpt = {
        partner: "kf_Qox",
        appName: "kf_Qox_web",
        token: "' . Yii::app()->session->getSessionID() . '"
    };
    var cimg = new Image(1,1);
    cimg.onload = function() {
        _fmOpt.imgLoaded = true;
    };
    cimg.src = "http://fp.fraudmetrix.cn/fp/clear.png?partnerCode=" + _fmOpt.partner + "&appName=" + _fmOpt.appName + "&tokenId=" + _fmOpt.token;
    var fm = document.createElement("script"); fm.type = "text/javascript"; fm.async = true;
    fm.src = ("https:" == document.location.protocol ? "https://" : "http://") + "static.fraudmetrix.cn/fm.js?ver=0.1&t=" + (new Date().getTime()/3600000).toFixed(0);
    var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(fm, s);
})();
');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title><?php echo CHtml::encode($this->app->name); ?> - Life is short, As the dew.</title>
    <link rel="shortcut icon" href="http://wakfu.toruneko.net/wakfu.ico" type="image/x-icon"/>
    <!--[if lt IE 9]>
    <script type="text/javascript"
            src="http://wakfu.toruneko.net<?php echo $this->assets; ?>js/html5shiv.min.js"></script>
    <script type="text/javascript"
            src="http://wakfu.toruneko.net<?php echo $this->assets; ?>js/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<?php echo $content; ?>
<div class="container" style="position: relative; left: 0;right: 0;bottom: 0">
    <div class="row">
        <div id="copyright">
            <p>
                &copy; 2016 - <?php echo date('Y') ?> WaKfu All rights reversed.
                <a href="http://www.miitbeian.gov.cn">Zhejiang ICP No.15026355</a>
            </p>
        </div>
    </div>
</div>
</body>
</html>
