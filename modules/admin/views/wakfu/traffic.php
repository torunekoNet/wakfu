<?php
/**
 * File: service.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 15/6/3 11:09
 * Description:
 */
$this->cs->registerScript('traffic', "
$('#table').on('click','tbody a',function(){
    $.get($(this).attr('href'),function(m){
        if(m.status){
            $.facebox(m.info);
        }else{
            $.facebox(m);
        }
    });
    return false;
});
");
?>
<div class="panel panel-default">
    <div class="panel-heading">流量报表</div>
    <div class="panel-body">
        <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => 'form',
            'method' => 'get',
            'action' => $this->createUrl('wakfu/traffic'),
            'htmlOptions' => array(
                'class' => 'form-inline'
            )
        ));
        ?>
        <div class="form-group">
            <?php echo $form->labelEx($model, 'uid', array('class' => 'sr-only control-label')); ?>
            <?php echo $form->textField($model, 'uid', array('class' => 'form-control', 'placeholder' => '用户ID')) ?>
        </div>
        <div class="form-group">
            <?php echo $form->labelEx($model, 'email', array('class' => 'sr-only control-label')); ?>
            <?php echo $form->textField($model, 'email', array('class' => 'form-control', 'placeholder' => '邮箱')) ?>
        </div>
        <div class="form-group">
            <?php echo $form->labelEx($model, 'server', array('class' => 'sr-only control-label')); ?>
            <?php echo $form->textField($model, 'server', array('class' => 'form-control', 'placeholder' => '服务器')) ?>
        </div>
        <div class="form-group">
            <?php echo $form->labelEx($model, 'port', array('class' => 'sr-only control-label')); ?>
            <?php echo $form->textField($model, 'port', array('class' => 'form-control', 'placeholder' => '端口')) ?>
        </div>
        <div class="form-group">
            <?php echo CHtml::submitButton('搜索', array('class' => 'btn btn-default')); ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
    <table class="table table-hover" id="table">
        <thead>
        <tr>
            <td>UID</td>
            <td>邮箱</td>
            <td>服务地址</td>
            <td>剩余流量</td>
            <td>最近使用</td>
            <td></td>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <td colspan="7">
                <?php $this->widget('RedLinkPager', array('pages' => $pager)) ?>
            </td>
        </tr>
        </tfoot>
        <tbody>
        <?php $this->widget('red.zii.widget.RedListView', array(
            'dataProvider' => $data,
            'itemView' => 'trafficList',
            'template' => '{items}',
            'emptyText' => '',
        )); ?>
        </tbody>
    </table>
</div>