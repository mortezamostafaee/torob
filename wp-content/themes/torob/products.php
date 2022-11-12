<?php
global $wpdb;
$ID = $_GET['ID'];
$terms = get_terms([
    'taxonomy' => 'cat_torob',
    'hide_empty' => false,
]);
$torob_product = $wpdb->prefix . 'torob_product';

if (isset($_POST['update-po'])) {


    $wpdb->update($torob_product, array(
        'shopid' => $_GET['ID'],
        'status' => isset($_POST['publish']) ? "1" : "0",
        'adv' => isset($_POST['adv']) ? "1" : "0",
        'category' => isset($_POST['term']) ? json_encode($_POST['term']) : null,
    ), array(
        'ID' => $_POST['id'],
    ));

}
$result_torob_product = $wpdb->get_results("SELECT * FROM $torob_product where shopid = $ID");
?>
<style>
    .button-publish {
        background: #589933;
        color: #fff;
        border: none;
        padding: 10px;
        border-radius: 5px;
        cursor: pointer;
        transition: 0.5s;
    }

    .button-publish:hover {
        box-shadow: 5px 5px 5px #ccc;
        transition: 0.5s;
        background: #2c5e10;
    }

    .button-remove {
        background: #d71b35;
        border: none;
        padding: 10px;
        color: #fff;
        border-radius: 10px;
        cursor: pointer;
        transition: 0.5s;
    }

    .button-remove:hover {
        box-shadow: 5px 5px 5px #ccc;
        transition: 0.5s;
        background: #ae1026;
    }

    .button-un-publish {
        background: #d7961b;
        color: #fff;
        border: none;
        padding: 10px;
        border-radius: 5px;
        cursor: pointer;
        transition: 0.5s;
    }
</style>
<div class="wrap">
    <h2> لیست محصولات</h2>
    <hr>
    <table class="widefat">
        <thead>
        <tr>
            <th>نام محصول</th>
            <th>لینک محصول</th>
            <th> دسته بندی</th>
            <th> (انتشار / لغو انتشار) محصول</th>
            <th>آگهی</th>
            <th>وضعیت</th>
            <th> حذف محصول</th>
            <th>بروز رسانی</th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <th>نام محصول</th>
            <th>لینک محصول</th>
            <th> دسته بندی</th>
            <th> (انتشار / لغو انتشار) محصول</th>
            <th>آگهی</th>
            <th>وضعیت</th>
            <th> حذف محصول</th>
            <th>بروز رسانی</th>
        </tr>
        </tfoot>
        <tbody>
        <?php foreach ($result_torob_product as $item): ?>
            <form method="post">
                <input type="hidden" value="<?php echo $item->id ?>" name="id">
                <tr>
                    <td><?php echo $item->name ?></td>
                    <td><a href="<?php echo $item->link ?>" target="_blank">مشاهده محصول</a></td>
                    <td>
                        <select class="js-example-basic-multiple" name="term[]" multiple="multiple">
                            <?php foreach ($terms as $term) : ?>
                                <option value="<?php echo $term->name; ?>" <?php echo !empty($item->category) && in_array($term->name, json_decode($item->category)) ? 'selected="selected"' : '' ?>><?php echo $term->name; ?></option>
                            <?php endforeach; ?>
                        </select>

                    </td>
                    <td>
                        <input type="checkbox" name="publish"
                               value="1" <?php echo $item->status == 1 ? "checked" : "" ?> >
                    </td>

                    <th>
                        <input type="checkbox" name="adv" <?php echo $item->adv == 1 ? "checked" : "" ?> >
                    </th>
                    <th><?php echo $item->status == 0 ? "<span style='color: #ff0000;'>منتشر نشده</span>" : "<span style='color: #589933;'>منتشر شده</span>"; ?></th>
                    <td>
                        <input type="checkbox" name="remove" onclick="ConfirmDelete()">
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
    <div class="tablenav-pages"><span class="displaying-num">149 مورد</span>
        <span class="pagination-links"><span class="tablenav-pages-navspan button disabled" aria-hidden="true">«</span>
        <span class="tablenav-pages-navspan button disabled" aria-hidden="true">‹</span>
        <span class="screen-reader-text">برگهٔ فعلی</span><span id="table-paging" class="paging-input"><span
                        class="tablenav-paging-text">1 از <span class="total-pages">8</span></span></span>
        <a class="next-page button" href="#"><span class="screen-reader-text">برگهٔ بعدی</span><span aria-hidden="true">›</span></a>
        <a class="last-page button" href="#"><span class="screen-reader-text">برگهٔ آخر</span><span
                    aria-hidden="true">»</span></a></span>
    </div>

</div>


<script>
    jQuery(document).ready(function ($) {
        $(document).ready(function () {
            $('.js-example-basic-multiple').select2();
        });
    })

    function ConfirmDelete() {
        return confirm("آیا برای حذف این محصول اطمینان دارید؟");
    }
</script>

