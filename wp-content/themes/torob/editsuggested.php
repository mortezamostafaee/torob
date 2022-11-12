<?php
global $wpdb;
$product_id = $_GET['product_id'];
$terms = get_terms([
    'taxonomy' => 'cat_torob',
    'hide_empty' => false,
]);
$torob_product = $wpdb->prefix . 'torob_product';
$torob_main_product = $wpdb->prefix . 'torob_main_product';
$torob_separation_seller = $wpdb->prefix . 'torob_separation_seller';
if (isset($_POST['update-po'])) {

    $wpdb->update($torob_product, array(
        'category' => isset($_POST['term']) ? json_encode($_POST['term']) : null,
        'productid' => $_POST['main-product']
    ), array(
        'id' => $product_id,
    ));

}
$result_torob_product = $wpdb->get_results("SELECT * FROM $torob_product where id = $product_id");
$result_torob_main_product = $wpdb->get_results("SELECT * FROM $torob_main_product");
$result_torob_separation_seller  = $wpdb->get_results("SELECT * FROM $torob_separation_seller where product_id = $product_id");
?>

<div class="wrap">
    <h2> لیست محصولات</h2>
    <hr>
    <table class="widefat">
        <thead>
        <tr>
            <th>نام محصول</th>
            <th>محصول مادر پیشنهادی</th>
            <th>لینک محصول</th>
            <th> دسته بندی</th>
            <th>محصول مادر</th>
            <th>بروز رسانی</th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <th>نام محصول</th>
            <th>محصول مادر پیشنهادی</th>

            <th>لینک محصول</th>
            <th> دسته بندی</th>
            <th>محصو مادر</th>
            <th>بروز رسانی</th>
        </tr>
        </tfoot>
        <tbody>
        <?php foreach ($result_torob_product as $item): ?>
            <form method="post">

                <tr>
                    <td><?php echo $item->name ?></td>
                    <td>
                        <?php foreach ($result_torob_separation_seller as $seller):?>
                        <?php echo $seller->suggested_category ?>
                        <?php endforeach; ?>
                    </td>

                    <td><a href="<?php echo $item->link ?>" target="_blank">مشاهده محصول</a></td>
                    <td>
                        <select class="js-example-basic-multiple" name="term[]" multiple="multiple">
                            <?php foreach ($terms as $term) : ?>
                                <option value="<?php echo $term->name; ?>" <?php echo !empty($item->category) && in_array($term->name, json_decode($item->category)) ? 'selected="selected"' : '' ?>>
                                    <?php echo $term->name; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                    </td>
                    <td>
                        <select class="js-example-basic-single" name="main-product">
                            <?php foreach ($result_torob_main_product as $main) : ?>
                                <option value="<?php echo $main->product_id ?>" <?php echo $item->productid === $main->product_id ? 'selected' : null ?>><?php echo $main->product_name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <th>
                        <input type="submit" name="update-po" value="بروز رسانی" class="button-primary">
                    </th>
                </tr>
            </form>
        <?php endforeach; ?>
        </tbody>
    </table>


    <hr>
</div>


<script>
    jQuery(document).ready(function ($) {
        $(document).ready(function () {
            $('.js-example-basic-multiple').select2();
            $('.js-example-basic-single').select2();
        });
    })
</script>

