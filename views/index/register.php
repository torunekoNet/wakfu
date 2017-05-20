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
    <div class="panel-heading">Register</div>
    <div class="panel-body">
        <?php $form = $this->beginWidget('CActiveForm', array(
            'htmlOptions' => array(
                'class' => 'form-horizontal'
            ),
        )); ?>
        <div class="form-group">
            <div class="col-xs-9 col-sm-8 col-md-8">
                <p class="form-control-static">Limited Energy, Suspend Registration.</p>
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-3 col-sm-2 col-md-2">
                <?php echo CHtml::link('Back', $this->createUrl('index/index'), array('class' => 'btn btn-outline btn-primary')) ?>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>