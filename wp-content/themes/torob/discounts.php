<?php
/* Template Name: Discounts */
global $wpdb;
$user_id = do_shortcode('[current_user_id]');
$torob_torob_wishlist = $wpdb->prefix . 'torob_wishlist';
$result4 = $wpdb->get_results("SELECT * FROM $torob_torob_wishlist  where user_id = $user_id");
?>
    <body class="page-discounts">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri() . '/css/custom-page.css' ?>">
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
                <div class="user-torob">
                    <?php if (is_user_logged_in()) : ?>
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
                    <div class="box-reg reg-header">
                        <a class="button-reg" href="#popup1">ورود / ثبت نام</a>
                    </div>
                    <div id="popup1" class="overlay-reg">
                        <div class="popup-reg">
                            <p>ورود یا ثبت نام</p>
                            <a class="close-reg" href="#">&times;</a>
                            <div class="content-reg">
                                <?php echo do_shortcode("[insert page='login' display='content']"); ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>
<?php get_header(); ?>
    </div>


        <main class="main-user-panel-discounts">
            <?php while (have_posts()) : the_post(); ?>
                <?php the_content(); ?>
            <?php endwhile; ?>

<!--            <div class="row">-->
<!--                <div class="col-md-2">-->
<!--                    <div class="product-analytics">-->
<!--                        <a href=""> <img-->
<!--                                    src="--><?php //echo get_template_directory_uri() . '/images/product.jpg' ?><!--"-->
<!--                                    style="width: 135px;height: 145px;"></a>-->
<!--                        <h2 class="info-product">روغن</h2>-->
<!--                        <br>-->
<!--                        <p class="price-torob">از ۴٫۱۳۰٫۰۰۰ تومان</p>-->
<!--                        <p class="in-shop">در ۱۵۲ فروشگاه</p>-->
<!--                        <div class="d-flex justify-content-around icon-product">-->
<!--                            <div>-->
<!--                                <form action="" method="post" name="wishlist-torob" style="margin-bottom: 0;"-->
<!--                                      onsubmit="event.preventDefault()">-->
<!--                                    <input id="admin_url" type="hidden" value="--><?php //echo admin_url('admin-ajax.php') ?><!--"/>-->
<!--                                    <input id="wishlist_id-" type="hidden" value="0"/>-->
<!--                                    <input id="product_id-" type="hidden" value=""/>-->
<!--                                    <input id="user_id" type="hidden" value=""/>-->
<!--                                    <button name="wishlist-torob" onclick=""-->
<!--                                            style="background: none;border: none;color: #999;">-->
<!--                                        <i class="fas fa-heart" id="heart-torob-"></i>-->
<!--                                    </button>-->
<!--                                </form>-->
<!--                            </div>-->
<!--                            <div><i class="far fa-bell"></i></div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!---->
<!--            </div>-->
        </main>


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
                            class="fab fa-instagram"></i></a><a href="#"><i class="fab fa-twitter"></i></a><a href="#">
                    <i class="fab fa-linkedin-in"></i></a></div>
            <div class="col-md-6 d-flex justify-content-end namad-torob market-torob">
                <img src="<?php echo get_template_directory_uri() . '/images/myket.png' ?>">
                <img src="<?php echo get_template_directory_uri() . '/images/bazaar-badge.png' ?>">
                <img src="<?php echo get_template_directory_uri() . '/images/google-play-btn.png' ?>">
            </div>

        </div>
    </footer>
    <script>

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