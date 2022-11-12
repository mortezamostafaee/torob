<?php
/* Template Name: favorites */
global $wpdb;
$user_id = do_shortcode('[current_user_id]');
$torob_torob_wishlist = $wpdb->prefix . 'torob_wishlist';
$torob_main_product = $wpdb->prefix . "torob_main_product";
$result4 = $wpdb->get_results("SELECT * FROM $torob_torob_wishlist  where user_id = $user_id");
$result1 = $wpdb->get_results("SELECT * FROM $torob_torob_wishlist JOIN $torob_main_product on $torob_torob_wishlist.product_id = $torob_main_product.product_id where $torob_torob_wishlist.user_id = $user_id");
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
                <h6><img src="<?php echo get_template_directory_uri() . '/images/alert1.svg' ?>">تغییرات قیمت</h6>
            </a>
            <a href="<?php echo get_home_url() . '/favorites' ?>">
                <h6 class="user-side-a"><img src="<?php echo get_template_directory_uri() . '/images/hart1.svg' ?>">محبوب
                    ها</h6>
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
            <a href="<?php echo wp_logout_url(home_url()); ?>">خروج از حساب</a>
            <p>
                <?php
                global $current_user;
                wp_get_current_user();
                echo $current_user->display_name;
                ?>
            </p>
        </aside>
        <?php if (!$result1) : ?>
            <main class="main-user-panel">
                <span><img src="<?php echo get_template_directory_uri() . '/images/empty_likes.png' ?>"></span>
                <p>محصولات محبوب خود را انتخاب کنید تا بعدا راحت‌تر پیدایشان کنید.</p>
            </main>
        <?php else : ?>
            <main class="main-user-panel2">
                <?php if ($result1 && $result1[0] && $user_id == $result1[0]->user_id) : ?>
                <h1 style="color: rgb(51, 51, 51); font-weight: bold; font-size: 24px; line-height: 40px; display: inline-block; margin: 0px;">
                    لیست علاقه مندی ها</h1><br>
                <div class="d-flex gap-3">
                    <?php foreach ($result1 as $item) : ?>
                        <?php $product_id = $item->product_id; ?>
                        <a href="<?php echo get_home_url() . '/single-product/?id=' . $item->product_id . '' ?>">
                            <div class="product-torob">
                                <a href="<?php echo get_home_url() . '/single-product/?id=' . $item->product_id . '' ?>">
                                    <img src="<?php echo $item->url_image ?>" style="width: 135px;height: 145px;">
                                </a>
                                <h2 class="info-product"><?php echo $item->product_name ?></h2>
                                <br>
                                <p class="price-torob">از ۴٫۱۳۰٫۰۰۰ تومان</p>
                                <p class="in-shop">در ۱۵۲ فروشگاه</p>
                                <div class="d-flex justify-content-around icon-product">
                                    <div>
                                        <form action="" method="post" name="wishlist-torob" style="margin-bottom: 0;"
                                              onsubmit="event.preventDefault()">
                                            <input id="admin_url" type="hidden"
                                                   value="<?php echo admin_url('admin-ajax.php') ?>"/>
                                            <input id="wishlist_id-<?php echo $product_id ?>" type="hidden" value="0"/>
                                            <input id="product_id-<?php echo $product_id ?>" type="hidden" value="<?php echo $product_id ?>"/>
                                            <input id="user_id" type="hidden" value="<?php echo $user_id ?>"/>
                                            <button name="wishlist-torob" onclick="save_wishlist_torob('<?php echo $product_id ?>')"
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
                                                    <?php if ($flag): ?>
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
                        </a>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </main>
        <?php endif ?>
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
                    style="width: 100% ; height: 266px"></iframe>
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