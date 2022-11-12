<?php
global $wpdb;
$singleShop = $wpdb->get_results($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_status != 'trash' AND post_type = 'torob' order by ID desc"));

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
    <aside class="product-side">
        <ul class="direction">
            <li><a href="#">فروشگاه های ترب</a></li> > <li><a href="#"><?php the_title() ?></a></li>
        </ul>
        <div class="d-flex gap-2 align-items-centerf">

            <div class="side-image">
                <img src="<?php echo get_field('logo') ??  get_template_directory_uri().'/images/store-logo-placeholder.png'; ?>">
            </div>
            <div>
                <p>فروشگاه <?php the_title() ?></p>
                <a href="https://<?php echo the_field('shopLink');?>" class="shop-link-side" target="_blank"><?php the_field('shopLink'); ?></a>
                <p class="city"> <?php the_field('state'); echo '&nbsp،';the_field('city'); ?></p>
            </div>
        </div>
    </aside>
    <div class="main-product">
     <h6>مجوزها و اعتبار</h6>
        <div class="detile">
            <p>وضعیت نماد: <?php the_field('icon_status'); ?></p>
            <p> صاحب امتیاز نماد: <?php the_field('owner_icon'); ?></p>
            <p> تاریخ اخذ نماد اعتماد: <?php the_field('start_date_icon'); ?></p>
            <p> تاریخ اعتبار نماد اعتماد: <?php the_field('end_date_icon'); ?></p>
        </div>
        <h6>سابقه همکاری با ترب</h6>
        <div class="detile">
            <p> شروع همکاری با ترب: <?php the_field('start_date'); ?></p>
            <p> زمان فعالیت در ترب: <?php the_field('activity_time'); ?></p>
            <p> وضعیت فعلی در ترب: <?php the_field('current_situation'); ?></p>
        </div>
        <h6>امتیاز عملکرد</h6>
        <div class="detile">
            <p><?php the_field('score'); ?></p>
        </div>
        <h6>رویه های پرداخت</h6>
        <div class="detile">
            <p>  <?php the_field('pay'); ?></p>
        </div>
        <h6>رویه های ارسال</h6>
        <div class="detile">
            <p>  <?php the_field('send'); ?></p>
        </div>
        <h6>پیگیری سفارش از طریق ترب </h6>
        <div class="detile">
            <p>  در صورتی که از طریق فروشگاه موفق به پیگیری سفارش خود نشده اید، می توانید از طریق ثبت پیگیری سفارش در ترب اقدام نمایید.</p>
            <a href="<?php echo get_home_url().'/feedback'?>" class="btn btn-primary" style="color: #fff;">پیگیری سفارش</a>
        </div>
        <h6>رویه‌های تست و مرجوعی</h6>
        <div class="detile">
            <p>  <?php the_field('test'); ?></p>
        </div>
        <h6> اطلاعات تماس</h6>
        <div class="detile">
            <p> دامنه: <a href="https://<?php echo the_field('shopLink');?>" target="_blank"><?php the_field('shopLink'); ?></a>
            <br>
                <?php the_field('state');  echo '&nbsp،&nbsp'; the_field('city');  echo '&nbsp،&nbsp'; the_field('address'); ?>
            </p>
        </div>
    </div>
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
</script>
<?php get_footer() ?>





