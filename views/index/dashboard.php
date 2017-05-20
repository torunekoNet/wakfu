<?php
/**
 * File: dashboard.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 15/6/7 14:49
 * Description:
 */
$this->cs->registerScript('resetButton', "
$('#form').on('click','a',function(){
    alert('并不支持，请联系管理员');
    return false;
});
");
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <td class="hidden-1000">Email</td>
                        <td>Remain</td>
                        <td>Recent Used</td>
                        <td class="hidden-600">Registration</td>
                        <td>Status</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="hidden-1000"><?php echo $service->email; ?></td>
                        <td><?php echo number_format($service->left / 100000, 2); ?>GB</td>
                        <td><?php echo number_format($service->used / 100000, 2); ?>GB</td>
                        <td class="hidden-600"><?php echo date('Y-m-d H:i:s', $service->getRelated('user')->sign_up_time); ?></td>
                        <td><?php echo $this->getStatusDisplay($service->status); ?></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php if (in_array($service->status, array(0, 3)) && $service->left > 0) { ?>
        <div class="col-xs-12 col-sm-6 col-md-6">
            <?php $form = $this->beginWidget('CActiveForm', array(
                'id' => 'form',
                'htmlOptions' => array(
                    'class' => 'form-horizontal'
                ),
            )); ?>
            <div class="form-group">
                <div class="col-xs-9 col-sm-10 col-md-10">
                    <?php if (empty($service->pac)) { ?>
                        <p class="form-control-static">Enjoy...</p>
                    <?php } else { ?>
                        <p class="form-control-static"><?php echo $service->pac; ?></p>
                    <?php } ?>
                </div>
                <div class="col-xs-3 col-sm-2 col-md-2">
                    <?php //echo CHtml::link('Reset', $this->createUrl('index/reset'), array('class' => 'btn btn-default')); ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <?php echo $form->labelEx($service, 'rules', array('class' => 'control-label')); ?>
                    <p>Input Domain without www, Multiple domains separated by new line.</p>
                    <?php echo $form->textArea($service, 'rules', array('class' => 'form-control')) ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-3 col-sm-3 col-md-2 col-xs-offset-9 col-sm-offset-9 col-md-offset-10">
                    <?php echo CHtml::submitButton('Save', array('class' => 'btn btn-default')); ?>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div>
        <div class="col-sm-6 col-md-6 hidden-768">
            <h4>Settings (Communication of QQ：455902676)</h4>

            <p><b>Windows（PAC traffic fee will be charged）：</b></p>

            <p>Internet -> Connections -> LAN Settings -> Automatic configuration script -> Enter PAC Addr -> confirm</p>

            <p><b>Mac OS X（PAC traffic fee will be charged）：</b></p>

            <p>Settings -> Internet -> Advanced -> Proxy -> Automatic configuration script -> Enter PAC Addr -> OK</p>

            <p><b>iOS (iPhone/iPad)：</b><a href="https://itunes.apple.com/us/app/wingy-mian-fei-banvpn-ke-hu/id1148026741" target="_blank">wingy</a></p>

            <p>Click “+” -> Socks5 -> Enter Service Addr -> Select Automatic Proxy Mode -> Save</p>

            <p><b>Chrome：</b><a href="http://assets.toruneko.net/SwitchyOmega.crx" target="_blank">SwitchyOmega</a>
            </p>

            <p>Options -> Import/Export -> Recovery Online -> Enter Bak Addr -> Recover</p>
        </div>
    <?php } ?>
</div>
