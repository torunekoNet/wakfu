<?php
/**
 * File: register.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 15/6/7 14:28
 * Description:
 */
$this->cs->registerScript('captcha', "
$('#verifyCode').on('click', function (){
    $.ajax({
        url: '/captcha?refresh=1',
        dataType: 'json',
        cache: false,
        success: function(data) {
            $('#verifyCode').attr('src', data['url']);
            $('body').data('captcha.hash', [data['hash1'], data['hash2']]);
        }
    });
    return false;
});
");
?>
<div class="panel panel-default">
    <div class="panel-heading">Retrieve Password</div>
    <div class="panel-body">
        <?php $form = $this->beginWidget('CActiveForm', array(
            'htmlOptions' => array(
                'class' => 'form-horizontal'
            ),
        )); ?>
        <div class="text-center"><?php if (isset($success)) {
                echo $success ? "正在发送新的密码至您的邮箱，请耐心等待" : "找回密码出错";
            } ?></div>
        <div class="form-group">
            <?php echo $form->labelEx($model, 'username', array('class' => 'col-xs-3 col-sm-2 col-md-2 control-label')); ?>
            <div class="col-xs-9 col-sm-8 col-md-8">
                <?php echo $form->textField($model, 'username', array('class' => 'form-control')) ?>
                <?php echo $form->error($model, 'username'); ?>
            </div>
        </div>
        <?php if (CCaptcha::checkRequirements()) { ?>
            <div class="form-group">
                <?php echo $form->labelEx($model, 'verifyCode', array('class' => 'col-xs-3 col-sm-2 col-md-2 control-label')); ?>
                <div class="col-xs-4 col-sm-5 col-md-5">
                    <?php echo $form->textField($model, 'verifyCode', array('class' => 'form-control')) ?>
                    <?php echo $form->error($model, 'verifyCode'); ?>
                </div>
                <div class="col-xs-4 col-sm-2 col-md-2">
                    <?php $this->widget('CCaptcha', array(
                        'showRefreshButton' => false,
                        'clickableImage' => false,
                        'imageOptions' => array(
                            'height' => '34px',
                            'width' => '100px',
                            'id' => 'verifyCode'
                        ),
                    )); ?>
                </div>
            </div>
        <?php } ?>
        <div class="form-group">
            <div class="col-xs-offset-4 col-sm-offset-6 col-md-offset-6 col-xs-3 col-sm-2 col-md-2">
                <?php echo CHtml::link('Back', $this->createUrl('index/index'), array('class' => 'btn btn-outline btn-primary')) ?>
            </div>
            <div class="col-xs-3 col-sm-2 col-md-2">
                <?php echo CHtml::submitButton('Commit', array('class' => 'btn btn-outline btn-primary')); ?>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>