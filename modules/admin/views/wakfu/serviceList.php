<?php
/**
 * File: userList.php
 * User: daijianhao@zhubajie.com
 * Date: 14-8-18 11:52
 * Description:
 */
?>
<tr>
    <td><?php echo $data->uid; ?></td>
    <td><?php echo $data->email; ?></td>
    <td>
        <?php echo number_format($data->left / 100, 2); ?>/
        <?php echo number_format($data->used / 100, 2); ?>
    </td>
    <td><?php echo $data->server; ?></td>
    <td><?php echo $data->port; ?></td>
    <td><?php echo $this->getStatusDisplay($data->status); ?></td>
    <td>
        <?php echo CHtml::link('<span class="glyphicon glyphicon-off"></span>',
            $this->createUrl('wakfu/switch', array('id' => $data->uid)), array('title' => '开关')) ?>
    </td>
</tr>