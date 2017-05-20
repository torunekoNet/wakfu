<?php
/**
 * file:error.php
 * author:Toruneko@outlook.com
 * date:2014-7-6
 * desc: 错误页面
 */
?>
<div class="row">
    <div class="col-md-12">
        <div style="text-align:center">
            <img src="<?php echo $this->assets; ?>/main/notfound.gif"/>

            <h2>Page does not exist or has been deleted！</h2>

            <p><a href="<?php echo Yii::app()->homeUrl; ?>">Home Page</a></p>
        </div>
    </div>
</div>