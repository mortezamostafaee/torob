<?php
global $wpdb;
global $post;
$user_id = do_shortcode('[current_user_id]');
$torob_torob_wishlist = $wpdb->prefix . 'torob_wishlist';
$torob_main_product = $wpdb->prefix . 'torob_main_product';
$torob_product_categories = $wpdb->prefix . 'torob_product_categories';
$torob_product = $wpdb->prefix . "torob_product";
$result = $wpdb->get_results("SELECT * FROM $torob_main_product");
$term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
$slug_term = $term->name;
$term_cat = get_term_by('slug', $term->name, 'cat_torob');
$taxonomy_name = 'cat_torob';
$queried_object = get_queried_object();
$term_id = $queried_object->term_id;
$termchildren = get_terms($taxonomy_name, array('hide_empty' => 0, 'parent' => $term_id, 'orderby' => 'parent',));
$result1 = $wpdb->get_results("SELECT * FROM $torob_product_categories where category =  $term_cat->name");
$result4 = $wpdb->get_results("SELECT * FROM $torob_torob_wishlist  where user_id = $user_id");
$query = "SELECT  *, (SELECT MIN($torob_product.price) FROM $torob_product WHERE $torob_product.productid = $torob_main_product.product_id ) as min_price, (SELECT COUNT('id') FROM $torob_product WHERE $torob_product.productid=$torob_main_product.product_id ) as count FROM $torob_main_product JOIN $torob_product_categories on $torob_main_product.product_id = $torob_product_categories.product_id where $torob_product_categories.category = '$term_cat->name'";
if (isset($_GET['available-input'])) {
    $query = $query . " AND $torob_main_product.stock = 1";
}


$productResult = $wpdb->get_results($query);

if (isset($_GET['select-price-min']) && ($_GET['select-price-min'] != '') && isset($_GET['select-price-max']) && ($_GET['select-price-max'] != '')) {
    $temp = [];
    $max_price = $_GET['select-price-max'];
    $min_price = $_GET['select-price-min'];

    foreach ($productResult as $p) {
        if ($p->min_price >= $min_price && $p->min_price <= $max_price) {
            array_push($temp, $p);
        }
    }
    $productResult = $temp;
}
?>

    <link rel="stylesheet" href="<?php echo get_template_directory_uri() . '/css/custom-page.css' ?>">
    <body class="category-<?php echo get_queried_object()->term_id ?>">
    <div class="main-user-torob">
        <div class="row custom-header">
            <div class="col-md-1 d-flex p-t-10">
                <img style="width: 48px;height: 48px;"
                     src="<?php echo get_template_directory_uri() . '/images/logo.png' ?>">
                <h2 class="h1-torob">ترب</h2>
            </div>
            <div class="col-md-7">
                <?php echo do_shortcode("[wd_asp id=2]"); ?>
            </div>
            <div class="col-md-4 user-torob1">
                <?php if (is_user_logged_in()): ?>
                    <div class="user-torob">
                        <div class="dropdown">
                            <button onclick="myFunction()" class="dropbtn"> <?php
                                global $current_user;
                                wp_get_current_user();
                                echo $current_user->display_name;
                                ?></button>
                            <div id="myDropdown" class="dropdown-content">
                                <a href="<?php echo get_home_url() . '/analytics' ?>">تغییرات قیمت</a>
                                <a href="<?php echo get_home_url() . '/favorites' ?>">محبوب ها</a>
                                <a href="<?php echo get_home_url() . '/history' ?>">مشاهدات اخیر</a>
                                <a href="<?php echo wp_logout_url(home_url()); ?>">خروج</a>
                            </div>
                        </div>

                    </div>
                <?php else: ?>

                    <div class="box-reg">
                        <a class="button-reg" href="#popup1">ورود / ثبت نام</a>
                    </div>

                    <div id="popup1" class="overlay-reg">
                        <div class="popup-reg">
                            <p>ورود یا ثبت نام</p>
                            <a class="close-reg" href="#">&times;</a>
                            <div class="content-reg">
                                <!--                            --><?php //echo do_shortcode("[insert page='login' display='content']"); ?>
                                <iframe src="<?php echo get_home_url() . '/login-register' ?>"
                                        style="width: 100% ; height: 266px"></iframe>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

            </div>
        </div>
        <?php get_header(); ?>
    </div>
    <div class="d-flex gap-5">
        <aside class="product-side">
            <button class="accordion active">دسته بندی دقیق تر<i class="fas fa-angle-down"></i></button>
            <div class="panel">
                <a href=""><p><i class="fas fa-angle-left p-l-10"></i><?php echo $term_cat->name ?? '' ?> </p></a>
                <?php
                foreach ($termchildren as $child) {
                    $term = get_term_by('id', $child->term_id, $taxonomy_name);
                    echo '<a href="' . get_term_link($child, $taxonomy_name) . '"><p>' . $term->name . '</p></a>';
                }
                ?>
            </div>
            <hr>
            <button class="accordion active">قیمت (تومان)<i class="fas fa-angle-down"></i></button>
            <div class="panel">
                <form method="get">
                    <?php if (isset($_REQUEST["available-input"])) { ?>
                        <input type="hidden"
                               name="available-input"
                               value="<?php echo htmlspecialchars($_REQUEST["available-input"]) ?>"/>
                    <?php } ?>

                    <div class="panel d-flex gap-3">
                        <p class="reng-slider">از<input type="text" class="select-price" name="select-price-min"
                                                        value="<?php echo $_GET['select-price-min'] ?? '' ?>"
                                                        dir="auto"></p>
                        <p class="reng-slider"> تا <input type="text" class="select-price" name="select-price-max"
                                                          value="<?php echo $_GET['select-price-max'] ?? '' ?>"
                                                          dir="auto"></p>
                    </div>
                    <input type="submit" value="اعمال فیلتر" name="price-filter"
                           class="filter-price mt-3 btn btn-secondary">
                </form>
            </div>
            <hr>
            <button class="accordion active">جستجوی نتایج<i class="fas fa-angle-down"></i></button>
            <div class="panel">
                <?php echo do_shortcode("[wd_asp id=3]"); ?>
            </div>

            <hr>
            <button class="accordion active"> موجودی<i class="fas fa-angle-down"></i></button>
            <div class="panel">
                <div class="d-flex input-hpme gap-3">
                    <form method="get">
                        <?php if (isset($_REQUEST["select-price-min"])) { ?>
                            <input type="hidden"
                                   name="select-price-min"
                                   value="<?php echo htmlspecialchars($_REQUEST["select-price-min"]); ?>"/>
                        <?php } ?>
                        <?php if (isset($_REQUEST["select-price-max"])) { ?>
                            <input type="hidden"
                                   name="select-price-max"
                                   value="<?php echo htmlspecialchars($_REQUEST["select-price-max"]); ?>"/>
                        <?php } ?>


                        <label for="available-input">نمایش محصولات موجود</label>
                        <input type="checkbox" id="available-input" class="available-input" style="cursor: pointer;"
                               name="available-input" <?php echo isset($_GET['available-input']) ? 'checked' : '' ?>>
                        <input type="submit" name="available-input-btn" value="اعمال فیلتر"
                               class="filter-price mt-3 btn btn-secondary">
                    </form>
                </div>
            </div>
            <hr>
        </aside>
        <div class="main-product">
            <?php
            echo '<h1 class="the-title">' . single_cat_title('قیمت انواع ', false) . '</h1>';
            ?>
            <div class="d-flex gap-3 flex-wrap product-area">
                <?php foreach ($productResult as $item1) : ?>

                    <?php $product_id = $item1->product_id; ?>
                    <div class="product-torob">
                        <a href="<?php echo get_home_url() . '/single-product/?id=' . $item1->product_id . '' ?>">
                            <img src="<?php echo $item1->url_image ?>" style="width: 135px;height: 145px;"></a>
                        <h2 class="info-product"><?php echo $item1->product_name ?></h2>
                        <br>
                        <p class="price-torob">از <?php
                            $number = $item1->min_price;
                            echo $english_format_number = number_format($number); ?> تومان</p>
                        <p class="in-shop">در <?php echo $item1->count ?> فروشگاه</p>
                        <div class="d-flex justify-content-around icon-product">
                            <div>
                                <form action="" method="post" name="wishlist-torob" style="margin-bottom: 0;"
                                      onsubmit="event.preventDefault()">
                                    <input id="admin_url" type="hidden"
                                           value="<?php echo admin_url('admin-ajax.php') ?>"/>
                                    <input id="wishlist_id-<?php echo $product_id ?>" type="hidden" value="0"/>
                                    <input id="product_id-<?php echo $product_id ?>" type="hidden"
                                           value="<?php echo $product_id ?>"/>
                                    <input id="user_id" type="hidden" value="<?php echo $user_id ?>"/>
                                    <button name="wishlist-torob"
                                            onclick="save_wishlist_torob('<?php echo $product_id ?>')"
                                            style="background: none;border: none;color: #999;">
                                        <?php if (count($result4) > 0): ?>
                                            <?php
                                            $flag = true;
                                            foreach ($result4 as $item) : ?>
                                                <?php if ($flag && is_user_logged_in()): ?>
                                                    <?php if ($item && $item->user_id == $user_id && $item->product_id == $product_id) : ?>
                                                        <?php $flag = false ?>
                                                        <i class="fas fa-heart"
                                                           id="heart-torob-<?php echo $product_id ?>"></i>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                            <?php if ($flag && is_user_logged_in()): ?>
                                                <i class="far fa-heart"
                                                   id="heart-torob-<?php echo $product_id ?>"></i>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <i class="far fa-heart"
                                               id="heart-torob-<?php echo $product_id ?>"></i>
                                        <?php endif; ?>
                                    </button>
                                </form>
                                <?php if (!is_user_logged_in()) {
                                    echo '<i class="far fa-heart"></i>';
                                } ?>
                            </div>
                            <div><i class="far fa-bell"></i></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    </body>
    <footer class="custom-footer">
        <div class="row">
            <div class="col-md-3">
                <div class="menu-footer"><?php wp_nav_menu(array('theme_location' => 'footer-user-panel-1')) ?></div>
            </div>
            <div class="col-md-3">
                <div class="menu-footer"><?php wp_nav_menu(array('theme_location' => 'footer-user-panel-2')) ?></div>
            </div>
            <div class="col-md-6 d-flex justify-content-end namad-torob">
                <img src="<?php echo get_template_directory_uri() . '/images/etehadiye.png' ?>">
                <img src="<?php echo get_template_directory_uri() . '/images/e-namad.png' ?>">
                <img src="<?php echo get_template_directory_uri() . '/images/rasane.png' ?>">
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-3 d-flex align-items-center"><span>ترب، موتور جستجوی هوشمند خرید</span></div>
            <div class="col-md-3 social-torob d-flex align-items-center"><a href="#"><i
                            class="fab fa-instagram"></i></a><a
                        href="#"><i class="fab fa-twitter"></i></a><a href="#"> <i class="fab fa-linkedin-in"></i></a>
            </div>
            <div class="col-md-6 d-flex justify-content-end namad-torob market-torob">
                <img src="<?php echo get_template_directory_uri() . '/images/myket.png' ?>">
                <img src="<?php echo get_template_directory_uri() . '/images/bazaar-badge.png' ?>">
                <img src="<?php echo get_template_directory_uri() . '/images/google-play-btn.png' ?>">
            </div>

        </div>
    </footer>
    <script>
        var acc = document.getElementsByClassName("accordion");
        var i;

        for (i = 0; i < acc.length; i++) {
            acc[i].addEventListener("click", function () {
                /* Toggle between adding and removing the "active" class,
                to highlight the button that controls the panel */
                this.classList.toggle("active");

                /* Toggle between hiding and showing the active panel */
                var panel = this.nextElementSibling;
                if (panel.style.display === "none") {
                    panel.style.display = "block";
                } else {
                    panel.style.display = "none";
                }
            });
        }

        /*ajax*/

        function save_wishlist_torob(productId) {

            jQuery(document).ready(function ($) {
                var host = document.getElementById("admin_url").value;
                var product_id = document.getElementById("product_id-" + productId).value;
                var user_id = document.getElementById("user_id").value;

                $.ajax({
                    method: 'POST',
                    url: host,
                    data: {
                        'action': 'markWishlist',
                        'user_id': user_id,
                        'product_id': product_id,
                    }
                })
                    .done(function (response) {
                        if (response.like) {
                            $("#heart-torob-" + productId).removeClass('far').addClass('fas')
                        } else {
                            $("#heart-torob-" + productId).removeClass('fas').addClass('far')
                        }
                    });
            });
        }

        /*ajax*/
    </script>
<?php get_footer() ?>