<?php
/* Template Name: shop list */
?>
<?php
global $wpdb;
global $post;
$shop = $wpdb->get_results($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_status != 'trash' AND post_type = 'torob' AND post_status = 'publish' order by ID desc"));
?>
<?php //echo do_shortcode("[wd_asp id=1]"); ?>
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
        <?php get_header(); ?>
    </div>
    <div class="d-flex gap-5">
        <aside class="user-side">
            <a href="<?php echo get_home_url() . '/analytics' ?>">
                <h6><img src="<?php echo get_template_directory_uri() . '/images/alert1.svg' ?>">تغییرات
                    قیمت</h6>
            </a>
            <a href="<?php echo get_home_url() . '/favorites' ?>">
                <h6><img src="<?php echo get_template_directory_uri() . '/images/hart.svg' ?>">محبوب ها</h6>
            </a>
            <a href="<?php echo get_home_url() . '/history' ?>">
                <h6><img src="<?php echo get_template_directory_uri() . '/images/time.svg' ?>">مشاهدات اخیر</h6>
            </a>
            <hr>

                <a href="<?php echo get_home_url() . '/shop-list' ?>"><h6 class="user-side-a">لیست فروشگاه های ترب</h6></a>
                <a href="<?php echo get_home_url() . '/shop-dashbord' ?>" target="_blank"><h6>ثبت نام فروشگاه</h6></a>
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
        <main class="main-user-panel">
            <h5 class="shop-list-title">فروشگاه‌های ثبت شده در ترب</h5>
            <div class="d-flex justify-content-center">
                <div class="w-25"><?php echo do_shortcode("[wd_asp id=4]"); ?></div>
            </div>
            <div class="d-flex main-shop-list gap-2">
                <?php foreach ($shop as $shop_content): ?>
                <?php $image = get_attached_media('image' , $shop_content->ID) ;?>
                <div class="shop-content d-flex align-items-center">
                    <img src="<?php echo reset($image)->guid ?? get_template_directory_uri().'/images/store-logo-placeholder.png'; ?>">
                    <a href="<?php echo $shop_content->post_name ?>" class="shop-name"><?php echo $shop_content->post_title ?></a>
                </div>
                <?php endforeach ; ?>
            </div>
        </main>
    </div>
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
    </script>
<?php get_footer() ?>