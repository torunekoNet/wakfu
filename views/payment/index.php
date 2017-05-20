<?php
/**
 * File: payment.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 16/2/25 20:47
 * Description:
 */
$this->cs->registerScript('payment', '
$(".product-radio").on("click", function(){
    var os0 = $("input[name=os0]")
    os0.val($(this).val())
})
');
?>
<div class="raw">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">Recharge</div>
            <div class="panel-body">
                <form method="post" class="form-horizontal" action="<?php echo $gateway; ?>">
                    <input type="hidden" name="cmd" value="_s-xclick">
                    <input type="hidden" name="hosted_button_id" value="<?php echo $buttonId; ?>">
                    <input type="hidden" name="charset" value="utf-8">
                    <input type="hidden" name="currency_code" value="USD">
                    <input type="hidden" name="on0" value="夸父流量">
                    <input type="hidden" name="item_name" value="<?php echo $this->user->username; ?>">
                    <input type="hidden" name="custom" value="<?php echo $this->user->id; ?>">

                    <div class="form-group">
                        <label class="col-xs-4 col-sm-4 col-md-2 control-label">Select traffic package</label>

                        <div class="col-xs-12 col-sm-12 col-md-12 btn-group payment-box" data-toggle="buttons">
                            <label class="btn btn-default active">
                                <input type="radio" name="os0" class="product-radio" autocomplete="off" value="2GB"
                                       checked>

                                <div>
                                    <p>Recharge &nbsp;2GB Traffic</p>

                                    <p>Only $1.00 USD</p>
                                </div>
                            </label>
                            <label class="btn btn-default">
                                <input type="radio" name="os0" class="product-radio" autocomplete="off" value="11GB">

                                <div>
                                    <p>Recharge 11GB Traffic</p>

                                    <p>Only $5.00 USD</p>
                                </div>
                            </label>
                            <label class="btn btn-default">
                                <input type="radio" name="os0" class="product-radio" autocomplete="off" value="25GB">

                                <div>
                                    <p>Recharge 25GB Traffic</p>

                                    <p>Only $10.00 USD</p>
                                </div>
                            </label>
                            <label class="btn btn-default">
                                <input type="radio" name="os0" class="product-radio" autocomplete="off" value="60GB">

                                <div>
                                    <p>Recharge 60GB Traffic</p>

                                    <p>Only $20.00 USD</p>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-2 col-sm-2 col-md-2">
                            <input class="btn btn-primary" type="submit" value="PayPal">
                        </div>
                        <div class="col-xs-2 col-sm-2 col-md-2">
                            <a class="btn btn-primary" data-toggle="modal" data-target="#qrPay">Donate</a>
                        </div>
                    </div>
                </form>
                <table class="table table-hover" id="table">
                    <thead>
                    <tr>
                        <td>Email</td>
                        <td>Date</td>
                        <td>Traffic</td>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <td colspan="3">
                            <?php $this->widget('RedLinkPager', array('pages' => $pager)) ?>
                        </td>
                    </tr>
                    </tfoot>
                    <tbody>
                    <?php $this->widget('red.zii.widget.RedListView', array(
                        'dataProvider' => $data,
                        'itemView' => 'historyList',
                        'template' => '{items}',
                        'emptyText' => '',
                    )); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="qrPay" tabindex="-1" role="dialog" aria-labelledby="qrPayLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="qrPayLabel">Donate</h4>
            </div>
            <div class="modal-body">
                <div style="background: url(/assets/main/aex04064xwrjbqjdp6rz3b1.png); width: 430px; height: 430px; margin: 0 auto;"></div>
                <p>Thank you for your donation，We will add free Traffic for your support！</p>
                <p>Direct：$1.00 USD = ￥6.00 CNY</p>
            </div>
        </div>
    </div>
</div>