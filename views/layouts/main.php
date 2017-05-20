<?php
/**
 * file:main2.php
 * author:Toruneko@outlook.com
 * date:2014-7-6
 * desc:主视图
 */
$this->cs->registerScript('nav', "
var current = window.location.href;
$('.nav li').each(function(){
    var href = $(this).find('a').attr('href');
    if(href == current){
        $('.nav li.active').removeClass('active');
        $(this).addClass('active');
    }else if(current.match('^'+href+'.*')){
        $('.nav li.active').removeClass('active');
        $(this).addClass('active');
    }
});
");
$this->beginContent('/layouts/master');
?>
    <div class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo Yii::app()->getHomeUrl(); ?>">WaKfu</a>
            </div>
            <div class="collapse navbar-collapse" id="navbar">
                <ul class="nav navbar-nav">
                    <li><a href="<?php echo $this->app->createAbsoluteUrl('dashboard'); ?>">Dashboard</a></li>
                    <li><a href="<?php echo $this->app->createAbsoluteUrl('account'); ?>">Account</a></li>
                    <li><a href="<?php echo $this->app->createAbsoluteUrl('billing'); ?>">Billing</a></li>
                    <li><a href="<?php echo $this->app->createAbsoluteUrl('payment'); ?>">Recharge</a></li>
                </ul>
                <div class="navbar-form navbar-right">
                    <a class="btn btn-default" href="<?php echo $this->app->createAbsoluteUrl('logout'); ?>">Logout</a>
                </div>
            </div>
        </div>
    </div>
    <div class="container main-container"><?php echo $content; ?></div>
<?php $this->endContent(); ?>