<?php
/**
 * File: success.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 16/2/25 22:36
 * Description:
 */
?>
<div class="raw">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="jumbotron">
                    <h1><?php echo $message; ?></h1>

                    <p>Payment：Wakfu Traffic <?php echo $item; ?>GB</p>

                    <p>Amount：$<?php echo $amount; ?> USD</p>
                    <?php if ($success) { ?>
                        <p><a class="btn btn-primary btn-lg" href="<?php echo $this->createUrl('index'); ?>"
                              role="button">Order</a></p>
                    <?php } else { ?>
                        <p><a class="btn btn-primary btn-lg" href="#" onclick="window.location.reload()" role="button">Refresh</a>
                        </p>
                    <? } ?>
                </div>
            </div>
        </div>
    </div>
</div>