<?php
/**
 * File: service.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 15/6/3 11:09
 * Description:
 */
?>
<div class="panel panel-default">
    <div class="panel-heading">队列状态</div>
    <div class="panel-body">
        <table class="table table-hover" id="table">
            <thead>
            <tr>
                <td>ID</td>
                <td>UID</td>
                <td>URL</td>
                <td>状态</td>
                <td>创建时间</td>
                <td>完成时间</td>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <td colspan="6">
                    <?php $this->widget('RedLinkPager', array('pages' => $pager)) ?>
                </td>
            </tr>
            </tfoot>
            <tbody>
            <?php $this->widget('red.zii.widget.RedListView', array(
                'dataProvider' => $data,
                'itemView' => 'queueList',
                'template' => '{items}',
                'emptyText' => '',
            )); ?>
            </tbody>
        </table>
    </div>
</div>