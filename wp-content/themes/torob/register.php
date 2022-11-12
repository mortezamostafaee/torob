<?php
/* Template Name: register */
?>
<?php
global $wpdb;
$user_id = do_shortcode('[current_user_id]');
$shop = $wpdb->get_results($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_status != 'trash' AND post_type = 'torob' AND post_author = $user_id order by ID desc"));
$shop = $shop ? $shop[0] : $shop;

if ($_POST){
    // Create post object
    $user_id = get_current_user_id();
    $shopData = array(
        'post_author' => $user_id,
        'post_content' => '',
        'post_content_filtered' => '',
        'post_title' => sanitize_text_field($_POST['shopName']),
        'post_excerpt' => '',
        'post_status' => 'draft',
        'post_type' => 'torob',
        'comment_status' => '',
        'ping_status' => '',
        'post_password' => '',
        'to_ping' => '',
        'pinged' => '',
        'post_parent' => 0,
        'menu_order' => 0,
        'guid' => '',
        'import_id' => 0,
        'context' => '',
        'post_date' => '',
        'post_date_gmt' => '',
    );
    // Insert the post into the database
    $shopId = wp_insert_post($shopData);
    foreach ($_POST as $key => $value) {
        if (!empty($value)) {
            update_post_meta($shopId, $key, $value);
        }
    }
}

?>
<link rel="stylesheet" href="<?php echo get_template_directory_uri() . '/css/custom-page.css' ?>">
<link rel="stylesheet" href="<?php echo get_template_directory_uri() . '/css/bootstrap.css' ?>">
<body class="body-register">
<?php if (is_user_logged_in()): ?>
    <div class="container main-register mt-3">
        <div class="row">
            <div class="aside-register col-md-6">
                <div class="textright" dir="rtl" style="padding-top: 42px;">
                    <h3 style="color: #000;">فرآیند اضافه شدن سایت شما به ترب</h3>
                    <p>
                        1. شما باید فروشگاه اینترنتی دارای نماد اعتماد الکترونیک داشته باشید. <br>

                        2. در فرم ثبت نام اطلاعات فروشگاه خود را ثبت می‌کنید. در این مرحله لازم هست شرایط همکاری را
                        بپذیرید.<br>

                        3. حداکثر بعداز ۴۸ ساعت فروشگاه شما توسط کارشناسان بررسی خواهد شد و در صورت تایید از طریق پیامک
                        به
                        شما اطلاع داده خواهد شد.<br>

                        4. بعداز تایید فروشگاه میتوانید حساب فروشگاه خود را به میزان دلخواه در ترب شارژ نمایید.<br>

                        5. بعداز شارژ حساب محصولات شما توسط ربات‌های ترب دریافت می‌شود. این فرایند بسته به سایت و تعداد
                        محصولات شما میتواند تا یک هفته زمان ببرد.<br>

                        6. محصولات توسط تیم محتوای ترب برای دسته‌بندی و ادغام بررسی و تایید می‌شوند. این فرایند بسته به
                        تعداد محصولات شما می‌تواند تا یک هفته زمان ببرد.<br>

                        7. بعداز تایید محصولات شما در نتایج ترب نمایش داده خواهد شد و به ازای هر کلیکی که کاربر را از
                        ترب به
                        سایت شما هدایت می‌کند، مبلغی از شارژ شما، براساس تعرفه خدمات، کسر خواهد شد.<br>
                    </p>
                </div>
            </div>
            <div class="main-register col-md-6">
            <span class="d-flex justify-content-end">
            <a href="<?php echo get_home_url() . '/new-shop' ?>" class="mb-0 return">بازگشت</a>
            <img src="<?php echo get_template_directory_uri() . '/images/close.svg' ?>">
        </span>
                <div class="side-1">
                    <form method="post" action="">
                        <h3>اطلاعات فردی</h3>
                        <label for="phone">شماره موبایل</label><br>
                        <input type="text" name="phone" value="<?php echo get_post_meta($shop->ID, 'phone')[0]?>" required><br>
                        <label for="name-1" class="d-flex justify-content-end">
                            <div class="vertical-wrapper">
                                <div class="vertical-center">
                            <span class=" tooltip-left"
                                  data-tooltip="  این نام برای  ارتباط کارشناسان ترب با شما استفاده میشود و به کاربران ترب نمایش داده نخواهد شد"><img
                                        src="<?php echo get_template_directory_uri() . '/images/info.svg' ?>"></span>
                                </div>
                            </div>
                            نام خانوادگی رابط فروشگاه</label>
                        <input type="text" name="name_1" dir="auto" value="<?php echo get_post_meta($shop->ID, 'name_1')[0]?>" required><br>
                        <h3>اطلاعات فروشگاه</h3>
                        <label for="shop" class="d-flex justify-content-end">
                            <div class="vertical-wrapper">
                                <div class="vertical-center">
                            <span class=" tooltip-left"
                                  data-tooltip="درحال حاضر امکان خدمات به فروشگاه هایی که سایت ندارند را نداریم"><img
                                        src="<?php echo get_template_directory_uri() . '/images/info.svg' ?>"></span>
                                </div>
                            </div>
                            آیا سایت برای فروش اینترنتی دارید؟
                        </label>
                        <div class="d-flex align-items-center mt-3">

                            <div class="wrapper-shop">
                                <input type="radio" name="shop" id="shop-1" value="خیر" required>
                                <input type="radio" name="shop" id="shop-2" value="بله">
                                <label for="shop-1" class="option shop-1">
                                    <span>خیر</span>
                                </label>
                                <label for="shop-2" class="option shop-2">
                                    <span>بله</span>
                                </label>
                            </div>

                        </div>
                        <br>
                        <label class="mb-3">سایت شما نماد اعتماد الکترونیک دارد؟</label>
                        <div class="d-flex align-items-center">
                            <div class="wrapper-shop">
                                <input type="radio" name="enamad" id="enamad-1" value="خیر" required>
                                <input type="radio" name="enamad" id="enamad-2" value="بله">
                                <label for="enamad-1" class="option enamad-1">
                                    <span>خیر</span>
                                </label>
                                <label for="enamad-2" class="option enamad-2">
                                    <span>بله</span>
                                </label>
                            </div>
                        </div>
                        <br>
                        <label for="shopName"> نام فروشگاه</label><br>
                        <input type="text" name="shopName" dir="auto" value="" required><br>
                        <label for="shopLink"> wwwآدرس سایت فروشگاه بدون </label><br>
                        <input type="text" name="shopLink" dir="auto" value="" required><br>
                        <label for="numberProduct">تعداد تخمینی محصولات </label><br>
                        <input type="text" name="numberProduct" dir="auto" value="" required><br>
                        <input type="submit" class="shop-save" value="ثبت فروشگاه">
                    </form>
                    <div class="info-reg">
                        در صورتی که برای ایجاد فروشگاه جدید مشکل دارید با ما تماس بگیرید:<br>تلگرام: <span dir="ltr">@torob_sales</span>
                        <br>ایمیل: shops@torob.ir <br>تلفن: 02191008676 <br>ساعات پاسخ‌گویی شنبه تا چهارشنبه ۹ صبح تا ۵
                        بعدازظهر و پنج‌شنبه‌ها از ساعت ۹ صبح تا ۲ بعدازظهر <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="row" style="position: fixed;width: 100%;min-height: 100vh;">
        <div class="container d-flex justify-content-center" style="background-color: #fff;">

            <img src="<?php echo get_template_directory_uri() . '/images/user-premision.jpg' ?>">

        </div>
        <div class="container" style="background-color: #fff;">
            <p class="access-user">شما اجازه دسترسی به این صفحه را ندارید</p>
            <p class="access-user">برای مشاهده این صفحه وارد سایت شوید </p>
            <iframe src="<?php echo get_home_url() . '/login-register' ?>"
                    style="width: 100% ; height: 266px"></iframe>
        </div>
    </div>
<?php endif; ?>

</body>
<script src="<?php echo get_template_directory_uri() . '/js/bootstrap.js' ?>"></script>
