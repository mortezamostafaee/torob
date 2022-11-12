<?php
global $wpdb;
$torob_main_product  =  $wpdb->prefix . "torob_main_product";
$torob_product_categories = $wpdb->prefix . 'torob_product_categories';
$torob_product_descriptions = $wpdb->prefix . 'torob_product_descriptions';
    if(isset($_POST['delete-product'])) {
        $id = $_POST['delete-product'];
        $wpdb->query( "DELETE  FROM $torob_main_product WHERE product_id = $id" );
        $wpdb->query( "DELETE  FROM $torob_product_categories WHERE product_id = $id" );
        $wpdb->query( "DELETE  FROM $torob_product_descriptions WHERE product_id = $id" );
    }
$all_product = $wpdb->get_results($wpdb->prepare("SELECT * FROM  $torob_main_product"));

?>
<h2>مشاهده محصولات مادر ذخیره شده</h2>
<table class="widefat">
    <thead>
    <tr>
        <th>تصویر محصول</th>
        <th>نام محصول</th>
        <th>ویرایش</th>
        <th>حذف</th>
    </tr>
    </thead>
    <tfoot>
    <tr>
        <th>تصویر محصول</th>
        <th>نام محصول</th>
        <th>ویرایش</th>
        <th>حذف</th>
    </tr>
    </tfoot>
    <tbody>

    <?php foreach ($all_product as $product) :?>
    <tr>
        <th><img src="<?php echo $product->url_image ?>" style="width: 100px;"></th>
        <th><?php echo $product->product_name ?> </th>
        <th><a href="<?php echo admin_url('edit.php?post_type=torob&page=edit-main-product&product_id=' .$product->product_id) ;?>" class="button-primary">ویرایش</a></th>
        <th>

            <form action="" method="post">
                <button type="submit" class="button-secondary" name="delete-product" value="<?php echo $product->product_id?>">حذف</button>
            </form>
        </th>

    </tr>
    <?php endforeach; ?>
    </tbody>
</table>