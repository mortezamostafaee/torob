<?php
/* Template Name: integration panel products */
global $wpdb;
$user_id = do_shortcode('[current_user_id]');
$product_id = intval($_GET['id']);
$allShop = $wpdb->get_results($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'torob' AND post_author = $user_id order by ID desc"));
$terms = get_terms([
    'taxonomy' => 'cat_torob',
    'hide_empty' => false,
]);
$torob_product = $wpdb->prefix . "torob_product";
$torob_separation_seller = $wpdb->prefix . "torob_separation_seller";
$posts = $wpdb->prefix . "posts";
$torob_product_category = $wpdb->prefix . "torob_product_categories";
$main_torob_product = $wpdb->prefix . "torob_main_product ";
$torob_product_descriptions = $wpdb->prefix . 'torob_product_descriptions';
$torob_integration = $wpdb->prefix . "torob_integration";
$torob_change_category_mine_product_intgration = $wpdb->prefix . "torob_change_category_mine_product_intgration";
$produc_id = $_GET['id'];
$result_price = $wpdb->get_results("SELECT * FROM $torob_product where productid = $produc_id order by price ASC");
$result_shop = $wpdb->get_results("SELECT * FROM $torob_product JOIN $posts on $torob_product.shopid = $posts.ID where productid = $produc_id ");
$result_torob_product_categories = $wpdb->get_results("SELECT * FROM $torob_product_category where product_id = $produc_id");
$result_torob_product_descriptions = $wpdb->get_results("SELECT * FROM $torob_product_descriptions where product_id = $produc_id");
$result_main_product = $wpdb->get_results("SELECT * FROM $main_torob_product where product_id = $produc_id");
$brand = $result_main_product[0]->brand;
$product_type = $result_main_product[0]->product_type;
$other_main_product = $wpdb->get_results("SELECT *, (SELECT COUNT('id') FROM $torob_product WHERE $torob_product.productid=$main_torob_product.product_id) AS 'count' FROM $main_torob_product where brand = '$brand' AND product_id != $produc_id AND product_type = '$product_type'");
$all_other_main_product = $wpdb->get_results("SELECT *, (SELECT COUNT('id') FROM $torob_product WHERE $torob_product.productid=$main_torob_product.product_id) AS 'count' FROM $main_torob_product order by product_id desc");
if (isset($_POST['opt-out-product'])) {
    $suggested_category = $_POST['term'];
    $current_category = $_POST['current_category'];
    foreach ($_POST['products'] as $pro) {
        $duplicate = $wpdb->get_results("SELECT * FROM $torob_separation_seller WHERE current_category='$current_category' AND product_id='$pro' AND suggested_category='$suggested_category'");
        if (!sizeof($duplicate)) {
            $wpdb->insert($torob_separation_seller, array(
                'product_id' => $pro,
                'suggested_category' => $_POST['term'],
                'current_category' => $_POST['current_category'],
                'user_id' => $_POST['user_id'],
                'shop_name' => $_POST['shop-name']),
                array('%d', '%s', '%s', '%d', '%s')
            );
        } else { ?>
            <script>alert("کاربر گرامی این محصول قبلا جهت بررسی به مدیریت اعلام شده");</script>
        <?php }
    }
}
if (isset($_POST['add-integration'])) {
    $product_integration_id = $_POST['product-integration-id'];
    $product_main_id = $_POST['product-main-id'];
    $duplicate_integration = $wpdb->get_results("SELECT * FROM $torob_integration where product_integration_id = $product_integration_id AND product_main_id = $product_main_id");
    if (!$duplicate_integration) {
        $wpdb->insert($torob_integration, array(
            'user_id' => $_POST['user-id-integration'],
            'product_integration_id' => $_POST['product-integration-id'],
            'product_main_id' => $_POST['product-main-id']),
            array('%d', '%d', '%d')
        ); ?>
        <script>alert("محصول با موفقیت جهت ادغام به مدیریت اعلام شد");</script>
    <?php } else { ?>
        <script>alert("کاربر گرامی این محصول قبلا جهت بررسی به مدیریت اعلام شده");</script>
    <?php }

}
if (isset($_POST['save-change-term'])) {
    global $wpdb;
    $change_term_product_main_id = $_POST['change-term-product-main-id'];
    $change_term = $_POST['change-term'];
    $current_category = $_POST['current_category'];
    $duplicate_term = $wpdb->get_results("SELECT * FROM $torob_change_category_mine_product_intgration WHERE product_id='$change_term_product_main_id' AND category='$change_term' AND current_category='$current_category'");
    if (!sizeof($duplicate_term)) {
        if ($change_term  != $current_category){
            $torob_change_category_mine_product_intgration = $wpdb->prefix . "torob_change_category_mine_product_intgration";
            $wpdb->insert($torob_change_category_mine_product_intgration, array(
                'user_id' => $_POST['user_id'],
                'product_id' => $_POST['change-term-product-main-id'],
                'category' => $_POST['change-term'],
                'current_category' => $_POST['current_category'],
            ),
                array('%d', '%d', '%s', '%s')
            );?>
            <script>alert("محصول با موفقیت جهت تغییر دسته بندی به مدیریت اعلام شد");</script>
        <?php } else { ?>
            <script>alert("کاربر گرامی دسته بندی این محصول با دسته بندی انتخاب شده یکسان است، لطفا دسته بندی را با دقت انتخاب کنید");</script>
        <?php }
        } else { ?>
        <script>alert("کاربر گرامی این محصول قبلا جهت بررسی به مدیریت اعلام شده");</script>
    <?php }
}
//var_dump($duplicate_term);
?>
<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title>پنل ترب</title>
    <link rel="stylesheet" href="<?php echo get_template_directory_uri() . '/css/custom-page.css' ?>">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri() . '/css/bootstrap.css' ?>">
    <link href="<?php echo get_template_directory_uri() . '/css/select2.min.css' ?>" rel="stylesheet"/>
    <style>
        .select2-dropdown.select2-dropdown--above {
            direction: rtl;
        }

        .select2-dropdown.select2-dropdown--below {
            text-align: right;
        }

        /* The Modal (background) */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            padding-top: 100px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.4);
        }

        /* Modal Content */
        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 35%;
            direction: rtl;
        }

        /* The Close Button */
        .close {
            color: #aaaaaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }

        .select2.select2-container.select2-container--default {
            direction: rtl;
        }
    </style>
</head>
<body class="integration-panel-products">
<?php if (is_user_logged_in()): ?>


    <div class="side-integration">
        <div class="d-flex justify-content-end">
            <button class="tablink btn btn-primary w-auto" id="tablink1" onclick="openPage('Home')">
                همه ی محصولات
            </button>
        </div>

        <div class="d-flex justify-content-center mt-3">
            <img src="<?php echo $result_main_product[0]->url_image ?>" width="273" height="170">
        </div>
        <p dir="rtl" class="mt-3"><?php echo $result_main_product[0]->product_name ?></p>
        <div class="d-flex justify-content-end">
            <p>تومان</p>
            &nbsp;
            <p><?php echo $result_price[0]->price ?></p>
        </div>
        <p dir="rtl"><?php echo $result_main_product[0]->product_type ?> </p>
        <div class="d-flex justify-content-end">
            <p><?php echo $result_main_product[0]->brand ?></p>
            <p>: برند</p>
        </div>
        <div class="box4">
            <a class="btn-inergration d-flex justify-content-center" href="#popup4">درخواست تغییر دسته بندی </a>
        </div>
        <div id="popup4" class="overlay4">
            <div class="popup4">
                <div class="d-flex justify-content-between">
                    <p style="width: 90%;text-align: center;">درخواست تغییر دسته‌بندی </p>
                    <a class="close4-3" href="#">&times;</a>
                </div>
                <hr class=" mt-0">
                <div class="content4" style="text-align: right;direction: rtl;">
                    <b>دسته بندی فعلی</b>
                    <p dir="rtl"><?php echo $result_main_product[0]->product_type ?> </p>
                    <b>دسته بندی نهایی</b><br><br>
                    <form method="post">
                        <input id="user_id" type="hidden" name="user_id" value="<?php echo $user_id ?>"/>
                        <input type="hidden" name="change-term-product-main-id"
                               value="<?php echo $result_main_product[0]->product_id ?>">
                        <input type="hidden" name="current_category"
                               value="<?php echo $result_main_product[0]->product_type ?>">
                        <select class="js-example-basic-single " name="change-term"
                                style="width: 100%; text-align: right">
                            <?php foreach ($terms as $term) : ?>
                                <option><?php echo $term->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <input type="submit" class="btn btn-primary mt-3" value="ثبت" name="save-change-term">
                    </form>
                </div>
            </div>
        </div>
        <a href="#" class="btn btn-secondary d-flex justify-content-center mt-2 mb-2">درخواست ادغام</a>
        <!-- Trigger/Open The Modal -->
        <button dir="auto" type="button" class="btn btn-secondary button-2 separation-seller mb-2 mt-2 w-100"
                id="myBtn"
                disabled>
            <span id="num-seller">درخواست جداسازی فروشنده</span>
        </button>

        <!-- The Modal -->
        <hr>
        <div id="show" dir="auto" class="d-flex justify-content-between align-items-center pointer"
             style="cursor: pointer;">
            <p class="mb-0">
                فروشندگان(<?php echo count($result_shop) ?>)
            </p>
            <svg style="width: 12px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                <!-- Font Awesome Pro 5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) -->
                <path d="M143 352.3L7 216.3c-9.4-9.4-9.4-24.6 0-33.9l22.6-22.6c9.4-9.4 24.6-9.4 33.9 0l96.4 96.4 96.4-96.4c9.4-9.4 24.6-9.4 33.9 0l22.6 22.6c9.4 9.4 9.4 24.6 0 33.9l-136 136c-9.2 9.4-24.4 9.4-33.8 0z"/>
            </svg>
        </div>

        <form method="post">
            <div class="sellers" style="display: none;">

                <div id="myModal" class="modal">

                    <!-- Modal content -->
                    <div class="modal-content">
                        <div class="row">
                            <span class="close col-md-1">&times;</span>
                            <p class="text-center mb-0 col-md-11" style="padding-top: 9px;">درخواست جداسازی فروشنده</p>
                        </div>
                        <hr>
                        <div id="products-ajax"></div>
                        <p class="mt-2" style="color: #000; font-weight: bold;">دسته بندی فعلی</p>
                        <p class="mt-2"
                           style="color: #1d2327;"><?php echo $result_main_product[0]->product_type ?></p>
                        <p class="mt-2" style="color: #000; font-weight: bold;">انتقال به دسته بندی </p>
                        <select class="js-example-basic-single" name="term"
                                style="margin-top: 10px; width: 100%; text-align: right">
                            <?php foreach ($terms as $term) : ?>
                                <option><?php echo $term->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <input type="hidden" name="current_category"
                               value="<?php echo $result_main_product[0]->product_type ?>">
                        <hr>
                        <div class="row">
                            <div class="col-md-3">
                                <button type="submit" name="opt-out-product" class="btn btn-danger">جداسازی</button>
                            </div>
                            <div class="col-md-6">

                                <button type="submit" name="opt-out-product-next" class="btn btn-danger"
                                        style="font-size: 13px;padding: 8px 5px;">جدارسازی و نمایش محصول بعدی
                                </button>

                            </div>
                        </div>
                    </div>

                </div>
                <input id="admin_url" type="hidden" value="<?php echo admin_url('admin-ajax.php') ?>"/>
                <input id="user_id" type="hidden" name="user_id" value="<?php echo $user_id ?>"/>
                <ol dir="rtl" style="padding: 0" id="sellers">
                    <?php foreach ($result_shop as $item) : ?>
                        <li class="list-style" style="position: relative; margin-bottom: 3px;">
                            <input type="checkbox" value="<?php echo $item->id ?>" name="input-seller" id="product_id"
                                   class="input-seller">
                            <img src="<?php echo $item->image_link ? $item->image_link : get_template_directory_uri() . '/images/noimg.png' ?>"
                                 style="width: 47px; height: 47px;">
                            <a href="#" style="font-size: 12px; text-decoration: none;"><?php echo $item->name ?></a>
                            <div class="d-flex ditle-product-seller">
                                <input id="shop-name" type="hidden" name="shop-name"
                                       value="<?php echo $item->post_title ?>"/>
                                <p class="mb-0"><?php echo $item->post_title ?></p> &nbsp;
                                <p class="mb-0" style="font-size: 13px;font-weight: bold;"><?php $number = $item->price;
                                    echo $english_format_number = number_format($number); ?> تومان</p>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ol>

            </div>
        </form>
        <hr>
        <div id="show-discription" dir="auto" class="d-flex justify-content-between align-items-center pointer"
             style="cursor: pointer;">
            <p class="mb-0">
                مشخصات
            </p>
            <svg style="width: 12px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                <!-- Font Awesome Pro 5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) -->
                <path d="M143 352.3L7 216.3c-9.4-9.4-9.4-24.6 0-33.9l22.6-22.6c9.4-9.4 24.6-9.4 33.9 0l96.4 96.4 96.4-96.4c9.4-9.4 24.6-9.4 33.9 0l22.6 22.6c9.4 9.4 9.4 24.6 0 33.9l-136 136c-9.2 9.4-24.4 9.4-33.8 0z"/>
            </svg>
        </div>
        <hr>
        <div class="sellers-discription" style="display: none;" dir="rtl">

            <p class="title-box">مشخصات کلی</p>
            <?php foreach ($result_torob_product_descriptions as $item): ?>
                <p class="title_item"><?php echo $item->title ?></p>
                <p class="value_item"><?php echo $item->value ?></p>
            <?php endforeach; ?>
        </div>
        <div class="d-flex justify-content-between" dir="rtl">
            <p style="font-size: 13px;">وضعیت محصول</p>
            <p style="font-size: 13px; color: #000;"><?php
                if ($result_main_product[0]->check === '0') {
                    echo 'درانتظار بررسی';
                } elseif ($result_main_product[0]->check === '1') {
                    echo 'تایید شده';
                } else {
                    echo 'تایید نشده';
                } ?></p>
        </div>
        <div class="d-flex justify-content-between" dir="rtl">
            <p style="font-size: 13px;">وضعیت درخواست ها:</p>
            <p style="font-size: 13px; color: #000;">تایید شده</p>
        </div>
    </div>
    <div class="main-integration-product">
        <span class="header_dashbord">
         <div class="d-flex align-items-center" style="background: #d1ecf1">
              <button id="hide" class="hide-text">
        <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round"
             stroke-linejoin="round" style="vertical-align: middle; fill: none;" height="1em" width="1em"
             xmlns="http://www.w3.org/2000/svg">
            <line x1="18" y1="6" x2="6" y2="18"></line>
            <line x1="6" y1="6" x2="18" y2="18"></line>
        </svg>
        </button>
    <p class="hide-text mb-0 w-100">
        با توجه به کیفیت درخواست‌های شما در هفته گذشته، سقف درخواست‌های فروشگاه شما در این هفته، هر روز 50 درخواست است.
    </p>

       </div>
        <div class="d-flex align-items-center" style="background: #fff3cd">
            <button id="hide2" class="hide-text2">
        <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round"
             stroke-linejoin="round" style="vertical-align: middle; fill: none;" height="1em" width="1em"
             xmlns="http://www.w3.org/2000/svg">
            <line x1="18" y1="6" x2="6" y2="18"></line>
            <line x1="6" y1="6" x2="18" y2="18"></line>
        </svg>
    </button>
            <p class="hide-text2 mb-0 w-100">
        لطفا به یکسان بودن برند، نوع، وزن، تعداد، طعم توجه فرمایید.
    </p>
       </div>
    </span>
        <div class="integration-detile">

            <button class="tablink" id="tablink1" onclick="openPage('Home')">
                جستجو در تمام کالاها
                <hr style="margin: 0; border: none;height: 7px;color: #d3d3d3;background-color: #d3d3d3;opacity: 1;width: 70%;margin: 0 auto;border-radius: 5px;">
            </button>
            <button class="tablink" id="tablink2" onclick="openPage('News')">
                لینک در سایت ترب
                <hr style="margin: 0; border: none;height: 7px;color: #d3d3d3;background-color: #d3d3d3;opacity: 1;width: 70%;margin: 0 auto;border-radius: 5px;">
            </button>
            <button class="tablink" id="defaultOpen" onclick="openPage('Contact')">
                محصولات پیشنهادی برای ادغام
                <hr style="margin: 0; border: none;height: 7px;color: #d3d3d3;background-color: #d3d3d3;opacity: 1;width: 70%;margin: 0 auto;border-radius: 5px;">
            </button>


            <div id="Home" class="tabcontent-sellers">
                <div style="border-top: solid #4a90e2;margin-top: 3px;">
                    <div class="request-history" style="padding-top: 15px;">
                        <input id="admin_url_filter" type="hidden" value="<?php echo admin_url('admin-ajax.php') ?>"/>
                        <div class="row seven-cols">
                            <div class="col-md-1">
                                <label for="ategory-status-integration" class="w-100">وضعیت دسته‌بندی</label>
                                <select class="js-example-basic-single" name="category-status-integration"
                                        id="category-status-integration"
                                        dir="auto" style="width: 100%;">
                                    <option value="">همه</option>
                                    <option value="0">منتظر دسته بندی</option>
                                    <option value="1">دسته بندی نهایی شده</option>
                                </select>
                            </div>
                            <div class="col-md-1">
                                <label for="access-status-integration" class="w-100">وضعیت دسترسی</label>
                                <select class="js-example-basic-single" name="access-status-integration" dir="auto"
                                        id="access-status-integration"
                                        style="width: 100%;">
                                    <option value="">همه</option>
                                    <option value="درانتظار بررسی">درانتظار بررسی</option>
                                    <option value="تایید شده">تایید شده</option>
                                    <option value="رد شده">رد شده</option>
                                </select>
                            </div>
                            <div class="col-md-1">
                                <label for="inventory-status-integration"> وضعیت موجودی</label>
                                <select class="js-example-basic-single" name="inventory-status-integration"
                                        id="inventory-status-integration"
                                        dir="auto" style="width: 100%;">
                                    <option value="همه">همه</option>
                                    <option value="1">موجود</option>
                                    <option value="2">ناموجود</option>
                                </select>
                            </div>
                            <div class="col-md-1">
                                <label for="integration-status">وضعیت ادغام</label>
                                <select class="js-example-basic-single" name="integration-status" dir="auto"
                                        id="integration-status"
                                        style="width: 100%;">
                                    <option value="">همه</option>
                                    <option value="1">ادغام شده</option>
                                    <option value="0">ادغام نشده</option>
                                </select>
                            </div>
                            <div class="col-md-1">
                                <label for="integration-product-category">دسته بندی محصول</label><br>
                                <select class="js-example-basic-multiple" name="term[]" multiple="multiple"
                                        id="term-integration"
                                        style="margin-top: 10px; width: 100%;" dir="auto">
                                    <?php foreach ($terms as $term) : ?>
                                        <option value="<?php echo $term->name; ?>"><?php echo $term->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-1">
                                <label for="integration-name-product">عنوان محصول</label><br>
                                <input type="text" value="" class="w-100" name="integration-name-product" dir="auto"
                                       id="integration-name-product"
                                       style="border: solid 1px #aaa;border-radius: 3px;">
                            </div>
                            <div class="col-md-1">
                                <button name="filter_price" onclick="filter_price()" class="mt-3 btn btn-primary"
                                        id="filter_price">اعمال فیلترها
                                </button>
                            </div>
                        </div>

                        <p class="notice-filter">اگر محصول را پیدا نمی‌کنید به فیلترها دقت کنید</p>
                        <hr>
                        <input id="admin_url_filter_sort" type="hidden"
                               value="<?php echo admin_url('admin-ajax.php') ?>"/>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="sort">ترتیب نمایش:</label>
                                <select name="sort" style="border: none;background: no-repeat;" id="sort">
                                    <option value="1">تازه ترینها</option>
                                    <option value="0">قدیمی ترین ها</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="pagination-sort"> تعداد در هر صفحه:</label>
                                <select name="pagination-sort" id="pagination-sort"
                                        style="border: none;background: no-repeat;">
                                    <option value="">همه</option>
                                    <option value="20">20</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                    <option value="200">200</option>
                                </select>
                            </div>
                            <div class="col-md-3">0 کالا از 0</div>
                            <div class="col-md-2">
                                <button name="filter_sort" onclick="filter_sort()" class="btn btn-primary"
                                        id="filter_sort">اعمال فیلترها
                                </button>
                            </div>
                        </div>

                        <hr>
                    </div>
                    <div class="d-flex gap-3 dingle-pro-integration flex-wrap" id="filter-product-integration">
                        <?php foreach ($all_other_main_product as $all): ?>
                            <div class="ditle-product-integration">
                                <img src="<?php echo $all->url_image ?>">
                                <p class="name-product-integration"><?php echo $all->product_name ?></p>
                                <p class="stock-integration"><?php echo $all->stock == 1 ? 'موجود' : 'ناموجود' ?></p>
                                <p class="category-integration"><?php echo $all->product_type ?></p>
                                <p class="seler-integration"><?php echo $all->count ?> فروشنده</p>
                                <div class="d-flex justify-content-between">

                                    <div class="content-integration">

                                        <a href="#"
                                           class="btn-integration tooltip-integration top-integration button-3">
                                        <span>
                                             <form method="post" class="m-0">
                                                 <input type="hidden" name="user-id-integration"
                                                        value="<?php echo $user_id ?>">
                                                            <input type="hidden" name="product-integration-id"
                                                                   value="<?php echo $all->product_id ?>">
                                                            <input type="hidden" name="product-main-id"
                                                                   value="<?php echo $result_main_product[0]->product_id ?>">
                                                <button style="background: transparent;border: none;"
                                                        name="add-integration">
                                                <svg stroke="currentColor" fill="none" stroke-width="2"
                                                     viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"
                                                     class="_vyw91x"
                                                     style="vertical-align: middle; fill: none;width: 40px !important;height: 40px !important;padding: 8px;"
                                                     height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><rect
                                                            x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line
                                                            x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12"
                                                                                                        x2="16"
                                                                                                        y2="12"></line></svg>
                                    </button>
                                            </form>
                                        </span>
                                            <span class="tooltip-content-integration">
                                            اضافه شدن به سبد ادغام
                                        </span>
                                        </a>


                                        <div id="popup<?php echo $all->product_id ?>" class="overlay-3">
                                            <div class="popup-3">
                                                <div class="container">
                                                    <div class="row">
                                                        <div class="col-md-6"><a class="close-3" href="#">&times;</a>
                                                        </div>
                                                        <form method="post" class="w-50 d-flex gap-3">
                                                            <input type="hidden" name="user-id-integration"
                                                                   value="<?php echo $user_id ?>">
                                                            <input type="hidden" name="product-integration-id"
                                                                   value="<?php echo $all->product_id ?>">
                                                            <input type="hidden" name="product-main-id"
                                                                   value="<?php echo $result_main_product[0]->product_id ?>">
                                                            <div class="col-md-6">
                                                                <button class="btn btn-secondary">نمایش و ادغام محصول
                                                                    بعدی
                                                                </button>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <input type="submit" name="add-integration"
                                                                       class="btn btn-primary"
                                                                       value="افزودن به سبد ادغام">
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <hr>
                                                </div>
                                                <div class="content-3">
                                                    <div class="d-flex gap-5">
                                                        <div class="w-50 text-center">
                                                            <img src="<?php echo $result_main_product[0]->url_image ?>">
                                                            <p class="comparison-details"><?php echo $result_main_product[0]->product_name ?> </p>
                                                            <h5 class="general-specifications">مشخصات کلی</h5>
                                                            <?php foreach ($result_torob_product_descriptions as $item): ?>
                                                                <p class="title_item"
                                                                   style="text-align: right;"><?php echo $item->title ?></p>
                                                                <p class="value_item"
                                                                   style="text-align: right;"><?php echo $item->value ?></p>
                                                            <?php endforeach; ?>
                                                        </div>
                                                        <div class="w-50 text-center"
                                                             id="content-integration2-<?php echo $all->product_id ?>"></div>
                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="content-integration">
                                        <div class="box-3">
                                            <a href="#popup<?php echo $all->product_id ?>"
                                               class="btn-integration tooltip-integration top-integration button-3">
                                        <span>
                                                    <input id="admin_url_2" type="hidden"
                                                           value="<?php echo admin_url('admin-ajax.php') ?>"/>
                                                 <input id="user_id_2" type="hidden" name="user_id"
                                                        value="<?php echo $user_id ?>"/>
                                            <button style="background: transparent;border: none; transform: rotate(90deg);"
                                                    name="integration2"
                                                    onclick="integration2('<?php echo $all->product_id ?>')">
                                                <svg stroke="currentColor" fill="none" stroke-width="2"
                                                     viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"
                                                     class="_vyw91x _j26h42"
                                                     style="vertical-align: middle; fill: none;width: 40px !important;height: 40px !important;padding: 8px;"
                                                     height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="12" cy="6" r="2"></circle>
                                            <line x1="5" y1="12" x2="19" y2="12"></line>
                                            <circle cx="12" cy="18" r="2"></circle>
                                        </svg>
                                    </button>
                                        </span>
                                                <span class="tooltip-content-integration">
                                            اضافه شدن به سبد ادغام
                                        </span>
                                            </a>
                                        </div>

                                        <div id="popup3" class="overlay-3">
                                            <div class="popup-3">
                                                <h2>Here i am</h2>
                                                <a class="close-3" href="#">&times;</a>
                                                <div class="content-3">
                                                    Thank to pop me out of that button, but now i'm done so you can
                                                    close
                                                    this window.
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div id="News" class="tabcontent-sellers">
                <div style="border-top: solid #4a90e2;margin-top: 3px;">
                    ljhgljhgljhgljhg
                </div>
            </div>
            <div id="Contact" class="tabcontent-sellers">
                <div style="border-top: solid #4a90e2;margin-top: 3px;">
                    <div class="d-flex gap-3 dingle-pro-integration">
                        <?php foreach ($other_main_product as $main) : ?>
                            <div class="ditle-product-integration">
                                <img src="<?php echo $main->url_image ?>">
                                <p class="name-product-integration"><?php echo $main->product_name ?></p>
                                <p class="stock-integration"><?php echo $main->stock == 1 ? 'موجود' : 'ناموجود' ?></p>
                                <p class="category-integration"><?php echo $main->product_type ?></p>
                                <p class="seler-integration"><?php echo $main->count ?> فروشنده</p>

                                <div class="d-flex justify-content-between">

                                    <div class="content-integration">

                                        <a href="#"
                                           class="btn-integration tooltip-integration top-integration button-3">
                                        <span>
                                            <form method="post" class="m-0">
                                                 <input type="hidden" name="user-id-integration"
                                                        value="<?php echo $user_id ?>">
                                                            <input type="hidden" name="product-integration-id"
                                                                   value="<?php echo $main->product_id ?>">
                                                            <input type="hidden" name="product-main-id"
                                                                   value="<?php echo $result_main_product[0]->product_id ?>">
                                                <button style="background: transparent;border: none;"
                                                        name="add-integration">
                                                <svg stroke="currentColor" fill="none" stroke-width="2"
                                                     viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"
                                                     class="_vyw91x"
                                                     style="vertical-align: middle; fill: none;width: 40px !important;height: 40px !important;padding: 8px;"
                                                     height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><rect
                                                            x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line
                                                            x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12"
                                                                                                        x2="16"
                                                                                                        y2="12"></line></svg>
                                    </button>
                                            </form>

                                        </span>
                                            <span class="tooltip-content-integration">
                                            اضافه شدن به سبد ادغام
                                        </span>
                                        </a>


                                        <div id="popup<?php echo $main->product_id . '-contact' ?>" class="overlay-3">
                                            <div class="popup-3">
                                                <div class="container">
                                                    <div class="row">
                                                        <div class="col-md-6"><a class="close-3" href="#">&times;</a>
                                                        </div>
                                                        <form method="post" class="w-50 d-flex gap-3">
                                                            <input type="hidden" name="user-id-integration"
                                                                   value="<?php echo $user_id ?>">
                                                            <input type="hidden" name="product-integration-id"
                                                                   value="<?php echo $main->product_id ?>">
                                                            <input type="hidden" name="product-main-id"
                                                                   value="<?php echo $result_main_product[0]->product_id ?>">
                                                            <div class="col-md-6">
                                                                <button class="btn btn-secondary">نمایش و ادغام محصول
                                                                    بعدی
                                                                </button>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <input type="submit" name="add-integration"
                                                                       class="btn btn-primary"
                                                                       value="افزودن به سبد ادغام">
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <hr>
                                                </div>
                                                <div class="content-3">
                                                    <div class="d-flex gap-5">
                                                        <div class="w-50 text-center">
                                                            <img src="<?php echo $result_main_product[0]->url_image ?>">
                                                            <p class="comparison-details"> <?php echo $result_main_product[0]->product_name ?></p>
                                                            <h5 class="general-specifications">مشخصات کلی</h5>
                                                            <?php foreach ($result_torob_product_descriptions as $item): ?>
                                                                <p class="title_item"
                                                                   style="text-align: right;"><?php echo $item->title ?></p>
                                                                <p class="value_item"
                                                                   style="text-align: right;"><?php echo $item->value ?></p>
                                                            <?php endforeach; ?>
                                                        </div>
                                                        <div class="w-50 text-center"
                                                             id="content-integration-<?php echo $main->product_id ?>"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="content-integration">
                                        <div class="box-3">
                                            <a href="#popup<?php echo $main->product_id . '-contact' ?>"
                                               class="btn-integration tooltip-integration top-integration button-3">
                                        <span>
                                            <input id="admin_url_integration" type="hidden"
                                                   value="<?php echo admin_url('admin-ajax.php') ?>"/>
                                        <input id="user_id_integration" type="hidden" name="user_id_integration"
                                               value="<?php echo $user_id ?>"/>
                                            <button style="background: transparent;border: none; transform: rotate(90deg);"
                                                    name="integration"
                                                    onclick="integration('<?php echo $main->product_id ?>')">
                                                <svg stroke="currentColor" fill="none" stroke-width="2"
                                                     viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"
                                                     class="_vyw91x _j26h42"
                                                     style="vertical-align: middle; fill: none;width: 40px !important;height: 40px !important;padding: 8px;"
                                                     height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="12" cy="6" r="2"></circle>
                                            <line x1="5" y1="12" x2="19" y2="12"></line>
                                            <circle cx="12" cy="18" r="2"></circle>
                                        </svg>
                                    </button>
                                        </span>
                                                <span class="tooltip-content-integration">
                                            اضافه شدن به سبد ادغام
                                        </span>
                                            </a>
                                        </div>

                                        <div id="popup5" class="overlay-3">
                                            <div class="popup-3">
                                                <h2>Here i am</h2>
                                                <a class="close-3" href="#">&times;</a>
                                                <div class="content-3">
                                                    Thank to pop me out of that button, but now i'm done so you can
                                                    close
                                                    this window.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?php echo get_template_directory_uri() . '/js/bootstrap.js' ?>"></script>
    <script src="<?php echo get_template_directory_uri() . '/js/jquery.min.js' ?>"></script>

    <script>
        jQuery(document).ready(function ($) {
            $("#hide").click(function () {
                $(".hide-text").hide();
            });
            $("#hide2").click(function () {
                $(".hide-text2").hide();
            });
        });

    </script>
<?php else: ?>
    <div class="main-user-torob">
        <div class="row custom-header">
            <div class="col-md-1 d-flex p-t-10">
                <a href="<?php echo get_home_url() ?>" style="display: inherit;">

                    <img style="width: 48px;height: 48px;"
                         src="<?php echo get_template_directory_uri() . '/images/logo.png' ?>">
                    <h2 class="h1-torob">ترب</h2>
                </a>
            </div>
            <div class="col-md-7 mt-3">
                <?php echo do_shortcode("[wd_asp id=2]"); ?>
            </div>
        </div>
        <?php get_header(); ?>
    </div>
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
</body>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function () {
        $('.js-example-basic-single').select2();
        $('.js-example-basic-multiple').select2();
        $('#show').click(function () {
            $('.sellers').toggle("slide");
        });
        $('#show-discription').click(function () {
            $('.sellers-discription').toggle("slide");
        });

        $('.input-seller').change(function () {
            if ($(this).is(":checked")) {
                $(this).addClass("input-checked");
            } else {
                $(this).removeClass("input-checked");
            }
            var numItems = $('.input-checked').length
            if (numItems > 0) {
                document.getElementById('num-seller').innerText = numItems + ' درخواست جداسازی فروشنده';
            } else {
                document.getElementById('num-seller').innerText = 'درخواست جداسازی فروشنده';
            }
            if (numItems) {
                $('#myBtn').removeAttr('disabled');
            } else {
                $('#myBtn').attr('disabled', 'disabled');
            }
        });
    });

    function openPage(pageName, elmnt, color) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent-sellers");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }

        document.getElementById(pageName).style.display = "block";
    }


    // selecting the element
    let button1 = document.getElementById('tablink1');
    let button2 = document.getElementById('tablink2');
    let button3 = document.getElementById('defaultOpen');

    // Add class to the element
    button1.addEventListener('click', function () {
        button1.classList.add('active');
        button2.classList.remove('active');
        button3.classList.remove('active');
    });
    button2.addEventListener('click', function () {
        button1.classList.remove('active');
        button2.classList.add('active');
        button3.classList.remove('active');

    });
    button3.addEventListener('click', function () {
        button1.classList.remove('active');
        button2.classList.remove('active');
        button3.classList.add('active');
    });
    // Get the element with id="defaultOpen" and click on it
    document.getElementById("defaultOpen").click();
</script>
<script>
    // Get the modal
    var modal = document.getElementById("myModal");

    // Get the button that opens the modal
    var btn = document.getElementById("myBtn");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks the button, open the modal
    btn.onclick = function () {
        submit_data()
        modal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function () {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    function submit_data() {
        jQuery(document).ready(function ($) {


            var array = []
            var checkboxes = document.querySelectorAll('input[name="input-seller"]:checked')

            for (var i = 0; i < checkboxes.length; i++) {
                array.push(checkboxes[i].value)
            }

            var host = document.getElementById("admin_url").value;

            $.ajax({
                method: 'POST',
                url: host,
                data: {
                    'action': 'submit_data',
                    'products': array,
                }
            }).done(function (res) {
                var html = ""
                res.products.map(p => {
                    html += `<div class="content-2">
                            <input type="hidden" name="products[]" value="${p.id}">
                            <div class="row">
                                        <div class="col-md-3">
                                            <img src="${p.image_link && p.image_link.length ? p.image_link : window.location.origin + "/torob/wp-content/themes/torob/images/noimg.png"}"
                                                 style="width: 94px; height: 94px">
                                        </div>
                                        <div class="col-md-9">
                                            <p>${p.name}</p>
                                            <p>${p.price}</p>
                                        </div>
                                    </div>
                                </div>`
                })
                document.getElementById('products-ajax').innerHTML = html
            })
        })
    }

    function integration(id) {
        var host = document.getElementById("admin_url_integration").value;

        $.ajax({
            method: 'POST',
            url: host,
            data: {
                'action': 'integration',
                'id': id
            }
        }).done(function (res) {
            var html = `<img src="${res.product[0].url_image}">
                            <p class="comparison-details">
                               ${res.product[0].product_name}
                            </p>
                            <h5 class="general-specifications">مشخصات کلی</h5>`
            res.descriptions.map(d => {
                html += `<p class="title_item" style="text-align: right;"> ${d.title}</p>
                    <p class="value_item" style="text-align: right; text-align: justify">${d.value}</p>`
            })
            document.getElementById('content-integration-' + id).innerHTML = html
        })
    }

    //
    function integration2(id) {
        var host = document.getElementById("admin_url_2").value;

        $.ajax({
            method: 'POST',
            url: host,
            data: {
                'action': 'integration2',
                'id': id
            }
        }).done(function (res) {
            var html = `<img src="${res.product[0].url_image}">
                            <p class="comparison-details">
                               ${res.product[0].product_name}
                            </p>
                            <h5 class="general-specifications">مشخصات کلی</h5>`
            res.descriptions.map(d => {
                html += `<p class="title_item" style="text-align: right;"> ${d.title}</p>
                    <p class="value_item" style="text-align: right; text-align: justify">${d.value}</p>`
            })
            document.getElementById('content-integration2-' + id).innerHTML = html
        })
    }

    //
    function filter_price() {
        var host = document.getElementById("admin_url_filter").value;
        var categoryStatus = document.getElementById("category-status-integration").value;
        var accessStatus = document.getElementById("access-status-integration").value;
        var inventoryStatus = document.getElementById("inventory-status-integration").value;
        var integrationStatus = document.getElementById("integration-status").value;
        var term = $('#term-integration').val();
        var integrationName = document.getElementById("integration-name-product").value;
        $.ajax({
            method: 'POST',
            url: host,
            data: {
                'action': 'filter_price',
                'category-status-integration': categoryStatus,
                'access-status-integration': accessStatus,
                'inventory-status-integration': inventoryStatus,
                'integration-status': integrationStatus,
                'term-integration': term,
                'integration-name-product': integrationName,

            }
        }).done(function (res) {
            var html = ""
            console.log(res.products)
            res.products.map(p => {
                html += `<div class="ditle-product-integration">
                                <img src="${p.url_image}">
                                <p class="name-product-integration">${p.product_name}</p>
                                <p class="stock-integration">${p.stock == 1 ? 'موجود' : 'ناموجود'}</p>
                                <p class="category-integration">${p.product_type}</p>
                                <p class="seler-integration">${p.count} فروشنده</p>
                                <div class="d-flex justify-content-between">

                                    <div class="content-integration">

                                        <a href="#"
                                           class="btn-integration tooltip-integration top-integration button-3">
                                        <span>
                                             <form method="post" class="m-0">
                                                 <input type="hidden" name="user-id-integration"
                                                        value="<?php echo $user_id ?>">
                                                            <input type="hidden" name="product-integration-id"
                                                                   value=${p.product_id}">
                                                            <input type="hidden" name="product-main-id"
                                                                   value="<?php echo $result_main_product[0]->product_id ?>">
                                                <button style="background: transparent;border: none;" name="add-integration">
                                                <svg stroke="currentColor" fill="none" stroke-width="2"
                                                     viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"
                                                     class="_vyw91x"
                                                     style="vertical-align: middle; fill: none;width: 40px !important;height: 40px !important;padding: 8px;"
                                                     height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><rect
                                                            x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line
                                                            x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12"
                                                                                                        x2="16"
                                                                                                        y2="12"></line></svg>
                                    </button>
                                            </form>
                                        </span>
                                            <span class="tooltip-content-integration">
                                            اضافه شدن به سبد ادغام
                                        </span>
                                        </a>


                                        <div id="popup${p.product_id}" class="overlay-3">
                                            <div class="popup-3">
                                                <div class="container">
                                                    <div class="row">
                                                        <div class="col-md-6"><a class="close-3" href="#">&times;</a>
                                                        </div>
                                                        <form method="post" class="w-50 d-flex gap-3">
                                                            <input type="hidden" name="user-id-integration"
                                                                   value="<?php echo $user_id ?>">
                                                            <input type="hidden" name="product-integration-id"
                                                                   value="${p.product_id}">
                                                            <input type="hidden" name="product-main-id"
                                                                   value="<?php echo $result_main_product[0]->product_id ?>">
                                                            <div class="col-md-6">
                                                                <button class="btn btn-secondary">نمایش و ادغام محصول
                                                                    بعدی
                                                                </button>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <input type="submit" name="add-integration"
                                                                       class="btn btn-primary"
                                                                       value="افزودن به سبد ادغام">
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <hr>
                                                </div>
                                                <div class="content-3">
                                                    <div class="d-flex gap-5">
                                                        <div class="w-50 text-center">
                                                            <img src="<?php echo $result_main_product[0]->url_image ?>">
                                                            <p class="comparison-details"><?php echo $result_main_product[0]->product_name ?> </p>
                                                            <h5 class="general-specifications">مشخصات کلی</h5>
                                                            <?php foreach ($result_torob_product_descriptions as $item): ?>
                                                                <p class="title_item"
                                                                   style="text-align: right;"><?php echo $item->title ?></p>
                                                                <p class="value_item"
                                                                   style="text-align: right;"><?php echo $item->value ?></p>
                                                            <?php endforeach; ?>
                                                        </div>
                                                        <div class="w-50 text-center"
                                                             id="content-integration2-${p.product_id}"></div>
                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="content-integration">
                                        <div class="box-3">
                                            <a href="#popup${p.product_id}"
                                               class="btn-integration tooltip-integration top-integration button-3">
                                        <span>
                                                    <input id="admin_url_2" type="hidden"
                                                           value="<?php echo admin_url('admin-ajax.php') ?>"/>
                                                 <input id="user_id_2" type="hidden" name="user_id"
                                                        value="<?php echo $user_id ?>"/>
                                            <button style="background: transparent;border: none; transform: rotate(90deg);"
                                                    name="integration2"
                                                    onclick="integration2('${p.product_id}')">
                                                <svg stroke="currentColor" fill="none" stroke-width="2"
                                                     viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"
                                                     class="_vyw91x _j26h42"
                                                     style="vertical-align: middle; fill: none;width: 40px !important;height: 40px !important;padding: 8px;"
                                                     height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="12" cy="6" r="2"></circle>
                                            <line x1="5" y1="12" x2="19" y2="12"></line>
                                            <circle cx="12" cy="18" r="2"></circle>
                                        </svg>
                                    </button>
                                        </span>
                                                <span class="tooltip-content-integration">
                                            اضافه شدن به سبد ادغام
                                        </span>
                                            </a>
                                        </div>

                                        <div id="popup3" class="overlay-3">
                                            <div class="popup-3">
                                                <h2>Here i am</h2>
                                                <a class="close-3" href="#">&times;</a>
                                                <div class="content-3">
                                                    Thank to pop me out of that button, but now i'm done so you can
                                                    close
                                                    this window.
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>`
            })
            document.getElementById('filter-product-integration').innerHTML = html
        })
    }

    function filter_sort() {
        var host = document.getElementById("admin_url_filter_sort").value;
        var sort = document.getElementById("sort").value;
        var paginationSort = document.getElementById("pagination-sort").value;
        console.log(paginationSort)
        $.ajax({
            method: 'POST',
            url: host,
            data: {
                'action': 'filter_sort',
                'sort': sort,
                'pagination-sort': paginationSort,
            }
        }).done(function (res) {
            var html = ""
            console.table(res)
            res.orderProduct.map(p => {
                html += `<div class="ditle-product-integration">
                                <img src="${p.url_image}">
                                <p class="name-product-integration">${p.product_name}</p>
                                <p class="stock-integration">${p.stock == 1 ? 'موجود' : 'ناموجود'}</p>
                                <p class="category-integration">${p.product_type}</p>
                                <p class="seler-integration">${p.count} فروشنده</p>
                                <div class="d-flex justify-content-between">

                                    <div class="content-integration">

                                        <a href="#"
                                           class="btn-integration tooltip-integration top-integration button-3">
                                        <span>
                                             <form method="post" class="m-0">
                                                 <input type="hidden" name="user-id-integration"
                                                        value="<?php echo $user_id ?>">
                                                            <input type="hidden" name="product-integration-id"
                                                                   value=${p.product_id}">
                                                            <input type="hidden" name="product-main-id"
                                                                   value="<?php echo $result_main_product[0]->product_id ?>">
                                                <button style="background: transparent;border: none;" name="add-integration">
                                                <svg stroke="currentColor" fill="none" stroke-width="2"
                                                     viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"
                                                     class="_vyw91x"
                                                     style="vertical-align: middle; fill: none;width: 40px !important;height: 40px !important;padding: 8px;"
                                                     height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><rect
                                                            x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line
                                                            x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12"
                                                                                                        x2="16"
                                                                                                        y2="12"></line></svg>
                                    </button>
                                            </form>
                                        </span>
                                            <span class="tooltip-content-integration">
                                            اضافه شدن به سبد ادغام
                                        </span>
                                        </a>


                                        <div id="popup${p.product_id}" class="overlay-3">
                                            <div class="popup-3">
                                                <div class="container">
                                                    <div class="row">
                                                        <div class="col-md-6"><a class="close-3" href="#">&times;</a>
                                                        </div>
                                                        <form method="post" class="w-50 d-flex gap-3">
                                                            <input type="hidden" name="user-id-integration"
                                                                   value="<?php echo $user_id ?>">
                                                            <input type="hidden" name="product-integration-id"
                                                                   value="${p.product_id}">
                                                            <input type="hidden" name="product-main-id"
                                                                   value="<?php echo $result_main_product[0]->product_id ?>">
                                                            <div class="col-md-6">
                                                                <button class="btn btn-secondary">نمایش و ادغام محصول
                                                                    بعدی
                                                                </button>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <input type="submit" name="add-integration"
                                                                       class="btn btn-primary"
                                                                       value="افزودن به سبد ادغام">
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <hr>
                                                </div>
                                                <div class="content-3">
                                                    <div class="d-flex gap-5">
                                                        <div class="w-50 text-center">
                                                            <img src="<?php echo $result_main_product[0]->url_image ?>">
                                                            <p class="comparison-details"><?php echo $result_main_product[0]->product_name ?> </p>
                                                            <h5 class="general-specifications">مشخصات کلی</h5>
                                                            <?php foreach ($result_torob_product_descriptions as $item): ?>
                                                                <p class="title_item"
                                                                   style="text-align: right;"><?php echo $item->title ?></p>
                                                                <p class="value_item"
                                                                   style="text-align: right;"><?php echo $item->value ?></p>
                                                            <?php endforeach; ?>
                                                        </div>
                                                        <div class="w-50 text-center"
                                                             id="content-integration2-${p.product_id}"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="content-integration">
                                        <div class="box-3">
                                            <a href="#popup${p.product_id}"
                                               class="btn-integration tooltip-integration top-integration button-3">
                                        <span>
                                                    <input id="admin_url_2" type="hidden"
                                                           value="<?php echo admin_url('admin-ajax.php') ?>"/>
                                                 <input id="user_id_2" type="hidden" name="user_id"
                                                        value="<?php echo $user_id ?>"/>
                                            <button style="background: transparent;border: none; transform: rotate(90deg);"
                                                    name="integration2"
                                                    onclick="integration2('${p.product_id}')">
                                                <svg stroke="currentColor" fill="none" stroke-width="2"
                                                     viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"
                                                     class="_vyw91x _j26h42"
                                                     style="vertical-align: middle; fill: none;width: 40px !important;height: 40px !important;padding: 8px;"
                                                     height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="12" cy="6" r="2"></circle>
                                            <line x1="5" y1="12" x2="19" y2="12"></line>
                                            <circle cx="12" cy="18" r="2"></circle>
                                        </svg>
                                    </button>
                                        </span>
                                                <span class="tooltip-content-integration">
                                            اضافه شدن به سبد ادغام
                                        </span>
                                            </a>
                                        </div>

                                        <div id="popup3" class="overlay-3">
                                            <div class="popup-3">
                                                <h2>Here i am</h2>
                                                <a class="close-3" href="#">&times;</a>
                                                <div class="content-3">
                                                    Thank to pop me out of that button, but now i'm done so you can
                                                    close
                                                    this window.
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>`
            })
            document.getElementById('filter-product-integration').innerHTML = html
        })
    }
</script>
</html>

