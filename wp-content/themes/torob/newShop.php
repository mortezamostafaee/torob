<?php
/* Template Name: new shop */
?>
<?php
global $wpdb;
$user_id = do_shortcode('[current_user_id]');
if (isset($_POST["delete-shop"])) {
    wp_delete_post($_POST["delete-shop"]);
}
$allShop = $wpdb->get_results($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_status != 'trash' AND post_type = 'torob' AND post_author = $user_id order by ID desc"));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>پنل ترب</title>
    <link rel="stylesheet" href="<?php echo get_template_directory_uri() . '/css/custom-page.css' ?>">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri() . '/css/bootstrap.css' ?>">
</head>
<body class="new-shop">
<?php if (is_user_logged_in()) : ?>
    <div class="tab">
        <button class="tablinks" onclick="openCity(event, 'shop')" id="defaultOpen">
            <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round"
                 stroke-linejoin="round" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                <circle cx="9" cy="21" r="1"></circle>
                <circle cx="20" cy="21" r="1"></circle>
                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
            </svg>
            <br><span>فروشگاه</span></button>
        <button class="tablinks" onclick="openCity(event, 'merge')">
            <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round"
                 stroke-linejoin="round" height="1em" width="1.5em" xmlns="http://www.w3.org/2000/svg">
                <g transform="translate(-6)">
                    <circle cx="11.5" cy="11.5" r="10"/>
                    <circle cx="24.5" cy="11.5" r="10"/>
                </g>
            </svg>
            <br><span>ادغام</span></button>
        <button class="tablinks" onclick="openCity(event, 'support')">
            <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round"
                 stroke-linejoin="round" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
            </svg>
            <br><span>پشتیبانی</span></button>
        <button class="tablinks" onclick="openCity(event, 'my-account-user')">
            <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round"
                 stroke-linejoin="round" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
            </svg>
            <br><span>حساب من</span></button>
    </div>
    <div id="shop" class="tabcontent">
        <div class="accordion">
            <select name="pets" id="pet-select" disabled>
                <option value=""></option>
                <option value="dog"></option>
            </select>
            <span class="cot-1 d-block">
            <a href="<?php echo get_home_url() . '/shop-dashbord' ?>" class="a-dshbord">پیشخوان</a>
        <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round"
             stroke-linejoin="round" height="17" width="17" xmlns="http://www.w3.org/2000/svg"><rect x="3" y="3"
                                                                                                     width="18"
                                                                                                     height="18" rx="2"
                                                                                                     ry="2"/><path
                    d="M3 9h18M9 21V9"/></svg>
        </span>
            <li class="accordion-item" id="accordion-item-1">
                <a class="accordion-item-header" href="#accordion-item-1">
                    <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round"
                         stroke-linejoin="round" height="17" width="17" xmlns="http://www.w3.org/2000/svg">
                        <path d="m16.5 9.4-9-5.19M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                        <path d="M3.27 6.96 12 12.01l8.73-5.05M12 22.08V12"/>
                    </svg>
                    محصولات و کلیک ها
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" height="17" width="17" class="arr-t">
                        <path d="M31.7 239l136-136c9.4-9.4 24.6-9.4 33.9 0l22.6 22.6c9.4 9.4 9.4 24.6 0 33.9L127.9 256l96.4 96.4c9.4 9.4 9.4 24.6 0 33.9L201.7 409c-9.4 9.4-24.6 9.4-33.9 0l-136-136c-9.5-9.4-9.5-24.6-.1-34z"/>
                    </svg>
                </a>
                <div class="accordion-text">
                    <a href="" class="a-accordion">آمار کلیک ها</a>
                    <a href="" class="a-accordion">لیست محصولات</a>
                    <a href="" class="a-accordion"> مغایرت قیمت و موجودی</a>
                    <a href="" class="a-accordion">محصولات حذف شده</a>
                </div>
            </li>
            <li class="accordion-item" id="accordion-item-2">
                <a class="accordion-item-header" href="#accordion-item-2">
                    <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round"
                         stroke-linejoin="round" height="17" width="17" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 21v-7m0-4V3m8 18v-9m0-4V3m8 18v-5m0-4V3M1 14h6m2-6h6m2 8h6"/>
                    </svg>
                    اطلاعات فروشگاه
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" height="17" width="17" class="arr-t">
                        <path d="M31.7 239l136-136c9.4-9.4 24.6-9.4 33.9 0l22.6 22.6c9.4 9.4 9.4 24.6 0 33.9L127.9 256l96.4 96.4c9.4 9.4 9.4 24.6 0 33.9L201.7 409c-9.4 9.4-24.6 9.4-33.9 0l-136-136c-9.5-9.4-9.5-24.6-.1-34z"/>
                    </svg>
                </a>
                <div class="accordion-text">
                    <a href="" class="a-accordion">شرایط ارسال و تحویل کالا</a>
                    <a href="" class="a-accordion">اطلاعات و پشتیبانی کاربر</a>
                    <a href="" class="a-accordion">امتیاز و پیگیری سفارش</a>
                    <a href="" class="a-accordion">مدارک تکمیلی</a>
                    <a href="" class="a-accordion"> مشخصات فرشگاه</a>
                    <a href="" class="a-accordion"> تنظیمات فرشگاه</a>
                    <a href="<?php echo get_home_url() . '/new-shop/#accordion-item-2' ?>" class="a-accordion" style="background: #4a90e2;
color: #fff;"> ثبت فرشگاه</a>
                    <a href="" class="a-accordion">تاریخچه رویداد ها</a>
                </div>
            </li>
            <li class="accordion-item" id="accordion-item-3">
                <a class="accordion-item-header" href="#accordion-item-3">
                    <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round"
                         stroke-linejoin="round" height="17" width="17" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12" r="2"/>
                        <path d="M16.24 7.76a6 6 0 0 1 0 8.49m-8.48-.01a6 6 0 0 1 0-8.49m11.31-2.82a10 10 0 0 1 0 14.14m-14.14 0a10 10 0 0 1 0-14.14"/>
                    </svg>
                    تبلیغات
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" height="17" width="17" class="arr-t">
                        <path d="M31.7 239l136-136c9.4-9.4 24.6-9.4 33.9 0l22.6 22.6c9.4 9.4 9.4 24.6 0 33.9L127.9 256l96.4 96.4c9.4 9.4 9.4 24.6 0 33.9L201.7 409c-9.4 9.4-24.6 9.4-33.9 0l-136-136c-9.5-9.4-9.5-24.6-.1-34z"/>
                    </svg>
                </a>
                <div class="accordion-text">
                    <a href="<?php echo get_home_url() . '/basic-service' ?>" class="a-accordion">تعرفه خدمات پایه</a>
                    <a href="<?php echo get_home_url() . '/special-click' ?>" class="a-accordion">کلیک ویژه</a>
                    <a href="" class="a-accordion">پیشنهادات ویژه</a>
                    <a href="<?php echo get_home_url().'/special-offer-page-banner/#accordion-item-3'?>" class="a-accordion">بنر صفحه پیشنهادات ویژه</a>
                    <a href="<?php echo get_home_url().'/special-offer-page-rows/#accordion-item-3'?>" class="a-accordion">ردیف‌های صفحه پیشنهاد ویژه</a>
                </div>
            </li>
            <li class="accordion-item" id="accordion-item-4">
                <a class="accordion-item-header" href="#accordion-item-4">
                    <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round"
                         stroke-linejoin="round" height="17" width="17" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 1v22m5-18H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                    </svg>
                    مدیریت مالی
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" height="17" width="17" class="arr-t">
                        <path d="M31.7 239l136-136c9.4-9.4 24.6-9.4 33.9 0l22.6 22.6c9.4 9.4 9.4 24.6 0 33.9L127.9 256l96.4 96.4c9.4 9.4 9.4 24.6 0 33.9L201.7 409c-9.4 9.4-24.6 9.4-33.9 0l-136-136c-9.5-9.4-9.5-24.6-.1-34z"/>
                    </svg>
                </a>
                <div class="accordion-text">
                    <a href="<?php echo get_home_url() . '/invoice/#accordion-item-4' ?>" class="a-accordion">صورت حساب ها</a>
                </div>
            </li>
            <li class="accordion-item" id="accordion-item-5">
                <a class="accordion-item-header" href="#accordion-item-5">
                    <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round"
                         stroke-linejoin="round" height="17" width="17" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12" r="10"/>
                        <circle cx="12" cy="12" r="4"/>
                        <path d="m4.93 4.93 4.24 4.24m5.66 5.66 4.24 4.24m-4.24-9.9 4.24-4.24m-4.24 4.24 3.53-3.53M4.93 19.07l4.24-4.24"/>
                    </svg>
                    راهنما
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" height="17" width="17" class="arr-t">
                        <path d="M31.7 239l136-136c9.4-9.4 24.6-9.4 33.9 0l22.6 22.6c9.4 9.4 9.4 24.6 0 33.9L127.9 256l96.4 96.4c9.4 9.4 9.4 24.6 0 33.9L201.7 409c-9.4 9.4-24.6 9.4-33.9 0l-136-136c-9.5-9.4-9.5-24.6-.1-34z"/>
                    </svg>
                </a>
                <div class="accordion-text">
                    <a href="<?php echo get_home_url() . '/faq/#accordion-item-5' ?>" class="a-accordion">پرسشهای متداول</a>
                    <a href="<?php echo get_home_url() . '/terms/#accordion-item-5' ?>" class="a-accordion">شرایط همکاری</a>
                    <a href="<?php echo get_home_url() . '/changes/#accordion-item-5' ?>" class="a-accordion"> آخرین تغییرات</a>
                    <a href="<?php echo get_home_url() . '/contact-support/#accordion-item-5' ?>" class="a-accordion">تماس با پشتیبانی</a>
                </div>
            </li>
        </div>
    </div>

    <div id="merge" class="tabcontent">
        <h3>ادغام</h3>
        <p>Paris is the capital of France.</p>
    </div>

    <div id="support" class="tabcontent">
        <h3>Tokyo</h3>
        <p>Tokyo is the capital of Japan.</p>
    </div>
    <div id="my-account-user" class="tabcontent">
        <a href="<?php echo get_home_url() . '/info' ?>" class="user-info-shop">اطلاعات کاربری</a>
        <a href="<?php echo wp_logout_url(home_url()); ?>">خروج </a>
    </div>
    <div class="main-dashbord">
    <span class="header_new_shop">
        <p>ثبت فروشگاه</p>
        <a href="" class="help-new-shop">راهنما</a>
    </span>
        <div class="d-flex justify-content-center">
            <div class="new-shop-content">
                <div class="d-flex justify-content-between reg-shop">
                    <h4>درخواست‌های ثبت فروشگاه</h4>
                    <a href="<?php echo get_home_url() . '/register' ?>">ثبت فروشگاه</a>
                </div>
                <hr class="hr-new-shop">
                <table class="w-100">
                    <thead>
                    <tr class="thead-shop">
                        <th>تاریخ و زمان ثبت</th>
                        <th>نام فروشگاه</th>
                        <th>دامنه</th>
                        <th>وضعیت</th>
                        <th>توضیحات</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody class="new-shop-table">
                    <?php foreach ($allShop as $shop) : ?>
                        <tr>
                            <td><?php echo $shop->post_date ?></td>
                            <td><?php echo $shop->post_title ?></td>
                            <td><?php echo get_post_meta($shop->ID, 'shopLink')[0]; ?></td>
                            <td><?php if ($shop->post_status == 'draft') {
                                    echo 'درحال بررسی';
                                } elseif ($shop->post_status == 'pending') {
                                    echo 'تایید نشده';
                                } else {
                                    echo 'تایید شده';
                                }
                                ?></td>
                            <td><?php echo get_post_meta($shop->ID, 'description')[0] ?? ''; ?></td>
                            <td>
                                <form method="post" action="">
                                    <input type="hidden" name="delete-shop" value="<?php echo $shop->ID ?>">
                                    <button class="remove-shop"
                                            onclick="return confirm('آیا از حذف فروشگاه اطمینان دارید؟');">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                            <path d="M268 416h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12zM432 80h-82.41l-34-56.7A48 48 0 0 0 274.41 0H173.59a48 48 0 0 0-41.16 23.3L98.41 80H16A16 16 0 0 0 0 96v16a16 16 0 0 0 16 16h16v336a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128h16a16 16 0 0 0 16-16V96a16 16 0 0 0-16-16zM171.84 50.91A6 6 0 0 1 177 48h94a6 6 0 0 1 5.15 2.91L293.61 80H154.39zM368 464H80V128h288zm-212-48h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12z"/>
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="<?php echo get_template_directory_uri() . '/js/bootstrap.js' ?>"></script>
    <script>
        function openCity(evt, cityName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(cityName).style.display = "block";
            evt.currentTarget.className += " active";
        }

        // Get the element with id="defaultOpen" and click on it
        document.getElementById("defaultOpen").click();
    </script>
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
<script>
    function ConfirmDelete() {
        return confirm("Are you sure you want to delete?");
    }

</script>
</body>
</html>
