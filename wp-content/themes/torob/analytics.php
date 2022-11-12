<?php
/* Template Name: analaytics */
global $wpdb;
$user_id = do_shortcode('[current_user_id]');
$torob_torob_wishlist = $wpdb->prefix . 'torob_wishlist';
$result4 = $wpdb->get_results("SELECT * FROM $torob_torob_wishlist  where user_id = $user_id");
?>

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
<?php if (is_user_logged_in()): ?>
    <div class="d-flex gap-5">
        <aside class="user-side">
            <a href="<?php echo get_home_url() . '/analytics' ?>">
                <h6 class="user-side-a"><img src="<?php echo get_template_directory_uri() . '/images/alert.svg' ?>">تغییرات
                    قیمت</h6>
            </a>
            <a href="<?php echo get_home_url() . '/favorites' ?>">
                <h6><img src="<?php echo get_template_directory_uri() . '/images/hart.svg' ?>">محبوب ها</h6>
            </a>
            <a href="<?php echo get_home_url() . '/history' ?>">
                <h6><img src="<?php echo get_template_directory_uri() . '/images/time.svg' ?>">مشاهدات اخیر</h6>
            </a>
            <hr>
            <a href="#">
                <a href="<?php echo get_home_url() . '/shop-list' ?>"><h6>لیست فروشگاه های ترب</h6></a>
            </a>
            <a href="<?php echo get_home_url() . '/shop-dashbord' ?>" target="_blank">
                <h6>ثبت نام فروشگاه</h6>
            </a>
            <hr>

            <button class="accordion"> پیگیری سفارش<i class="fas fa-angle-down"></i></button>
            <div class="panel">
                <a href="<?php echo get_home_url() . '/feedback' ?>"><p>ثبت و مشاهده پیامها</p></a>
                <a href="<?php echo get_home_url() . '/track-order-guide' ?>"><p>راهنما</p></a>
            </div>


            <button class="accordion"> راهنمایی و شرایط<i class="fas fa-angle-down"></i></button>
            <div class="panel">
                <a href="<?php echo get_home_url() . '/safe-shopping-guide' ?>"><p>راهنمای خرید امن</p></a>
                <a href="<?php echo get_home_url() . '/terms-and-conditions' ?>"><p>قوانین و مقررات</p></a>
                <a href="<?php echo get_privacy_policy_url() ?>"><p> حریم خصوصی</p></a>
            </div>
            <a href="<?php echo get_home_url() . '/contact'; ?>"><p>تماس با ما</p></a>
            <a href="<?php echo get_home_url() . '/about-us'; ?>"><p> درباره ترب </p></a>
            <hr>
            <a href="<?php echo wp_logout_url(home_url()); ?>">خروج </a>
            <p>
                <?php
                global $current_user;
                wp_get_current_user();
                echo $current_user->display_name;
                ?>
            </p>
        </aside>
        <!--        <main class="main-user-panel">-->
        <!--            <span><img src="-->
        <?php //echo get_template_directory_uri() . '/images/empty_watched.png' ?><!--"></span>-->
        <!--            <p> اعلان قیمت را برای محصولات دلخواه خود فعال کنید تا از موجودی و تغییرات قیمت‌شان مطلع شوید.</p>-->
        <!--        </main>-->
        <main class="main-user-panel2">
            <div class="d-flex justify-content-between">
                <h1 style="color: rgb(51, 51, 51); font-weight: bold; font-size: 24px; line-height: 40px; display: inline-block; margin: 0px;">
                    تغییرات قیمت</h1>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <div class="product-analytics">
                        <a href=""> <img
                                    src="<?php echo get_template_directory_uri() . '/images/product.jpg' ?>"
                                    style="width: 135px;height: 145px;"></a>
                        <h2 class="info-product">روغن</h2>
                        <br>
                        <p class="price-torob">از ۴٫۱۳۰٫۰۰۰ تومان</p>
                        <p class="in-shop">در ۱۵۲ فروشگاه</p>
                        <div class="d-flex justify-content-around icon-product">
                            <div>
                                <form action="" method="post" name="wishlist-torob" style="margin-bottom: 0;"
                                      onsubmit="event.preventDefault()">
                                    <input id="admin_url" type="hidden" value="<?php echo admin_url('admin-ajax.php') ?>"/>
                                    <input id="wishlist_id-" type="hidden" value="0"/>
                                    <input id="product_id-" type="hidden" value=""/>
                                    <input id="user_id" type="hidden" value=""/>
                                    <button name="wishlist-torob" onclick=""
                                            style="background: none;border: none;color: #999;">
                                        <i class="fas fa-heart" id="heart-torob-"></i>
                                    </button>
                                </form>
                            </div>
                            <div><i class="far fa-bell"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-10" style="padding: 0">
                    <div class="d-flex history-pro">
                        <div class="w-50">
                            <h4 style="font-size: 18px;color: #000;" class="mb-3">تاریخچه تغییر قیمت</h4>
                            <div class="mb-4">
                              <span class="history-detail"
                                    style="font-size: 12px; color: rgb(153, 153, 153); line-height: 13px;">۵ دقیقه پیش</span>
                                <h4 class="history-title" style="margin: 0px; line-height: 20px;">
                                    <img src="<?php echo get_template_directory_uri() . '/images/not_available.png' ?>">
                                    <span class="history-type"
                                          style="display: inline-block;"> بدون تغییر در فروشگاه تست </span>
                                </h4>
                                <span class="history-detail"
                                      style="font-size: 12px; color: rgb(153, 153, 153); line-height: 13px;">از ۶٫۴۶۰٫۰۰۰ تومان به ۶٫۵۶۰٫۰۰۰ تومان</span>
                            </div>
                            <div class="mb-4">
                              <span class="history-detail"
                                    style="font-size: 12px; color: rgb(153, 153, 153); line-height: 13px;">۵ دقیقه پیش</span>
                                <h4 class="history-title" style="margin: 0px; line-height: 20px;">
                                    <img src="<?php echo get_template_directory_uri() . '/images/available.png' ?>">
                                    <span class="history-type"
                                          style="display: inline-block;">موجود شدن در فروشگاه تست 1</span>
                                </h4>
                                <span class="history-detail"
                                      style="font-size: 12px; color: rgb(153, 153, 153); line-height: 13px;">از ۶٫۴۶۰٫۰۰۰ تومان به ۶٫۵۶۰٫۰۰۰ تومان</span>
                            </div>
                            <div class="mb-4">
                              <span class="history-detail"
                                    style="font-size: 12px; color: rgb(153, 153, 153); line-height: 13px;">۵ دقیقه پیش</span>
                                <h4 class="history-title" style="margin: 0px; line-height: 20px;">
                                    <img src="<?php echo get_template_directory_uri() . '/images/trending_down.png' ?>">
                                    <span class="history-type"
                                          style="display: inline-block;">کاهش قیمت در فروشگاه تست 2</span>
                                </h4>
                                <span class="history-detail"
                                      style="font-size: 12px; color: rgb(153, 153, 153); line-height: 13px;">از ۶٫۴۶۰٫۰۰۰ تومان به ۶٫۵۶۰٫۰۰۰ تومان</span>
                            </div>
                            <div class="mb-4">
                              <span class="history-detail"
                                    style="font-size: 12px; color: rgb(153, 153, 153); line-height: 13px;">۵ دقیقه پیش</span>
                                <h4 class="history-title" style="margin: 0px; line-height: 20px;">
                                    <img src="<?php echo get_template_directory_uri() . '/images/trending_up.png' ?>">
                                    <span class="history-type"
                                          style="display: inline-block;">افزایش قیمت در فروشگاه تست 3</span>
                                </h4>
                                <span class="history-detail"
                                      style="font-size: 12px; color: rgb(153, 153, 153); line-height: 13px;">از ۶٫۴۶۰٫۰۰۰ تومان به ۶٫۵۶۰٫۰۰۰ تومان</span>
                            </div>
                        </div>
                        <div class="w-50 text-center">
                            <h4 style="font-size: 18px;color: #000;"> نمودار قیمت</h4>
                            <img src="<?php echo get_template_directory_uri() . '/images/chart.png' ?>">
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>
<?php else: ?>
    <div class="row" style="width: 100%;min-height: 100vh;">
        <div class="container d-flex justify-content-center" style="background-color: #fff;">

            <img src="<?php echo get_template_directory_uri() . '/images/user-premision.jpg' ?>">

        </div>
        <div class="container" style="background-color: #fff;">
            <p class="access-user">شما اجازه دسترسی به این صفحه را ندارید</p>
            <p class="access-user">برای مشاهده این صفحه وارد سایت شوید </p>
            <iframe src="<?php echo get_home_url() . '/login-register' ?>"
                    style="width: 100% ; height: 232px"></iframe>
            <br>
        </div>
    </div>
<?php endif; ?>
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
        var acc = document.getElementsByClassName("accordion");
        var i;

        for (i = 0; i < acc.length; i++) {
            acc[i].addEventListener("click", function () {
                /* Toggle between adding and removing the "active" class,
                to highlight the button that controls the panel */
                this.classList.toggle("active");

                /* Toggle between hiding and showing the active panel */
                var panel = this.nextElementSibling;
                if (panel.style.display === "block") {
                    panel.style.display = "none";
                } else {
                    panel.style.display = "block";
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