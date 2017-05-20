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
    <td><?php echo $data->pac; ?></td>
    <td>
        <?php echo CHtml::link('<span class="glyphicon glyphicon-refresh"></span>',
            $this->createUrl('wakfu/reset', array('id' => $data->uid)), array('title' => '重置')) ?>
    </td>
</tr>