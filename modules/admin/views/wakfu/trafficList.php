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
    <td><?php echo $data->server ?>:<?php echo $data->port; ?></td>
    <td><?php echo number_format($data->left / 100, 2); ?></td>
    <td><?php echo number_format($data->used / 100, 2); ?></td>
    <td>
        <?php echo CHtml::link('<span class="glyphicon glyphicon-plus"></span>',
            $this->createUrl('wakfu/purchase', array('uid' => $data->uid)), array('title' => '购买')) ?>
    </td>
</tr>