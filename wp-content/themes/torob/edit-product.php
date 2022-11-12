<?php
global $wpdb;
$torob_posts = $wpdb->prefix . 'posts';
$torob_posts_meta = $wpdb->prefix . 'postmeta';
$result_posts = $wpdb->get_results("SELECT * FROM $torob_posts where post_type = 'torob' && post_status = 'publish'");
foreach ($result_posts as $post) {
    $post->post_meta = $wpdb->get_results("SELECT * FROM $torob_posts_meta where post_id = $post->ID AND (meta_key='shopLink' OR meta_key='shopName')");
}
$terms = get_terms([
    'taxonomy' => 'cat_torob',
    'hide_empty' => false,
]); ?>
<div class="wrap">
    <h2> لیست محصولات</h2>

    <hr><!-- comment -->

    <table class="widefat">
        <thead>
        <tr>
            <th>نام سایت</th>
            <th>نام فروشگاه</th>
            <th>ویرایش</th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <th>نام سایت</th>
            <th>نام فروشگاه</th>
            <th>ویرایش</th>
        </tr>
        </tfoot>
        <tbody>
        <?php foreach ($result_posts as $post): ?>
            <tr>
                <?php foreach ($post->post_meta as $meta): ?>
                    <?php if ($meta->meta_key === 'shopLink' || $meta->meta_key === 'shopName'): ?>
                        <td><?php echo $meta->meta_value ?></td>
                    <?php endif; ?>
                <?php endforeach; ?>
                <td><a href="<?php echo admin_url('edit.php?post_type=torob&page=products&ID=' . $post->ID); ?>"
                       class="button-primary">ویرایش</a></td>
            </tr>
        <?php endforeach; ?>

        </tbody>
    </table>
    <hr>
    <!--    <div class="tablenav-pages"><span class="displaying-num">149 مورد</span>-->
    <!--        <span class="pagination-links"><span class="tablenav-pages-navspan button disabled" aria-hidden="true">«</span>-->
    <!--        <span class="tablenav-pages-navspan button disabled" aria-hidden="true">‹</span>-->
    <!--        <span class="screen-reader-text">برگهٔ فعلی</span><span id="table-paging" class="paging-input"><span class="tablenav-paging-text">1 از <span class="total-pages">8</span></span></span>-->
    <!--        <a class="next-page button" href="#"><span class="screen-reader-text">برگهٔ بعدی</span><span aria-hidden="true">›</span></a>-->
    <!--        <a class="last-page button" href="#"><span class="screen-reader-text">برگهٔ آخر</span><span aria-hidden="true">»</span></a></span>-->
    <!--    </div>-->

</div>


<script>
    jQuery(document).ready(function ($) {
        $(document).ready(function () {
            $('.js-example-basic-single').select2();
        });
    })

    function ConfirmDelete() {
        return confirm("آیا برای حذف این محصول اطمینان دارید؟");
    }
</script>

