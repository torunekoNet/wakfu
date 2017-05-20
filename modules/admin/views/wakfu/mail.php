<?php
/**
 * File: mail.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 15/10/19 23:50
 * Description:
 */
//$this->cs->registerScript('mailForm', "
//$('#mailForm').on('click','input[type=submit]',function(){
//    var form = $('#mailForm');
//    $.post(form.attr('action'),form.serialize(),function(m){
//        if(m.status){
//            $.facebox(m.info);
//        }else{
//            $('#content').html(m);
//        }
//    });
//    return false;
//});
//");
?>
<div class="panel panel-default">
    <div class="panel-heading">邮件通知</div>
    <div class="panel-body">
        <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => 'form',
            'method' => 'post',
            'action' => $this->createUrl('wakfu/mail'),
            'htmlOptions' => array(
                'class' => 'form-horizontal'
            )
        ));
        ?>
        <div class="form-group">
            <?php echo $form->labelEx($model, 'title', array('class' => 'col-xs-3 col-sm-2 col-md-2 control-label')); ?>
            <div class="col-xs-9 col-sm-8 col-md-8">
                <?php echo $form->textField($model, 'title', array('class' => 'form-control')) ?>
                <?php echo $form->error($model, 'title'); ?>
            </div>
        </div>
        <div class="form-group">
            <?php echo $form->labelEx($model, 'content', array('class' => 'col-xs-3 col-sm-2 col-md-2 control-label')); ?>
            <div class="col-xs-9 col-sm-8 col-md-8">
                <?php echo $form->textArea($model, 'content', array('class' => 'form-control')) ?>
                <?php echo $form->error($model, 'content'); ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-3">
                <?php echo CHtml::submitButton('推送', array('class' => 'btn btn-default')); ?>
            </div>
            <div class="col-md-3">
                <?php echo CHtml::resetButton('重置', array('class' => 'btn btn-default')); ?>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>