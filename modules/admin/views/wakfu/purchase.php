<?php
/**
 * File: purchase.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 15/6/7 18:07
 * Description:
 */
$this->cs->registerScript('purchaseForm', "
$('#purchaseform').on('click','input[type=submit]',function(){
    var form = $('#purchaseform');
    $.post(form.attr('action'),form.serialize(),function(m){
        if(m.status){
            $.facebox(m.info);
        }else{
            $('#content').html(m);
        }
    });
    return false;
});
");
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'purchaseform',
    'action' => $this->createUrl('wakfu/purchase'),
    'htmlOptions' => array(
        'class' => 'form-horizontal'
    )
)); ?>
    <div class="form-group">
        <input type="hidden" name="uid" value="<?php echo $uid; ?>"/>
        <label class="col-xs-3 col-sm-3 col-md-3 control-label">购买流量</label>

        <div class="col-xs-5 col-sm-5 col-md-5">
            <input class="form-control" type="text" name="traffic" placeholder="单位：M"/>
        </div>
        <div class="col-xs-1 col-sm-1 col-md-1">
            <?php echo CHtml::submitButton('购买', array('class' => 'btn btn-default')); ?>
        </div>
    </div>
<?php $this->endWidget(); ?>