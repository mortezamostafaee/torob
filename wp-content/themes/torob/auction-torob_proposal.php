<?php
global $wpdb;
$torob_proposal = $wpdb->prefix . "torob_proposal";
$result = $wpdb->get_results("SELECT * FROM $torob_proposal order by proposal desc ");
?>
<h2>لیست افراد شرکت کننده در مزایده</h2>
<hr>
<table class="widefat">
    <thead>
    <tr>
        <th>شماره</th>
        <th>نام کاربر</th>
        <th>ساعت و تاریخ</th>
        <th>مبلغ پیشنهادی</th>
    </tr>
    </thead>
    <tfoot>
    <tr>
        <th>شماره</th>
        <th>نام کاربر</th>
        <th>ساعت و تاریخ</th>
        <th>مبلغ پیشنهادی</th>
    </tr>
    </tfoot>
    <tbody>
    <?php

    $i = 0;
    foreach ($result as $item) : ?>
        <tr>
            <th><?php echo ++$i ?></th>
            <td><?php echo $item->user_id ?></td>
            <td><?php echo $item->time ?></td>
            <td><?php echo $item->proposal ?> تومان</td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>