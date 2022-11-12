<?php
/* Template Name: feedback */
?>
<?php
global $wpdb;
$user_id = do_shortcode('[current_user_id]');
$shop = $wpdb->get_results($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_status != 'trash' AND post_type = 'torob' order by ID desc"));
var_dump($shop);
if (isset($_POST['feedback-shop'])){
    global $wpdb;
    $torob_feedback = $wpdb->prefix . 'torob_feedback';
    $document_uoload = UploadDocument();
    $wpdb->insert($torob_feedback, array(
        'user_id_feedback' => $_POST['user_id_feedback'],
        'shop' => $_POST['shop'],
        'complaint_form' => $_POST['complaint_form'],
        'price' => $_POST['price'],
        'noanswers' => $_POST['noanswers'],
        'ordercode' => $_POST['orderCode'],
        'date' => $_POST['date'],
        'buyer_name' => $_POST['buyer_name'],
        'order_tracking' => $_POST['order_tracking'],
        'link' => $document_uoload,
    ), array('%d', '%s', '%s', '%s', '%s', '%d', '%s', '%s', '%s', '%s')
    );
    var_dump($_POST);
}
function UploadDocument()
{
    $wordpress_upload_dir = wp_upload_dir();

    $i = 1; // number of tries when the file with the same name is already exists

    $profilepicture = $_FILES['fileInput'];
    $new_file_path = $wordpress_upload_dir['path'] . '/' . $profilepicture['name'];
    $new_file_mime = mime_content_type($profilepicture['tmp_name']);

    if (empty($profilepicture))
        die('File is not selected.');

    if ($profilepicture['error'])
        die($profilepicture['error']);

    if ($profilepicture['size'] > wp_max_upload_size())
        die('It is too large than expected.');

    if (!in_array($new_file_mime, get_allowed_mime_types()))
        die('WordPress doesn\'t allow this type of uploads.');

    while (file_exists($new_file_path)) {
        $i++;
        $new_file_path = $wordpress_upload_dir['path'] . '/' . $i . '_' . $profilepicture['name'];
    }
    if (move_uploaded_file($profilepicture['tmp_name'], $new_file_path)) {
        $upload_id = wp_insert_attachment(array(
            'guid' => $new_file_path,
            'post_mime_type' => $new_file_mime,
            'post_title' => preg_replace('/\.[^.]+$/', '', $profilepicture['name']),
            'post_content' => '',
            'post_status' => 'inherit'
        ), $new_file_path);

        // wp_generate_attachment_metadata() won't work if you do not include this file
        require_once(ABSPATH . 'wp-admin/includes/image.php');

        // Generate and save the attachment metas into the database
        wp_update_attachment_metadata($upload_id, wp_generate_attachment_metadata($upload_id, $new_file_path));

        return $wordpress_upload_dir['url'] . '/' . basename($new_file_path);
    }
}
?>
<style>
    .custom-search-shop .select2 {
        width: 50% !important;
        margin-bottom: 3%;
    }
</style>
    <link href="<?php echo get_template_directory_uri() . '/css/select2.min.css' ?>" rel="stylesheet" />

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
    <div class="d-flex">
        <?php if (is_user_logged_in()) : ?>
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
            <a href="#">
                <a href="<?php echo get_home_url() . '/shop-list' ?>"><h6>لیست فروشگاه های ترب</h6></a>
            </a>
            <a href="<?php echo get_home_url().'/shop-dashbord' ?>" target="_blank">
                <h6>ثبت نام فروشگاه</h6>
            </a>
            <hr>

            <button class="accordion"> پیگیری سفارش<i class="fas fa-angle-down"></i></button>
            <div class="panel">
                <a href="<?php echo get_home_url().'/feedback'?>" ><p class="user-side-a">ثبت و مشاهده پیامها</p></a>
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
            <a href="<?php echo wp_logout_url( home_url() ); ?>">خروج از حساب</a>
        </aside>
        <main class="main-page">
            <div class="serch-shop">

                <div id="multi-step-form-container">
                    <!-- Form Steps / Progress Bar -->

                    <!-- Step Wise Form Content -->
                    <form id="userAccountSetupForm" name="userAccountSetupForm" enctype="multipart/form-data" autocomplete="off" method="post">
                        <input id="feedback_admin_url" type="hidden" value="<?php echo admin_url('admin-ajax.php') ?>"/>
                        <input type="hidden" name="user_id_feedback" value="<?php echo $user_id ?>">
                        <!-- Step 1 Content -->
                        <section id="step-1" class="form-step">
                            <h4 class="font-normal text-center">ثبت پیگیری سفارش از فروشگاه </h4>
                            <!-- Step 1 input fields -->
                            <div class="mt-3">
                                <p>با تکمیل فرم پیگیری سفارش، درخواست شما جهت پیگیری و پاسخ برای فروشگاهی که از آن خرید
                                    کرده اید ارسال می شود. از آنجا که فرایند خرید توسط هر فروشگاه بررسی می شود، خواهشمند
                                    است اطلاعات کافی را جهت پیگیری ارائه فرمایید. وضعیت و پاسخ پیگیری سفارش شما در بخش
                                    پیگیری سفارش در "ترب من" قابل مشاهده و ثبت پیام مجدد می باشد. لازم به ذکر است که
                                    پیگیری سفارش های تکراری و غیر مرتبط تایید نمی شوند.</p>
                            </div>
                            <div class="mt-3" style="text-align: center;">
                                <button class="button btn-navigate-form-step step1" type="button" step_number="2">ثبت
                                    پیگیری سفارش جدید
                                </button>
                            </div>
                        </section>
                        <!-- Step 2 Content, default hidden on page load. -->
                        <section id="step-2" class="form-step d-none">
                            <h6 class="font-normal text-center">لطفا نام فروشگاه را وارد کنید</h6>
                            <!-- Step 2 input fields -->
                            <div class="mt-3 custom-search-shop">
                                <select class="js-example-basic-single w-100" id="select-shop"  name="shop" onchange="selectShop()">
                                    <option value="">انتخاب کنید</option>
                                    <?php foreach ($shop as $item): ?>
                                    <option value="<?php echo $item->ID ?>"><?php echo $item->post_title ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <?php foreach ($shop as $shop_content): ?>
                                <?php $image = get_attached_media('image' , $shop_content->ID) ;?>
                                <div class="d-flex result-search-stor justify-content-between result-1">
                                    <img src="<?php echo reset($image)->guid ?? get_template_directory_uri().'/images/store-logo-placeholder.png'; ?>">
                                    <p><?php echo $shop_content->post_title ?></p>
                                    <p class="site-shop"><?php echo get_post_meta($shop_content->ID, 'shopLink')[0]; ?></p>
                                    <hr>
                                </div>
                                <?php endforeach; ?>
                            </div>
                            <div class="mt-3 text-center">
                                <button class="button btn-navigate-form-step step1" id="getshopData" type="button" step_number="3"> ادامه
                                    ثبت بازخورد یا پیگیری سفارش
                                </button>
                            </div>
                        </section>
                        <!-- Step 3 Content, default hidden on page load. -->
                        <section id="step-3" class="form-step d-none">
                            <div class="d-flex align-items-baseline justify-content-around">
                                <button class="button btn-navigate-form-step prev" type="button" step_number="2">مرحله
                                    قبل
                                </button>
                                <p class="shop-title"> نام فروشگاه | <span class="select-shop"></span></p>
                            </div>


                            <!-- Step 3 input fields -->
                            <div class="mt-3 text-center">
                                <hr>
                                فروشگاه «<span class="select-shop"></span>» در حال حاضر در ترب
                               <span id="shopStatus"></span>

                            </div>
                            <div class="mt-3 text-center">
                                <button class="button btn-navigate-form-step step1" type="button" step_number="4">ادامه
                                    ثبت بازخورد یا پیگیری سفارش
                                </button>

                            </div>
                        </section>
                        <!-- Step 4 Content, default hidden on page load. -->
                        <section id="step-4" class="form-step d-none">
                            <ul class="ul-step">
                                <li> با انتخاب دقیق عنوان پیگیری سفارش سرعت پاسخ به آن افزایش می یابد.</li>
                            </ul>
                            <div class="d-flex align-items-baseline justify-content-around">
                                <button class="button btn-navigate-form-step prev" type="button" step_number="3">مرحله
                                    قبل
                                </button>
                                <p class="shop-title"> نام فروشگاه | <span class="select-shop"></span></p>
                            </div>
                            <hr>
                            <!-- Step 3 input fields -->
                            <div class="mt-3">
                                <p> لطفا یکی از موارد زیر را انتخاب کنید:</p>
                            </div>
                            <input type="radio" id="input1" name="complaint_form" value="هنوز کالا به دستم نرسیده">
                            <label for="input1" class="lable1">
                                <i class="fas fa-check radio-icon"></i>هنوز کالا به دستم نرسیده.</label>
                            <label for="input1" class="label2">- از موعد مورد انتظار گذشته، اما هنوز کالا را دریافت
                                نکرده ام.</label><br>
                            <input type="radio" id="input2" name="complaint_form" value="نمی‌توانم سفارشم را پیگیری کنم.">
                            <label for="input2" class="lable1"> <i class="fas fa-check radio-icon"></i>نمی‌توانم سفارشم
                                را پیگیری کنم.</label>
                            <label for="input2" class="label2">- به دلیل عدم پاسخگویی فروشگاه یا عدم ارسال کد رهگیری،
                                امکان بررسی وضعیت ارسال سفارشم را ندارم.</label><br>
                            <input type="radio" id="input3" name="complaint_form" value="
فروشگاه بعد از ثبت سفارش اعلام کرده کالا موجود نیست.">
                            <label for="input3" class="lable1"> <i class="fas fa-check radio-icon"></i>فروشگاه بعد از
                                ثبت سفارش اعلام کرده کالا موجود
                                نیست.</label>
                            <label for="input3" class="label2">- بعد از ثبت سفارش آنلاین، فروشگاه به صورت تلفنی یا
                                آنلاین، ناموجود شدن کالا را اعلام کرده است.</label><br>
                            <input type="radio" id="input4" name="complaint_form" value="
در مورد هزینه ارسال مشکل دارم.">
                            <label for="input4" class="lable1"> <i class="fas fa-check radio-icon"></i>در مورد هزینه
                                ارسال مشکل دارم.</label>
                            <label for="input4" class="label2">- هزینه ی ارسال با موارد توافق شده یا ذکر شده در وبسایت
                                فروشگاه مطابقت ندارد.</label><br>
                            <input type="radio" id="input5" name="complaint_form" value="
کالایی که به دستم رسیده با سفارشم فرق دارد.">
                            <label for="input5" class="lable1"> <i class="fas fa-check radio-icon"></i>کالایی که به دستم
                                رسیده با سفارشم فرق دارد.</label>
                            <label for="input5" class="label2">- مشخصات کالای ارسالی با مندرجات وبسایت فروشنده منطبق
                                نبوده و یا کالا تقلبی است.</label><br>
                            <input type="radio" id="input6" name="complaint_form" value=" فروشگاه هنوز پولم را پس نداده. ">
                            <label for="input6" class="lable1"><i class="fas fa-check radio-icon"></i> فروشگاه هنوز پولم
                                را پس نداده. </label>
                            <label for="input6" class="label2">- تقاضای بازگشت وجه داشتم که فروشگاه تاکنون انجام نداده
                                است.</label><br>
                            <input type="radio" id="input7" name="complaint_form" value="کالایی که به دستم رسیده معیوب است.">
                            <label for="input7" class="lable1"><i class="fas fa-check radio-icon"></i>کالایی که به دستم
                                رسیده معیوب است.</label>
                            <label for="input7" class="label2">- کالای ارسالی ناقص یا مستعمل بوده و یا از لحاظ کارکرد
                                مشکل دارد.</label><br>
                            <input type="radio" id="input8" name="complaint_form" value="فروشگاه بعد از ثبت سفارش، قیمت کالا را تغییر داده است.">
                            <label for="input8" class="lable1"><i class="fas fa-check radio-icon"></i>فروشگاه بعد از ثبت
                                سفارش، قیمت کالا را تغییر داده
                                است.</label>
                            <label for="input8" class="label2">- بعد از ثبت سفارش آنلاین، فروشگاه به صورت تلفنی یا
                                آنلاین، تقاضای وجه بیشتری نموده است.</label><br>
                            <input type="radio" id="input9" name="complaint_form" value="در مورد رجیستری گوشی با مشکل مواجه هستم.">
                            <label for="input9" class="lable1"><i class="fas fa-check radio-icon"></i>در مورد رجیستری
                                گوشی با مشکل مواجه هستم.</label>
                            <label for="input9" class="label2">- هر گونه مشکلی با رجیستری گوشی دارم اعم از رجیستر شده
                                بودن یا عدم کارکرد رجیستری.</label><br>
                            <input type="radio" id="input10" name="complaint_form" value="مشکلم در لیست بالا یافت نشد.">
                            <label for="input10" class="lable1"><i class="fas fa-check radio-icon"></i>مشکلم در لیست
                                بالا یافت نشد.</label>
                            <label for="input10" class="label2">هرگونه مشکل یا بازخوردی در خصوص فروشگاه مذکور که در لیست
                                فوق دسته بندی نشده</label><br>
                            <div class="mt-3">
                                <button class="button btn-navigate-form-step next1" type="button" step_number="5">مرحله
                                    بعد
                                </button>
                            </div>
                        </section>
                        <!-- Step 5 Content, default hidden on page load. -->
                        <section id="step-5" class="form-step d-none">
                            <div class="d-flex justify-content-around align-items-baseline">
                                <button class="button btn-navigate-form-step prev" type="button" step_number="4">مرحله
                                    قبل
                                </button>
                                <p class="shop-title"> نام فروشگاه | <span class="select-shop"></span></p>
                            </div>


                            <!-- Step 5 input fields -->
                            <div class="mt-3">
                                <hr>
                                آیا مبلغی به فروشگاه پرداخت کرده‌اید؟
                            </div>
                            <input type="radio" id="input11" name="price" value="بله">
                            <label for="price">بله</label><br>
                            <input type="radio" id="input12" name="price" value="خیر">
                            <label for="price">خیر</label>

                            <div class="mt-3">
                                <button class="button btn-navigate-form-step step1" type="button" step_number="6">
                                    مرحله بعد
                                </button>
                            </div>
                        </section>
                        <!-- Step 6 Content, default hidden on page load. -->
                        <section id="step-6" class="form-step d-none">
                            <div class="d-flex justify-content-around align-items-baseline">
                                <button class="button btn-navigate-form-step prev" type="button" step_number="5">مرحله
                                    قبل
                                </button>
                                <p class="shop-title"> نام فروشگاه | <span class="select-shop"></span></p>
                            </div>


                            <!-- Step 6 input fields -->
                            <div class="mt-3">
                                <hr>
                                سریعترین راه برای حل مشکل تماس با فروشنده است
                            </div>
                            روش‌های تماس با پشتیبانی فروشگاه <span class="select-shop"></span>
                            <div class="mt-3">
                                <h3>زمان پاسخگویی</h3>
                                <p class="w-75" style="color: #888;font-size: 14px;"
                                   style="color: #888;font-size: 14px;">برای تماس های تلفنی، شنبه تا چهارشنبه از ساعت 10
                                    الی 18 همچنین پنج شنبه ها از ساعت 10
                                    الی 14 برای پشتیبانی در واتس اپ، شنبه تا پنج شنبه از ساعت 10 الی</p>
                                <p class="w-75">
                                    جهت پیگیری سفارشات فقط با پشتیبانی در واتس اپ در ارتباط باشید.
                                </p>
                                <input type="text" name="email-shop" dir="auto" value="info@technostyle.ir" disabled>
                                <a class="mail-shop-1" href="mailto:info@technostyle.ir">ایمیل</a><br>
                                <p class="w-75" style="color: #888;font-size: 14px;"
                                   style="color: #888;font-size: 14px;">لطفا پیگیری سفارش را زمانی ثبت کنید که پیگیری
                                    شما از فروشگاه بدون نتیجه بوده است.</p>
                                <input type="radio" id="input13" name="noanswers" value="تلفن یا ایمیل را کسی پاسخ نمی‌دهد">
                                <label for="price">تلفن یا ایمیل را کسی پاسخ نمی‌دهد</label><br>
                                <input type="radio" id="input14" name="noanswers" value="از فروشگاه پیگیری کرده‌ام اما مشکلم حل نشده">
                                <label for="price">از فروشگاه پیگیری کرده‌ام اما مشکلم حل نشده</label><br><br>
                                <button class="button btn-navigate-form-step step1" type="button" step_number="7">
                                    مرحله بعد
                                </button>

                            </div>
                        </section>
                        <!-- Step 7 Content, default hidden on page load. -->
                        <section id="step-7" class="form-step d-none">
                            <div class="d-flex justify-content-around align-items-baseline">
                                <button class="button btn-navigate-form-step prev" type="button" step_number="6">مرحله
                                    قبل
                                </button>
                                <p class="shop-title"> نام فروشگاه | <span class="select-shop"></span></p>
                            </div>


                            <!-- Step 7 input fields -->
                            <div class="mt-3">
                                <hr>
                                پیگیری سفارش‌هایی که «شماره سفارش» یا «کد پیگیری» داشته باشند سریع‌تر قابل پیگیری هستند.
                                در صورتی که کد سفارش دارید آن را وارد کنید.
                            </div>
                            <label for="orderCode"> کد ثبت سفارش</label><br>
                            <input type="text" id="input15" name="orderCode" value="" class="order-torob-1"><br>
                            <label for="orderCode">تاریخ ثبت سفارش</label><br>
                            <input type="date" id="input16" class="order-torob-1" name="date" value="">

                            <div class="mt-3">
                                <button class="button btn-navigate-form-step step1" type="button" step_number="8">
                                    مرحله بعد
                                </button>
                            </div>
                        </section>
                        <!-- Step 8 Content, default hidden on page load. -->
                        <section id="step-8" class="form-step d-none">
                            <div class="d-flex justify-content-around align-items-baseline">
                                <button class="button btn-navigate-form-step prev" type="button" step_number="7">مرحله
                                    قبل
                                </button>
                                <p class="shop-title"> نام فروشگاه | <span class="select-shop"></span></p>
                            </div>


                            <!-- Step 7 input fields -->
                            <div class="mt-3">
                                <hr>
                            </div>
                            <label for="orderCode"> نام و نام خانوادگی خریدار کالا</label><br>
                            <input type="text" id="input17" name="buyer_name" placeholder="نام و نام خانوادگی" value=""
                                   class="order-torob-1"><br>
                            <label for="orderCode">متن پیگیری سفارش</label><br>
                            <textarea type="date" id="text-area-1" rows="5" class="order-torob-1" name="order_tracking"
                                      placeholder="لطفا توضیحات خود را کامل و دقیق ثبت کنید" value=""></textarea>
                            <p> پیوست تصویر</p>
                            تصویر یا اسکرین‌شات مستندات (رسید خرید، کالا، ایمیل یا پیامک فروشگاه و ...) خود را در این
                            قسمت پیوست نمایید.
                            <!-- Upload Area -->
                            <div id="uploadArea" class="upload-area">
                                <!-- Header -->
                                <div class="upload-area__header">

                                    <p class="upload-area__paragraph">

                                        <strong class="upload-area__tooltip">

                                            <span class="upload-area__tooltip-data"></span>
                                            <!-- Data Will be Comes From Js -->
                                        </strong>
                                    </p>
                                </div>
                                <!-- End Header -->

                                <!-- Drop Zoon -->
                                <div id="dropZoon" class="upload-area__drop-zoon drop-zoon">
    <span class="drop-zoon__icon">
      <i class='bx bxs-file-image'></i>
    </span>
                                    <p class="drop-zoon__paragraph">فایل خود را اینجا رها کنید یا برای مرور کلیک
                                        کنید</p>
                                    <span id="loadingText" class="drop-zoon__loading-text">Please Wait</span>
                                    <img src="" alt="Preview Image" id="previewImage" class="drop-zoon__preview-image"
                                         draggable="false">
                                    <input type="file" id="fileInput" class="drop-zoon__file-input" name="fileInput" accept="image/*">
                                </div>
                                <!-- End Drop Zoon -->

                                <!-- File Details -->
                                <div id="fileDetails" class="upload-area__file-details file-details">
                                    <h3 class="file-details__title">Uploaded File</h3>

                                    <div id="uploadedFile" class="uploaded-file">
                                        <div class="uploaded-file__icon-container">
                                            <i class='bx bxs-file-blank uploaded-file__icon'></i>
                                            <span class="uploaded-file__icon-text"></span>
                                            <!-- Data Will be Comes From Js -->
                                        </div>

                                        <div id="uploadedFileInfo" class="uploaded-file__info">
                                            <span class="uploaded-file__name">Proejct 1</span>
                                            <span class="uploaded-file__counter">0%</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- End File Details -->
                            </div>
                            <!-- End Upload Area -->
                            <div class="mt-3">
                                <input type="submit" class="button submit-btn step1" value="ثبت" name="feedback-shop">
                            </div>
                        </section>
                    </form>
                </div>
            </div>
        </main>
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
    </div>
    <footer class="custom-footer">
        <div class="row">
            <div class="col-md-3"><div class="menu-footer"><?php wp_nav_menu(array('theme_location' => 'footer-user-panel-1')) ?></div></div>
            <div class="col-md-3"><div class="menu-footer"><?php wp_nav_menu(array('theme_location' => 'footer-user-panel-2')) ?></div></div>
            <div class="col-md-6 d-flex justify-content-end namad-torob">
                <img src="<?php echo get_template_directory_uri().'/images/etehadiye.png' ?>">
                <img src="<?php echo get_template_directory_uri().'/images/e-namad.png' ?>">
                <img src="<?php echo get_template_directory_uri().'/images/rasane.png' ?>">
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-3 d-flex align-items-center"> <span>ترب، موتور جستجوی هوشمند خرید</span></div>
            <div class="col-md-3 social-torob d-flex align-items-center"><a href="#"><i class="fab fa-instagram"></i></a><a href="#"><i class="fab fa-twitter"></i></a><a href="#"> <i class="fab fa-linkedin-in"></i></a>  </div>
            <div class="col-md-6 d-flex justify-content-end namad-torob market-torob">
                <img src="<?php echo get_template_directory_uri().'/images/myket.png' ?>">
                <img src="<?php echo get_template_directory_uri().'/images/bazaar-badge.png' ?>">
                <img src="<?php echo get_template_directory_uri().'/images/google-play-btn.png' ?>">
            </div>

        </div>
        <script src="<?php echo get_template_directory_uri().'/js/select2.min.js' ?>"></script>
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
    <script>
        /**
         * Define a function to navigate betweens form steps.
         * It accepts one parameter. That is - step number.
         */
        const navigateToFormStep = (stepNumber) => {
            /**
             * Hide all form steps.
             */
            document.querySelectorAll(".form-step").forEach((formStepElement) => {
                formStepElement.classList.add("d-none");
            });
            /**
             * Mark all form steps as unfinished.
             */
            document.querySelectorAll(".form-stepper-list").forEach((formStepHeader) => {
                formStepHeader.classList.add("form-stepper-unfinished");
                formStepHeader.classList.remove("form-stepper-active", "form-stepper-completed");
            });
            /**
             * Show the current form step (as passed to the function).
             */
            document.querySelector("#step-" + stepNumber).classList.remove("d-none");
            /**
             * Select the form step circle (progress bar).
             */
            const formStepCircle = document.querySelector('li[step="' + stepNumber + '"]');
            /**
             * Mark the current form step as active.
             */
            formStepCircle.classList.remove("form-stepper-unfinished", "form-stepper-completed");
            formStepCircle.classList.add("form-stepper-active");
            /**
             * Loop through each form step circles.
             * This loop will continue up to the current step number.
             * Example: If the current step is 3,
             * then the loop will perform operations for step 1 and 2.
             */
            for (let index = 0; index < stepNumber; index++) {
                /**
                 * Select the form step circle (progress bar).
                 */
                const formStepCircle = document.querySelector('li[step="' + index + '"]');
                /**
                 * Check if the element exist. If yes, then proceed.
                 */
                if (formStepCircle) {
                    /**
                     * Mark the form step as completed.
                     */
                    formStepCircle.classList.remove("form-stepper-unfinished", "form-stepper-active");
                    formStepCircle.classList.add("form-stepper-completed");
                }
            }
        };
        /**
         * Select all form navigation buttons, and loop through them.
         */
        document.querySelectorAll(".btn-navigate-form-step").forEach((formNavigationBtn) => {
            /**
             * Add a click event listener to the button.
             */
            formNavigationBtn.addEventListener("click", () => {
                /**
                 * Get the value of the step.
                 */
                const stepNumber = parseInt(formNavigationBtn.getAttribute("step_number"));
                /**
                 * Call the function to navigate to the target form step.
                 */
                navigateToFormStep(stepNumber);
            });
        });
    </script>
    <script>
        // Design By
        // - https://dribbble.com/shots/13992184-File-Uploader-Drag-Drop

        // Select Upload-Area
        const uploadArea = document.querySelector('#uploadArea')

        // Select Drop-Zoon Area
        const dropZoon = document.querySelector('#dropZoon');

        // Loading Text
        const loadingText = document.querySelector('#loadingText');

        // Slect File Input
        const fileInput = document.querySelector('#fileInput');

        // Select Preview Image
        const previewImage = document.querySelector('#previewImage');

        // File-Details Area
        const fileDetails = document.querySelector('#fileDetails');

        // Uploaded File
        const uploadedFile = document.querySelector('#uploadedFile');

        // Uploaded File Info
        const uploadedFileInfo = document.querySelector('#uploadedFileInfo');

        // Uploaded File  Name
        const uploadedFileName = document.querySelector('.uploaded-file__name');

        // Uploaded File Icon
        const uploadedFileIconText = document.querySelector('.uploaded-file__icon-text');

        // Uploaded File Counter
        const uploadedFileCounter = document.querySelector('.uploaded-file__counter');

        // ToolTip Data
        const toolTipData = document.querySelector('.upload-area__tooltip-data');

        // Images Types
        const imagesTypes = [
            "jpeg",
            "png",
            "svg",
            "gif"
        ];

        // Append Images Types Array Inisde Tooltip Data
        toolTipData.innerHTML = [...imagesTypes].join(', .');

        // When (drop-zoon) has (dragover) Event
        dropZoon.addEventListener('dragover', function (event) {
            // Prevent Default Behavior
            event.preventDefault();

            // Add Class (drop-zoon--over) On (drop-zoon)
            dropZoon.classList.add('drop-zoon--over');
        });

        // When (drop-zoon) has (dragleave) Event
        dropZoon.addEventListener('dragleave', function (event) {
            // Remove Class (drop-zoon--over) from (drop-zoon)
            dropZoon.classList.remove('drop-zoon--over');
        });

        // When (drop-zoon) has (drop) Event
        dropZoon.addEventListener('drop', function (event) {
            // Prevent Default Behavior
            event.preventDefault();

            // Remove Class (drop-zoon--over) from (drop-zoon)
            dropZoon.classList.remove('drop-zoon--over');

            // Select The Dropped File
            const file = event.dataTransfer.files[0];

            // Call Function uploadFile(), And Send To Her The Dropped File :)
            uploadFile(file);
        });

        // When (drop-zoon) has (click) Event
        dropZoon.addEventListener('click', function (event) {
            // Click The (fileInput)
            fileInput.click();
        });

        // When (fileInput) has (change) Event
        fileInput.addEventListener('change', function (event) {
            // Select The Chosen File
            const file = event.target.files[0];

            // Call Function uploadFile(), And Send To Her The Chosen File :)
            uploadFile(file);
        });

        // Upload File Function
        function uploadFile(file) {
            // FileReader()
            const fileReader = new FileReader();
            // File Type
            const fileType = file.type;
            // File Size
            const fileSize = file.size;

            // If File Is Passed from the (File Validation) Function
            if (fileValidate(fileType, fileSize)) {
                // Add Class (drop-zoon--Uploaded) on (drop-zoon)
                dropZoon.classList.add('drop-zoon--Uploaded');

                // Show Loading-text
                loadingText.style.display = "block";
                // Hide Preview Image
                previewImage.style.display = 'none';

                // Remove Class (uploaded-file--open) From (uploadedFile)
                uploadedFile.classList.remove('uploaded-file--open');
                // Remove Class (uploaded-file__info--active) from (uploadedFileInfo)
                uploadedFileInfo.classList.remove('uploaded-file__info--active');

                // After File Reader Loaded
                fileReader.addEventListener('load', function () {
                    // After Half Second
                    setTimeout(function () {
                        // Add Class (upload-area--open) On (uploadArea)
                        uploadArea.classList.add('upload-area--open');

                        // Hide Loading-text (please-wait) Element
                        loadingText.style.display = "none";
                        // Show Preview Image
                        previewImage.style.display = 'block';

                        // Add Class (file-details--open) On (fileDetails)
                        fileDetails.classList.add('file-details--open');
                        // Add Class (uploaded-file--open) On (uploadedFile)
                        uploadedFile.classList.add('uploaded-file--open');
                        // Add Class (uploaded-file__info--active) On (uploadedFileInfo)
                        uploadedFileInfo.classList.add('uploaded-file__info--active');
                    }, 500); // 0.5s

                    // Add The (fileReader) Result Inside (previewImage) Source
                    previewImage.setAttribute('src', fileReader.result);

                    // Add File Name Inside Uploaded File Name
                    uploadedFileName.innerHTML = file.name;

                    // Call Function progressMove();
                    progressMove();
                });

                // Read (file) As Data Url
                fileReader.readAsDataURL(file);
            } else { // Else

                this; // (this) Represent The fileValidate(fileType, fileSize) Function

            }
            ;
        };

        // Progress Counter Increase Function
        function progressMove() {
            // Counter Start
            let counter = 0;

            // After 600ms
            setTimeout(() => {
                // Every 100ms
                let counterIncrease = setInterval(() => {
                    // If (counter) is equle 100
                    if (counter === 100) {
                        // Stop (Counter Increase)
                        clearInterval(counterIncrease);
                    } else { // Else
                        // plus 10 on counter
                        counter = counter + 10;
                        // add (counter) vlaue inisde (uploadedFileCounter)
                        uploadedFileCounter.innerHTML = `${counter}%`
                    }
                }, 100);
            }, 600);
        };


        // Simple File Validate Function
        function fileValidate(fileType, fileSize) {
            // File Type Validation
            let isImage = imagesTypes.filter((type) => fileType.indexOf(`image/${type}`) !== -1);

            // If The Uploaded File Type Is 'jpeg'
            if (isImage[0] === 'jpeg') {
                // Add Inisde (uploadedFileIconText) The (jpg) Value
                uploadedFileIconText.innerHTML = 'jpg';
            } else { // else
                // Add Inisde (uploadedFileIconText) The Uploaded File Type
                uploadedFileIconText.innerHTML = isImage[0];
            }
            ;

            // If The Uploaded File Is An Image
            if (isImage.length !== 0) {
                // Check, If File Size Is 2MB or Less
                if (fileSize <= 2000000) { // 2MB :)
                    return true;
                } else { // Else File Size
                    return alert('Please Your File Should be 2 Megabytes or Less');
                }
                ;
            } else { // Else File Type
                return alert('Please make sure to upload An Image File Type');
            }
            ;
        };

        // :)
        jQuery(document).ready(function ($) {
            $(document).ready(function () {
                $('.js-example-basic-single').select2();
            });
        })

        function selectShop() {
            var shop = document.getElementById('select-shop').value
            var host = document.getElementById("feedback_admin_url").value;
            jQuery(document).ready(function ($) {
                $.ajax({
                    method: 'POST',
                    url: host,
                    data: {
                        'action': 'getshopData',
                        'id': shop
                    }
                }).done(function (res) {
                    var shopData = res.shopData[0]
                    var shopName = shopData.post_title
                    var shopStatus = shopData.post_status
                    console.log(shopData)
                    console.log(shopName)
                    console.log(shopStatus)
                    var span = document.getElementById('shopStatus')
                    if (shopStatus === 'publish') {
                        span.innerText = 'فعال است، جهت پیگیری سفارش فرم را به دقت تکمیل نمایید'
                    }else if (shopStatus === 'draft'){
                        span.innerText = 'در انتظار بررسی است، با این حال پیگیری سفارش شما ارسال میشود تا قبل از فعال سازی آنرا پیگیری کند'
                    }else {
                        span.innerText = 'غیر فعال است، با این حال پیگیری سفارش شما ارسال میشود تا قبل از فعال سازی آنرا پیگیری کند'
                    }
                    var elements = document.getElementsByClassName("select-shop");
                    for (var i = 0; i < elements.length; i++) {
                        elements[i].innerText = shopName;
                    }
                })

            })
        }
    </script>
<?php get_footer() ?>