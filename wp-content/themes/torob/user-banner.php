<?php
global $wpdb;
$torob_user_selected_banners = $wpdb->prefix . "torob_user_selected_banners";
$torob_proposal = $wpdb->prefix . "torob_proposal";

$result_torob_proposal = $wpdb->get_results("SELECT * FROM $torob_proposal  order by proposal desc limit 1");
$user_name_proposal = $result_torob_proposal[0]->user_id;
$result_user_selected_banners = $wpdb->get_results("SELECT * FROM $torob_user_selected_banners where user_name =  '$user_name_proposal' order by time desc limit 1");
?>
<h2>بنر های انتخاب شده کاربر برنده شده در آخرین مزایده </h2>
<hr>
<table class="widefat">
    <thead>
    <tr>
        <th>نام کاربر</th>
        <th>نام مجموعه</th>
        <th>بنر سایت</th>
        <th>بنر اپلیکیشن</th>
        <th>لینک بنر</th>
    </tr>
    </thead>
    <tfoot>
    <tr>
        <th>نام کاربر</th>
        <th>نام مجموعه</th>
        <th>بنر سایت</th>
        <th>بنر اپلیکیشن</th>
        <th>لینک بنر</th>
    </tr>
    </tfoot>
    <tbody>
    <?php

    foreach ($result_user_selected_banners as $item) : ?>
        <tr>
            <td class="d-flex align-items-center"><p><?php echo $item->user_name ?></p></td>
            <td><?php echo $item->collection_banner ?></td>
            <td><a href="<?php echo $item->site_banner ?>" target="_blank" ><img style="width: 90px; height: 90px" src="<?php echo $item->site_banner ?>"></a></td>
            <td><a href="<?php echo $item->app_banner ?>" target="_blank" ><img style="width: 90px; height: 90px" src="<?php echo $item->app_banner ?>"></a></td>
            <th><input type="text" value="<?php echo $item->link_banner ?>" dir="auto"></th>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>