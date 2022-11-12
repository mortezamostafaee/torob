<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    wp_head();
    ?>
</head>
<body>
<div class="flex p-l-10 p-r-10 menu-area d-flex justify-content-between">
    <div class="w-100"><?php wp_nav_menu(array('theme_location' => 'main-menu')) ?></div>
    <div class="has-text-align-left p-t-10 position-relative index-user">
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
            <div class="box-reg reg-header">
                <a class="button-reg" href="#popup1">ورود / ثبت نام</a>
            </div>
            <div id="popup1" class="overlay-reg">
                <div class="popup-reg">
                    <p>ورود یا ثبت نام</p>
                    <a class="close-reg" href="#">&times;</a>
                    <div class="content-reg">
                        <iframe src="<?php echo get_home_url() . '/login-register' ?>"
                                style="width: 100% ; height: 266px"></iframe>
                        <!--                                                --><?php //echo do_shortcode("[insert page='login' display='content']"); ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

</div>

<script>
    function myFunction() {
        document.getElementById("myDropdown").classList.toggle("show");
    }

    window.onclick = function (event) {
        if (!event.target.matches('.dropbtn')) {
            var dropdowns = document.getElementsByClassName("dropdown-content");
            var i;
            for (i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }
        }
    }
</script>



