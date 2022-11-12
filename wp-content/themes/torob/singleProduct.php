<?php
/* Template Name: single product*/
?>
<?php
global $wpdb;
$user_id = do_shortcode('[current_user_id]');
$product_id = intval($_GET['id']);
$torob_main_product = $wpdb->prefix . 'torob_main_product';
$torob_product_categories = $wpdb->prefix . 'torob_product_categories';
$torob_product_descriptions = $wpdb->prefix . 'torob_product_descriptions';
$torob_product_history = $wpdb->prefix . 'user_history';
$torob_torob_wishlist = $wpdb->prefix . 'torob_wishlist';
$torob_product = $wpdb->prefix . "torob_product";
$result1 = $wpdb->get_results("SELECT * FROM $torob_main_product where product_id = $product_id");
$result2 = $wpdb->get_results("SELECT * FROM $torob_product_categories  where product_id = $product_id");
$result3 = $wpdb->get_results("SELECT * FROM $torob_product_descriptions  where product_id = $product_id");
$cat = $result2[2]->category;
$result4 = $wpdb->get_results("SELECT * FROM $torob_torob_wishlist  where user_id = $user_id");
$similar_products = $wpdb->get_results("SELECT *, (SELECT COUNT('id') FROM $torob_product WHERE productid=$torob_main_product.product_id) AS 'count',  (SELECT MIN(price) FROM $torob_product WHERE productid=$torob_main_product.product_id) AS 'minimum' FROM $torob_main_product JOIN $torob_product_categories ON $torob_main_product.product_id = $torob_product_categories.product_id WHERE $torob_product_categories.category = '$cat' AND $torob_product_categories.product_id != $product_id");
if (is_user_logged_in()) {
    $result5 = $wpdb->get_results("SELECT * FROM $torob_product_history  where product_id = $product_id and user_id = $user_id ");
    if (!$result5 || !$result5[0]) {
        $save_history = $wpdb->insert($torob_product_history, array(
            'product_id' => $product_id,
            'user_id' => $user_id,
        ));
    }
}
$pro_id = $result1[0]->product_id;
$main_cat = $result1[0]->product_type;
$get_result_price = $wpdb->get_results("SELECT * FROM $torob_product where productid = $pro_id && status = '1' ORDER BY price DESC ");
$get_result_torob_product = $wpdb->get_results("SELECT * FROM $torob_product where productid = $pro_id && adv = 0 && status = '1' ORDER BY price ASC");
$get_result_torob_product_adv = $wpdb->get_results("SELECT * FROM $torob_product where productid = $pro_id && adv = 1  && status = 1 ORDER BY price ASC");
$get_all_price = $wpdb->get_results("SELECT * FROM $torob_product where status = '1' ORDER BY price ASC ");
/* start line chart */
$dataPoints = array(
    array("y" => 105),
    array("y" => 130),
    array("y" => 158),
    array("y" => 192),
    array("y" => 309),
    array("y" => 422),
    array("y" => 566),
    array("y" => 807),
    array("y" => 1250),
    array("y" => 1615),
    array("y" => 2069),
    array("y" => 2635),
    array("y" => 3723),
    array("y" => 5112),
    array("y" => 6660),
    array("y" => 9183),
    array("y" => 15844),
    array("y" => 23185),
    array("y" => 40336),
    array("y" => 70469),
    array("y" => 100504),
    array("y" => 138856),
    array("y" => 178391),
    array("y" => 229300),
    array("y" => 302300),
    array("y" => 368000)
);
?>
<script>
    window.onload = function () {

        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            theme: "light2",
            title: {
                text: ""
            },
            axisY: {
                title: "",
                logarithmic: true,
                titleFontColor: "#6D78AD",
                gridColor: "#6D78AD",
                includeZero: true,
                labelFormatter: addSymbols
            },
            axisY2: {
                title: "",
                titleFontColor: "#51CDA0",
                tickLength: 0,
                labelFormatter: addSymbols
            },
            legend: {
                cursor: "pointer",
                verticalAlign: "bottom",
                fontSize: 12,
                itemclick: toggleDataSeries
            },
            data: [{
                type: "line",
                markerSize: 0,
                showInLegend: true,
                name: "کمترین قیمت",
                yValueFormatString: "#,##0 MW",
                dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
            },
                {
                    type: "line",
                    markerSize: 0,
                    axisYType: "secondary",
                    showInLegend: true,
                    name: "میانگین قیمت",
                    yValueFormatString: "#,##0 MW",
                    dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                }]
        });
        chart.render();

        function addSymbols(e) {
            var suffixes = ["", "", "", ""];

            var order = Math.max(Math.floor(Math.log(e.value) / Math.log(1000)), 0);
            if (order > suffixes.length - 1)
                order = suffixes.length - 1;

            var suffix = suffixes[order];
            return CanvasJS.formatNumber(e.value / Math.pow(1000, order)) + suffix;
        }

        function toggleDataSeries(e) {
            if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                e.dataSeries.visible = false;
            } else {
                e.dataSeries.visible = true;
            }
            chart.render();
        }

    }
</script>
<!--end line chart-->
<title><?php foreach ($result1 as $item): ?><?php echo $item->product_name ?> - ترب<?php endforeach; ?></title>
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

<div class="single-product">
    <div class="d-flex justify-content-between align-items-center">
        <div class="breadcrumb">
            <?php foreach ($result1 as $item): ?>
                <span> <a href="<?php echo home_url() ?>">ترب </a> > <?php echo $item->product_name ?></span>
            <?php endforeach; ?>
        </div>
        <div>
            <?php if (is_user_logged_in()): ?>
                <a href="<?php echo get_home_url() . '/integration-panel-products?id=' . $item->product_id ?>"
                   style="color: var(--bs-link-hover-color);" target="_blank">ادغام</a>

            <?php endif; ?>
        </div>
    </div>
    <div class="d-flex gap-3">
        <?php foreach ($result1 as $item): ?>
            <div class="main-single-product-head row">
                <div class="single-product-image col-md-3"><img
                            src="<?php echo $item->url_image ?>" style="width: 216px; height: 216px;"></div>
                <div class="col-md-8">
                    <h1><?php echo $item->product_name;?></h1>
                    <?php if ($get_result_price && count($get_result_torob_product) > 1) : ?>
                        <p class="price-range">
                            از<?php $number = $get_result_price ? $get_result_price[count($get_result_price) - 1] : null;
                            echo $english_format_number = $number ? number_format($number->price) : ''; ?> تومان
                            تا <?php $number = $get_result_price ? $get_result_price[0] : null;
                            echo $english_format_number = $number ? number_format($number->price) : ''; ?> تومان
                        </p>
                    <?php elseif ($get_result_price && count($get_result_torob_product) == 1 || $get_result_torob_product_adv && count($get_result_torob_product_adv) == 1 ): ?>
                        <p class="price-range">
                        <?php $number = $get_result_price ? $get_result_price[count($get_result_price) - 1] : null;
                        echo $english_format_number = $number ? number_format($number->price) : ''; ?> تومان
                        </p>
                    <?php else: ?>
                        <p>فروشنده ای برای این محصول پیدا نشد!</p>
                    <?php endif; ?>
                    <?php if ($get_result_price) : ?>
                        <div class="d-flex">
                            <a href="<?php echo $get_result_price ? $get_result_price[count($get_result_price) - 1]->link : '' ?>"
                               class="cheapest-seller" target="_blank">خرید از ارزانترین فروشنده</a>
                            <div class="share-product d-flex justify-content-around align-items-center">
                                <div><i class="far fa-bell"></i></div>
                                <div>
                                    <form action="" method="post" name="wishlist-torob" style="margin-bottom: 0;"
                                          onsubmit="event.preventDefault()">
                                        <input id="admin_url" type="hidden"
                                               value="<?php echo admin_url('admin-ajax.php') ?>"/>
                                        <input id="wishlist_id" type="hidden" value="0"/>
                                        <input id="product_id" type="hidden" value="<?php echo $product_id ?>"/>
                                        <input id="user_id" type="hidden" value="<?php echo $user_id ?>"/>
                                        <button name="wishlist-torob" onclick="save_wishlist_torob()"
                                                style="background: none;border: none;color: #999;"><?php
                                            if (is_user_logged_in()) {
                                                if ($result4 && $result4[0]->user_id == $user_id && $result4[0]->product_id == $product_id) {
                                                    echo '<i class="fas fa-heart" id="heart-torob"></i>';
                                                } else {
                                                    echo '<i class="far fa-heart" id="heart-torob"></i>';
                                                }
                                            }
                                            ?></button><?php if (!is_user_logged_in()) {
                                            echo '<i class="far fa-heart"></i>';
                                        } ?>
                                    </form>
                                </div>
                                <?php
                                $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http';
                                $full_url = $protocol . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                                ?>
                                <a href="whatsapp://send?text=<?php echo $full_url; ?>">
                                    <svg fill="#999999" width="24" height="24" viewBox="0 0 24 24"
                                         xmlns="http://www.w3.org/2000/svg" title="share2">
                                        <g>
                                            <path d="M18 15c-1.1 0-2.1.5-2.8 1.2l-5.3-3.1c0-.4.1-.7.1-1.1 0-.4-.1-.7-.2-1.1l5.3-3.1c.8.7 1.8 1.2 2.9 1.2 2.2 0 4-1.8 4-4s-1.8-4-4-4-4 1.8-4 4c0 .4.1.7.2 1.1L8.8 9.2C8.1 8.5 7.1 8 6 8c-2.2 0-4 1.8-4 4s1.8 4 4 4c1.1 0 2.1-.5 2.8-1.2l5.3 3.1c0 .4-.1.7-.1 1.1 0 2.2 1.8 4 4 4s4-1.8 4-4-1.8-4-4-4zm0-12c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2zM6 14c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm12 7c-1.1 0-2-.9-2-2 0-.4.1-.7.3-1 .3-.6 1-1 1.7-1 1.1 0 2 .9 2 2s-.9 2-2 2z"></path>
                                        </g>
                                    </svg>
                                </a>
                                <a href="#" class="report"><img
                                            src="<?php echo get_template_directory_uri() . '/images/flag_active.png' ?>">گزارش
                                    مشکل</a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
        <div class="details-product-head">
            <h2>تغییرات قیمت</h2>
            <div id="chartContainer" style="height: 200px; width: 100%;"></div>
            <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
        </div>
    </div>
    <div class="d-flex gap-3 mt-3">
        <div class="main-single-product row position-relative">
            <div class="d-flex justify-content-between align-items-center online-shop" style="height: 100px;">
                <h2>فروشگاه‌های اینترنتی </h2>
                <a href="<?php echo get_home_url() . '/safe-shopping-guide' ?>" class="main-single-product-a"
                   target="_blank">راهنمای خرید امن</a>
            </div>
            <div class="position-absolute" style="margin-top: 100px">
                <div id="shop-details" style="max-height: 646px; overflow: hidden; transition: all 0.5s linear">
                    <?php foreach ($get_result_torob_product_adv as $item) : ?>
                        <?php $meta = get_post_meta($item->shopid);
                        ?>
                        <div class="row main-shop">
                            <div class="col-md-3">
                                <div class="shop-name"><a href="<?php $str = $meta['shopName'][0];
                                    $str = str_replace(" ", "-", $str);
                                    echo get_home_url() . '/torob/' . $str; ?>"
                                                          target="_blank"><?php echo $meta['shopName'][0] ?></a></div>
                                <div class="shop-city"><a href="#" target="_blank"><?php echo $meta['city'][0] ?></a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <input class="toggle-box1" id="header-first-1" type="checkbox">
                                <label for="header-first-1" class="label-1"><i
                                            class="fas fa-star"></i><?php echo isset($meta['rmp_avg_rating'][0]) ? (round($meta['rmp_avg_rating'][0], 1)) : '0'; ?>
                                    (3
                                    ماه در ترب) <i
                                            class="fas fa-angle-down"></i></label>
                                <div class="details-product-1">
                                <span>
                                     <i class="fas fa-star"></i><?php echo isset($meta['rmp_avg_rating'][0]) ? (round($meta['rmp_avg_rating'][0], 1)) : '0'; ?> (3 ماه در ترب)
                                </span>
                                    <span>
حدود ۱۰۰۰ تا ۲۰۰۰ سفارش در ۹۰ روز اخیر فعالیت در ترب
                                </span>
                                    <span>
۱۲ کاربر از طریق ترب سفارش خود را پیگیری کرده اند.
                                </span>
                                    <a href="<?php $str = $meta['shopName'][0];
                                    $str = str_replace(" ", "-", $str);
                                    echo get_home_url() . '/torob/' . $str; ?>" class="btn-details" target="_blank">پروفایل
                                        فروشگاه</a>
                                    <a href="#" class="btn-details">شیوه ارزیابی فروشگاه</a>
                                </div>
                                <a href="<?php echo $item->link ?>" class="name-product" target="_blank">
                                    <?php echo $item->name ?>
                                </a>

                                <input class="toggle-box2" id="header-second-1" type="checkbox">
                                <label for="header-second-1" class="label-2"><i class="far fa-credit-card"></i> پرداخت
                                    در
                                    محل <i
                                            class="fas fa-truck"></i> ارسال رایگان <i class="fas fa-shipping-fast"></i>
                                    تحویل فوری <i class="fas fa-angle-down"></i>
                                </label>
                                <div class="details-product-2">
                                    <span><i class="far fa-credit-card"></i> <?php echo $meta['pay'][0] ?></span>
                                    <span><i class="fas fa-truck"></i>  <?php echo $meta['send'][0] ?> </span>
                                    <!--                                    <span><i class="fas fa-shipping-fast"></i>امکان تحویل در همان روز برای شیراز با هماهنگی </span>-->
                                    <a href="<?php $str = $meta['shopName'][0];
                                    $str = str_replace(" ", "-", $str);
                                    echo get_home_url() . '/torob/' . $str; ?>" class="btn-details" target="_blank">پروفایل
                                        فروشگاه</a>

                                </div>

                            </div>
                            <div class="col-md-3 maine-price position-relative">
                                <p class="ads-product">آگهی</p><br>
                                <p class="price-product position-absolute"> <?php $number = $item->price;
                                    echo $english_format_number = number_format($number); ?> تومان</p><br>
                                <a href="<?php echo $item->link ?>" class="product-buy" target="_blank">خرید
                                    اینترنتی</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <?php foreach ($get_result_torob_product as $item) : ?>
                        <?php $meta = get_post_meta($item->shopid);
                        ?>
                        <div class="row main-shop">
                            <div class="col-md-3">
                                <div class="shop-name"><a href="<?php $str = $meta['shopName'][0];
                                    $str = str_replace(" ", "-", $str);
                                    echo get_home_url() . '/torob/' . $str; ?>"
                                                          target="_blank"><?php echo $meta['shopName'][0] ?></a></div>
                                <div class="shop-city"><a href="#" target="_blank"><?php echo $meta['city'][0] ?></a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <input class="toggle-box1" id="header-first-<?php echo $item->id ?>" type="checkbox"
                                       hidden>
                                <label for="header-first-<?php echo $item->id ?>" class="label-1">
                                    <i class="fas fa-star"></i><?php echo isset($meta['rmp_avg_rating'][0]) ? (round($meta['rmp_avg_rating'][0], 1)) : '0'; ?>
                                    (3 ماه در ترب)
                                    <i class="fas fa-angle-down"></i>
                                </label>
                                <div class="details-product-1">
                                <span>
                                     امتیاز فروشگاه <i
                                            class="fas fa-star"></i><?php echo isset($meta['rmp_avg_rating'][0]) ? (round($meta['rmp_avg_rating'][0], 1)) : '0'; ?> (3 ماه در ترب)
                                </span>
                                    <span>
حدود ۱۰۰۰ تا ۲۰۰۰ سفارش در ۹۰ روز اخیر فعالیت در ترب
                                </span>
                                    <span>
۱۲ کاربر از طریق ترب سفارش خود را پیگیری کرده اند.
                                </span>
                                    <a href="<?php $str = $meta['shopName'][0];
                                    $str = str_replace(" ", "-", $str);
                                    echo get_home_url() . '/torob/' . $str; ?>" class="btn-details" target="_blank">پروفایل
                                        فروشگاه</a>
                                    <a href="#" class="btn-details">شیوه ارزیابی فروشگاه</a>
                                </div>
                                <a href="<?php echo $item->link ?>" class="name-product" target="_blank">
                                    <?php echo $item->name ?>
                                </a>

                                <input class="toggle-box2" id="header-second-<?php echo $item->id ?>" type="checkbox">
                                <label for="header-second-<?php echo $item->id ?>" class="label-2"><i
                                            class="far fa-credit-card"></i> پرداخت
                                    در
                                    محل <i
                                            class="fas fa-truck"></i> ارسال رایگان <i class="fas fa-shipping-fast"></i>
                                    تحویل فوری <i class="fas fa-angle-down"></i>
                                </label>
                                <div class="details-product-2">
                                    <span><i class="far fa-credit-card"></i> <?php echo $meta['pay'][0] ?></span>
                                    <span><i class="fas fa-truck"></i>  <?php echo $meta['send'][0] ?> </span>
                                    <!--                                    <span><i class="fas fa-shipping-fast"></i>امکان تحویل در همان روز برای شیراز با هماهنگی </span>-->
                                    <a href="<?php $str = $meta['shopName'][0];
                                    $str = str_replace(" ", "-", $str);
                                    echo get_home_url() . '/torob/' . $str; ?>" class="btn-details" target="_blank">پروفایل
                                        فروشگاه</a>
                                </div>

                            </div>
                            <div class="col-md-3 maine-price position-relative">
                                <p class="price-product position-absolute"><?php $number = $item->price;
                                    echo $english_format_number = number_format($number); ?> تومان</p><br>
                                <a href="<?php echo $item->link ?>" class="product-buy" target="_blank">خرید
                                    اینترنتی</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="other-shop">
                    <script>
                        var numberClasses = document.getElementsByClassName("main-shop").length;
                    </script>
                    <button name="more-shop" id="more-shop" onclick="show()" class="more-shop">
                        <script>document.write(' نمایش تمام ' + numberClasses + ' فروشگاه ');</script>
                    </button>
                </div>
            </div>
        </div>
        <div class="details-product">
            <?php foreach ($result1 as $item): ?>
                <h2 class="title-name"><?php echo $item->product_name ?></h2>
            <?php endforeach; ?>
            <p class="title-box">مشخصات کلی</p>
            <?php foreach ($result3 as $item): ?>
                <p class="title_item"><?php echo $item->title ?></p>
                <p class="value_item"><?php echo $item->value ?></p>
            <?php endforeach; ?>

        </div>
    </div>
    <h5 class="similar_products">محصولات مشابه</h5>
    <div class="d-flex gap-3 flex-wrap product-area w-100">
        <?php foreach ($similar_products as $item) : ?>
            <div class="product-torob">
                <a href="<?php echo get_home_url() . '/single-product/?id=' . $item->product_id ?>">
                    <img src="<?php echo $item->url_image ?>" alt="<?php echo $item->product_name ?>"
                         style="width: 135px;height: 145px;"></a>
                <h2 class="info-product"><?php echo $item->product_name ?></h2>
                <br>
                <p class="price-torob">از <?php $number = $item->minimum;
                    echo $english_format_number = number_format($number); ?> تومان</p>
                <p class="in-shop">در <?php echo $item->count ?> فروشگاه</p>
                <div class="d-flex justify-content-around icon-product">
                    <div>
                        <form action="" method="post" name="wishlist-torob" style="margin-bottom: 0;"
                              onsubmit="event.preventDefault()">
                            <input id="admin_url" type="hidden" value="<?php echo admin_url('admin-ajax.php') ?>"/>
                            <input id="wishlist_id-<?php echo $item->product_id ?>" type="hidden" value="0"/>
                            <input id="product_id-<?php echo $item->product_id ?>" type="hidden"
                                   value="<?php echo $item->product_id ?>"/>
                            <input id="user_id" type="hidden" value="<?php echo $user_id ?>"/>
                            <button name="wishlist-torob"
                                    onclick="save_wishlist_torob('<?php echo $item->product_id ?>')"
                                    style="background: none;border: none;color: #999;">
                                <?php if (count($result4) > 0): ?>
                                    <?php
                                    $flag = true;
                                    foreach ($result4 as $item) : ?>
                                        <?php if ($flag && is_user_logged_in()): ?>
                                            <?php if ($item && $item->user_id == $user_id && $item->product_id == $product_id) : ?>
                                                <?php $flag = false ?>
                                                <i class="fas fa-heart"
                                                   id="heart-torob-<?php echo $item->product_id ?>"></i>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                    <?php if ($flag && is_user_logged_in()): ?>
                                        <i class="far fa-heart"
                                           id="heart-torob-<?php echo $item->product_id ?>"></i>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <i class="far fa-heart"
                                       id="heart-torob-<?php echo $item->product_id ?>"></i>
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

    function show() {
        var x = document.getElementById("shop-details");
        var y = document.getElementById("more-shop");
        if (x.style.maxHeight === "max-content") {
            x.style.maxHeight = "646px";
            y.innerText = ' نمایش تمام ' + numberClasses + ' فروشگاه ';
        } else {
            x.style.maxHeight = "max-content";
            y.innerText = 'نمایش کمتر فروشگاه ها'
        }
    }


    /*ajax*/

    function save_wishlist_torob(id) {

        jQuery(document).ready(function ($) {
            var host = document.getElementById("admin_url").value;
            var user_id = document.getElementById("user_id").value;
            var product_id = document.getElementById("product_id").value;
            var targetId = "#heart-torob"
            if (id) {
                product_id = document.getElementById("product_id-" + id).value;
                targetId += "-" + id
            }

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
                        $(targetId).removeClass('far').addClass('fas')
                    } else {
                        $(targetId).removeClass('fas').addClass('far')
                    }
                });
        });
    }

    /*ajax*/
</script>
<?php get_footer() ?>

