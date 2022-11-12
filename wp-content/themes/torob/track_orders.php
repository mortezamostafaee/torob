<?php
global $wpdb;
$torob_torob_feedback  = $wpdb->prefix . "torob_feedback ";
$torob_users = $wpdb->prefix . "users";

$get_results_torob_feedback = $wpdb->get_results("SELECT * ,(SELECT ($torob_users.display_name) FROM $torob_users WHERE $torob_torob_feedback.user_id_feedback  = $torob_users.ID ) as display_name FROM $torob_torob_feedback order  by id desc ");
var_dump($get_results_torob_feedback);
?>
<h2>محصولات پیشنهاد شده برای تغییر دسته بندی </h2>
<hr>
<table class="widefat">
    <thead>
    <tr>
        <th>نام کاربر</th>
        <th>فروشگاه مورد نظر</th>
        <th>بررسی</th>
        <th>وضعیت</th>
    </tr>
    </thead>
    <tfoot>
    <tr>
        <th>نام کاربر</th>
        <th>فروشگاه مورد نظر</th>
        <th>بررسی</th>
        <th>وضعیت</th>
    </tr>
    </tfoot>
    <tbody>
    <?php

    foreach ($get_results_torob_feedback as $item) : ?>
        <tr>
            <td class="d-flex align-items-center"><p><?php echo $item->display_name ?></p></td>
            <td><?php echo $item->shop ?></td>
            <td> <a href="<?php echo admin_url('edit.php?post_type=torob&page=edit_track_order&id=' .$item->id) ;?>" target="_blank" class="button-primary">ویرایش</a></td></td>
            <td>بررسی شده / بررسیب</td>

<!--            <td>--><?php //echo $item->status_update_product_type == 1 ? '<span style="color: green">انجام شده</span>' : '<span style="color: red">انجام نشده</span>'?><!--</td>-->
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>