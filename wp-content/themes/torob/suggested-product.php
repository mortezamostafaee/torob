<?php
global $wpdb;
$torob_separation_seller = $wpdb->prefix . "torob_separation_seller";
$torob_users = $wpdb->prefix . "users";
$torob_product = $wpdb->prefix . "torob_product";
$result_suggested = $wpdb->get_results("SELECT *, (SELECT ($torob_users.display_name) FROM $torob_users WHERE $torob_separation_seller.user_id = $torob_users.ID ) as display_name , (SELECT ($torob_product.name) FROM $torob_product WHERE $torob_separation_seller.product_id=$torob_product.id ) as product_name FROM $torob_separation_seller order by time desc ");
?>
<h2>لیست محصولات پیشنهاد شده برای تغییر دسته بندی </h2>
<hr>
<table class="widefat">
    <thead>
    <tr>
        <th>نام کاربر ارسال کننده</th>
        <th>نام محصول</th>
        <th>نام فروشگاه</th>
        <th>دسته بندی فعلی</th>
        <th>دسته بندی پیشنهادی</th>
        <th>ویرایش</th>
    </tr>
    </thead>

    <tfoot>
    <tr>
        <th>نام کاربر ارسال کننده</th>
        <th>نام محصول</th>
        <th>نام فروشگاه</th>
        <th>دسته بندی فعلی</th>
        <th>دسته بندی پیشنهادی</th>
        <th>ویرایش</th>
    </tr>
    </tfoot>
    <tbody>
    <?php

    foreach ($result_suggested as $res) : ?>
        <tr>
            <td class="d-flex align-items-center"><p><?php echo $res->display_name ?></p></td>
            <td><p><?php echo $res->product_name ?></p></td>
            <th> <?php echo $res->shop_name ?></th>
            <td><p><?php echo $res->current_category ?></p></td>
            <td><p><?php echo $res->suggested_category ?></p></td>
            <td>
                <a href="<?php echo admin_url('edit.php?post_type=torob&page=editsuggested&product_id=' .$res->product_id) ;?>" target="_blank" class="button-primary">ویرایش</a></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
