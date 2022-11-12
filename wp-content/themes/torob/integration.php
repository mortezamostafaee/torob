<?php
global $wpdb;
$torob_integration = $wpdb->prefix . "torob_integration";
$torob_main_product = $wpdb->prefix . "torob_main_product";
$torob_product = $wpdb->prefix . "torob_product";
$torob_users = $wpdb->prefix . "users";
if (isset($_POST['integration_apply'])) {
    var_dump($_POST);
    $id = $_POST['id'];
    $torob_p_id = $_POST['torob_p_id'];
    $wpdb->update($torob_product, array(
        'productid' => $_POST['product_main_id'],
    ), array(
        'id' => $torob_p_id,
    ));

    $wpdb->update($torob_integration, array(
        'integration_status' => $_POST['status'],
    ), array(
        'id' => $id,
    ));
}
$get_results_integration = $wpdb->get_results("SELECT *, (SELECT ($torob_users.display_name) FROM $torob_users WHERE $torob_integration.user_id = $torob_users.ID ) as display_name ,  (SELECT ($torob_main_product.product_name) FROM $torob_main_product WHERE $torob_integration.product_main_id = $torob_main_product.product_id ) as main_product_name ,  (SELECT ($torob_main_product.product_name) FROM $torob_main_product WHERE $torob_integration.product_integration_id = $torob_main_product.product_id ) as integration_product_name ,  (SELECT ($torob_product.id) FROM $torob_product WHERE $torob_integration.product_integration_id = $torob_product.productid ) as torob_p_id  FROM $torob_integration order by time desc ");

var_dump($get_results_integration);
?>
<h2>محصولات پیشنهاد شده برای ادغام </h2>
<hr>
<table class="widefat">
    <thead>
    <tr>
        <th>نام کاربر</th>
        <th>محصول مادر</th>
        <th>محصول پیشنهاد شده برای ادغام</th>
        <th>ادغام</th>
        <th>وضعیت</th>
    </tr>
    </thead>
    <tfoot>
    <tr>
        <th>نام کاربر</th>
        <th>محصول مادر</th>
        <th>محصول پیشنهاد شده برای ادغام</th>
        <th>ادغام</th>
        <th>وضعیت</th>
    </tr>
    </tfoot>
    <tbody>
    <?php

    foreach ($get_results_integration as $item) : ?>
        <tr>
            <td class="d-flex align-items-center"><p><?php echo $item->display_name ?></p></td>
            <td><?php echo $item->main_product_name ?></td>
            <td><?php echo $item->integration_product_name ?></td>
            <td>
                <form method="post">
                    <input type="hidden" name="id" value="<?php echo $item->id ?>">
                    <input type="hidden" name="torob_p_id" value="<?php echo $item->torob_p_id ?>">
                    <input type="hidden" name="product_main_id" value="<?php echo $item->product_main_id ?>">
                    <input type="hidden" name="product_integration_id"
                           value="<?php echo $item->product_integration_id ?>">
                    <input type="hidden" name="status" value="1">
                    <input type="submit" name="integration_apply" value="ادغام کن" class="button-primary"
                           onclick="return confirm('آیا از ادغام محصول اطمینان دارید؟');" <?php echo $item->integration_status == 1 ? 'disabled=""' : '' ?>>
                </form>
            </td>
            <td><?php echo $item->integration_status == 1 ? '<span style="color: green">انجام شده</span>' : '<span style="color: red">انجام نشده</span>' ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>