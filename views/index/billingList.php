<?php
/**
 * File: billingList.php
 * User: daijianhao(toruneko@outlook.com)
 * Date: 15/10/9 21:56
 * Description:
 */
?>
<tr>
    <td><?php echo $data->email; ?></td>
    <td><?php echo $data->date; ?></td>
    <td><?php echo number_format($data->traffic / 100, 2); ?>MB</td>
</tr>