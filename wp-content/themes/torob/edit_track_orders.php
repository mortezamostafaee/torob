<?php
global $wpdb;
$id = $_GET['id'];
$torob_torob_feedback  = $wpdb->prefix . "torob_feedback ";
$result_track  = $wpdb->get_results("SELECT * FROM $torob_torob_feedback where id = $id");
var_dump($result_track);
?>
<body>
<h2>بررسی پیام کاربر</h2>
<hr>
<table class="widefat">
    <thead>
    <tr>
        <th>نام فروشگاه</th>
        <th>مورد شکایت</th>
        <th>مبلغ پرداخت شده</th>
        <th>مورد پیگیری</th>
        <th>شماره سفارش</th>
        <th>تاریخ سفارش</th>
        <th>نام خریدار</th>
        <th>توضیحات</th>
        <th>تصویر پیوست</th>
    </tr>
    </thead>
    <tfoot>
    <tr>
        <th>نام فروشگاه</th>
        <th>مورد شکایت</th>
        <th>مبلغ پرداخت شده</th>
        <th>مورد پیگیری</th>
        <th>شماره سفارش</th>
        <th>تاریخ سفارش</th>
        <th>نام خریدار</th>
        <th>توضیحات</th>
        <th>تصویر پیوست</th>
    </tr>
    </tfoot>
    <tbody>
    <tr>
        <th><?php echo $result_track[0]->shop ?></th>
        <th><?php echo $result_track[0]->complaint_form ?></th>
        <th><?php echo $result_track[0]->price ?></th>
        <th><?php echo $result_track[0]->noanswers ?></th>
        <th><?php echo $result_track[0]->ordercode ?></th>
        <th><?php echo $result_track[0]->date ?></th>
        <th><?php echo $result_track[0]->buyer_name ?></th>
        <th><textarea rows="4" cols="20"><?php echo $result_track[0]->order_tracking ?></textarea></th>
        <th><a href="<?php echo $result_track[0]->link ?>" target="_blank"><img src="<?php echo $result_track[0]->link ?>" width="200" height="128"></a></th>
    </tr>
    </tbody>
</table>
</body>
