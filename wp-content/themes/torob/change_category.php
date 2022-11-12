<?php
global $wpdb;
$torob_change_category_mine_product_intgration = $wpdb->prefix . "torob_change_category_mine_product_intgration";
$torob_main_product = $wpdb->prefix . "torob_main_product";
$torob_users = $wpdb->prefix . "users";
$result_torob_main_product = $wpdb->get_results("SELECT * FROM $torob_main_product");

if (isset($_POST['change_apply'])) {
    $product_id = $_POST['product_id'];
    $wpdb->update($torob_main_product, array(
        'product_type' => $_POST['current_category'],
    ), array(
        'product_id' => $product_id,
    ));

    $wpdb->update($torob_change_category_mine_product_intgration, array(

        'product_id' => $product_id,
        'status_update_product_type' => $_POST['status'],
    ), array(
        'id' => $_POST['id'],
    ));
}
$get_results_change_category_mine_product_intgration = $wpdb->get_results("SELECT * ,(SELECT ($torob_users.display_name) FROM $torob_users WHERE $torob_change_category_mine_product_intgration.user_id = $torob_users.ID ) as display_name ,  (SELECT ($torob_main_product.product_name) FROM $torob_main_product WHERE $torob_change_category_mine_product_intgration.product_id = $torob_main_product.product_id ) as main_product_name FROM $torob_change_category_mine_product_intgration join $torob_main_product on $torob_main_product.product_id = $torob_change_category_mine_product_intgration.product_id order  by
id desc ");
var_dump($result_torob_main_product);
?>
<h2>محصولات پیشنهاد شده برای تغییر دسته بندی </h2>
<hr>
<table class="widefat">
    <thead>
    <tr>
        <th>نام کاربر</th>
        <th>محصول مادر</th>
        <th>دسته بندی فعلی</th>
        <th>دسته بندی پیشنهاد شده</th>
        <th>تغییر دسته بندی</th>
        <th>وضعیت</th>
    </tr>
    </thead>
    <tfoot>
    <tr>
        <th>نام کاربر</th>
        <th>محصول مادر</th>
        <th>دسته بندی فعلی</th>
        <th>دسته بندی پیشنهاد شده</th>
        <th>تغییر دسته بندی</th>
        <th>وضعیت</th>
    </tr>
    </tfoot>
    <tbody>
    <?php

    foreach ($get_results_change_category_mine_product_intgration as $item) : ?>
        <tr>
            <td class="d-flex align-items-center"><p><?php echo $item->display_name ?></p></td>
            <td><?php echo $item->main_product_name ?></td>
            <td><?php echo $item->current_category ?></td>
            <td><?php echo $item->category ?></td>
            <td>
                <form method="post">
                    <input type="hidden" name="id" value="<?php echo $item->id?>">
                    <input type="hidden" name="product_id" value="<?php echo $item->product_id?>">
                    <input type="hidden" name="current_category" value="<?php echo $item->category?>">
                    <input type="hidden" name="status" value="1">
                    <input type="submit" name="change_apply" value="تغییر دسته بندی" class="button-primary" <?php echo $item->status_update_product_type == 1 ? 'disabled=""' : ''?>
                           onclick="return confirm('آیا از تغییر دسته بندی اطمینان دارید؟');">
                </form>
            </td>
            <td><?php echo $item->status_update_product_type == 1 ? '<span style="color: green">انجام شده</span>' : '<span style="color: red">انجام نشده</span>'?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>