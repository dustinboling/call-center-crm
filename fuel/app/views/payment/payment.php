<?php if(isset($status) && in_array($status, array('paid','processing','NSF'))):?>
<tr class="payment_<?php echo $status;?>">
    <td>Payment <?php echo $number;?></td>
    <td><?php echo date('m/d/Y g:ia', strtotime($date_received));?></td>
    <td>$<?php echo $amount_received;?></td>
    <td><?php echo ucwords($status);?></td>
    <td><?php echo $received_note;?></td>
    <td width="25"><a href="/payment/update/<?php echo $case_id;?>/<?php echo $id;?>"><i class="icon-pencil"></i></td>
</tr>
<?php else:?>
<tr>
    <td>
        Payment <?php echo $number;?>
    </td>
    <td>
        <input type="text" name="payment[<?php echo $id;?>][date_due]" value="<?php (isset($date_due)? print date('m/d/Y', strtotime($date_due)):'');?>" class="input-due datepicker">
    </td>
    <td>
        <div class="input-prepend">
            <span class="add-on">$</span>
            <input type="text" name="payment[<?php echo $id;?>][amount]" value="<?php (isset($amount)? print $amount:'');?>" class="input-amount">
        </div>
    </td>
    <td>
        <select name="payment[<?php echo $id;?>][status]">
            <option value="pending"<?php (isset($status) && $status=='pending'?print ' selected':'');?>>Pending</option>
            <option value="hold"<?php (isset($status) && $status=='hold'?print ' selected':'');?>>Hold</option>
            <option value="processing"<?php (isset($status) && $status=='processing'?print ' selected':'');?>>Processing</option>
            <option value="paid"<?php (isset($status) && $status=='paid'?print ' selected':'');?>>Paid</option>
            <option value="NSF"<?php (isset($status) && $status=='NSF'?print ' selected':'');?>>NSF</option>
            <option value="canceled"<?php (isset($status) && $status=='canceled'?print ' selected':'');?>>Canceled</option>
        </select>
    </td>
    <td></td>
</tr>
<?php endif;?>