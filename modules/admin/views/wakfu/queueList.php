<?php
/**
 * File: userList.php
 * User: daijianhao@zhubajie.com
 * Date: 14-8-18 11:52
 * Description:
 */
$postdata = CJSON::decode($data->postdata)
?>
<tr>
    <td><?php echo $data->id; ?></td>
    <td><?php echo $postdata['uid']; ?></td>
    <td><?php echo $data->url; ?></td>
    <td><?php echo $data->status == 0 ? '未执行' : ($data->status == 1 ? '执行中' : '已结束'); ?></td>
    <td><?php echo $data->gmt_create; ?></td>
    <td><?php echo $data->gmt_modified; ?></td>
</tr>