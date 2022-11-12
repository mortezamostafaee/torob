<?php
require_once('elementor/torob-elementor.php');
function add_theme_scripts()
{
    wp_enqueue_style('front', get_template_directory_uri() . '/css/front.css', array(), false, 'all');
    wp_enqueue_style('owl-carousel', get_template_directory_uri() . '/css/owl.carousel.min.css', array(), false, 'all');
    wp_enqueue_style('owl-theme-default', get_template_directory_uri() . '/css/owl.theme.default.min.css', array(), false, 'all');
    wp_enqueue_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.css', array(), false, 'all');
    wp_enqueue_style('style', get_stylesheet_uri(), array(), false, 'all');
    wp_enqueue_script('main-js', get_template_directory_uri() . '/js/main-js.js', array('jquery'), false, true);
    wp_enqueue_script('owl-carousel-js', get_template_directory_uri() . '/js/owl.carousel.min.js', array('jquery'), false, true);
    wp_enqueue_script('bootstrap-js', get_template_directory_uri() . '/js/bootstrap.js', array('jquery'), false, true);

}

function my_theme()
{
    add_theme_support('title-tag');
    add_theme_support('automatic-feed-links');
}

add_action('after_setup_theme', 'my_theme');

add_action('wp_enqueue_scripts', 'add_theme_scripts');
function register_my_menus()
{
    register_nav_menus(
        array(
            'main-menu' => __('منوی اصلی'),
            'footer-left-menu' => __('منوی پایین چپ'),
            'footer-right-menu' => __('منوی پایین راست'),
            'footer-user-panel-1' => __('منوی فوتر پنل کاربری اول'),
            'footer-user-panel-2' => __('منوی فوتر پنل کاربری دوم')
        )
    );
}

add_action('init', 'register_my_menus');


function post_type_torob()
{
    $labels = array(
        'name' => __('ترب'),
        'singular_name' => __('ترب'),
        'menu_name' => __('ترب'),
        'name_admin_bar' => __('ترب'),
        'add_new' => __(' افزودن جدید'),
        'add_new_item' => __('ترب'),
        'new_item' => __('پست جدید'),
        'edit_item' => __('ویرایش پست'),
        'view_item' => __('مشاهده پست'),
        'all_items' => __('همه'),
        'search_items' => __('جستجو در بین فروشگاه ها'),
        'parent_item_colon' => __('مادر'),
        'not_found' => __('مطلب یافت نشد'),
        'not_found_in_trash' => __('مطلب در زباله دان یافت نشد')
    );
    $args = array(
        'labels' => $labels,
        'description' => __('Description.', 'your-plugin-textdomain'),
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,

        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => null,
        'taxonomies' => array('post_tag'),
        'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments')
    );
    register_post_type('torob', $args);
}

add_action('init', 'post_type_torob');


// add sub menu company custom posttype(torob)

add_action('admin_menu', 'add_tutorial_cpt_submenu_example');


function add_tutorial_cpt_submenu_example()
{

    add_submenu_page(
        'edit.php?post_type=torob', //$parent_slug
        'لیست محصولات',  //$page_title
        'لیست محصولات',        //$menu_title
        'administrator',           //$capability
        'products',//$menu_slug
        'subpage_poroduct_render_page'//$function
    );

    add_submenu_page(
        'edit.php?post_type=torob', //$parent_slug
        'اضافه کردن محصول مادر',  //$page_title
        'اضافه کردن محصول مادر',        //$menu_title
        'administrator',           //$capability
        'insert_poroduct',//$menu_slug
        'subpage_insert_poroduct_render_page'//$function
    );

    add_submenu_page(
        'edit.php?post_type=torob', //$parent_slug
        'لیست محصولات مادر',  //$page_title
        'لیست محصولات مادر',        //$menu_title
        'administrator',           //$capability
        'main-product',//$menu_slug
        'subpage_main_poroduct_render_page'//$function
    );
    add_submenu_page(
        'edit.php?post_type=torob', //$parent_slug
        'ویرایش محصول',  //$page_title
        'ویرایش محصول',
        'administrator',           //$capability
        'edit-main-product',//$menu_slug
        'subpage_edit_main_poroduct_render_page'//$function

    );
    add_submenu_page(
        'edit.php?post_type=torob', //$parent_slug
        'ویرایش محصول فروشگاه',  //$page_title
        'ویرایش محصول فروشگاه',
        'administrator',           //$capability
        'edit-product',//$menu_slug
        'subpage_edit_poroduct_render_page'//$function

    );
    add_submenu_page(
        'edit.php?post_type=torob', //$parent_slug
        'مزایده',  //$page_title
        'مزایده',        //$menu_title
        'administrator',           //$capability
        'auction',//$menu_slug
        'subpage_auction_render_page',//$function
    );
    add_submenu_page(
        'edit.php?post_type=torob', //$parent_slug
        'بنر های انتخابی کاربر برنده شده در مزایده',  //$page_title
        'بنرهای انتخابی کاربر',        //$menu_title
        'administrator',           //$capability
        'user-banner',//$menu_slug
        'subpage_banner_render_page'//$function
    );

    add_submenu_page(
        'edit.php?post_type=torob', //$parent_slug
        'لیست محصولات پیشنهاد شده برای تغییر دسته بندی',  //$page_title
        'محصولات پیشنهادی',        //$menu_title
        'administrator',           //$capability
        'suggested-product',//$menu_slug
        'subpage_suggested_product_page',//$function
    );

    add_submenu_page(
        'edit.php?post_type=torob', //$parent_slug
        'ویرایش محصول پیشنهادی',  //$page_title
        'ویرایش محصول پیشنهادی',
        'administrator',           //$capability
        'editsuggested',//$menu_slug
        'subpage_edit_suggested_product_page'//$function

    );
    add_submenu_page(
        'edit.php?post_type=torob', //$parent_slug
        'محصولات پیشنهاد شده برای ادغام',  //$page_title
        'محصولات پیشنهاد شده برای ادغام',
        'administrator',           //$capability
        'integration',//$menu_slug
        'subpage_integration'//$function

    );

    add_submenu_page(
        'edit.php?post_type=torob', //$parent_slug
        'محصولات پیشنهاد شده برای تغییر دسته بندی',  //$page_title
        'محصولات پیشنهاد شده برای تغییر دسته بندی',
        'administrator',           //$capability
        'change_category',//$menu_slug
        'change_category'//$function

    );

    add_submenu_page(
        'edit.php?post_type=torob', //$parent_slug
        'پیگری سفارشات',  //$page_title
        'پیگری سفارشات',
        'administrator',           //$capability
        'track_orders',//$menu_slug
        'track_orders'//$function

    );
    add_submenu_page(
        'edit.php?post_type=torob', //$parent_slug
        'بررسی پیگیری سفارش',  //$page_title
        'بررسی پیگیری سفارش',
        'administrator',           //$capability
        'edit_track_order',//$menu_slug
        'subpage_edit_track_orders_page'//$function

    );

}

function subpage_edit_track_orders_page()
{
    require_once WP_CONTENT_DIR . '/themes/torob/edit_track_orders.php';
}
function track_orders()
{
    require_once WP_CONTENT_DIR . '/themes/torob/track_orders.php';
}
function change_category()
{
    require_once WP_CONTENT_DIR . '/themes/torob/change_category.php';
}

function subpage_integration()
{
    require_once WP_CONTENT_DIR . '/themes/torob/integration.php';
}

function subpage_poroduct_render_page()
{
    require_once WP_CONTENT_DIR . '/themes/torob/products.php';
}

function subpage_suggested_product_page()
{

    require_once WP_CONTENT_DIR . '/themes/torob/suggested-product.php';
}

function subpage_edit_suggested_product_page()
{

    require_once WP_CONTENT_DIR . '/themes/torob/editsuggested.php';
}

function subpage_banner_render_page()
{

    require_once WP_CONTENT_DIR . '/themes/torob/user-banner.php';
}

function subpage_insert_poroduct_render_page()
{

    require_once WP_CONTENT_DIR . '/themes/torob/insert-products.php';
}

function subpage_main_poroduct_render_page()
{

    require_once WP_CONTENT_DIR . '/themes/torob/main-products.php';
}

function subpage_edit_main_poroduct_render_page()
{

    require_once WP_CONTENT_DIR . '/themes/torob/edit-main-product.php';
}

function subpage_edit_poroduct_render_page()
{

    require_once WP_CONTENT_DIR . '/themes/torob/edit-product.php';
}

function subpage_auction_render_page()
{

    require_once WP_CONTENT_DIR . '/themes/torob/auction-torob_proposal.php';
}


// اضافه کردن تاکسونومی برای پست تایپ ترب
function create_taxonomies_for_torob()
{
    $labels = array(
        'name' => _x('دسته بندی', 'دسته بندی'),
        'singular_name' => _x('دسته بندی پست ها ', 'دسته بندی'),
        'search_items' => __('جستجویه دسته'),
        'all_items' => __('تمام دسته ها'),
        'parent_item' => __('زیر دسته'),
        'parent_item_colon' => __('Parent Genre:'),
        'edit_item' => __('ویرایش دسته'),
        'update_item' => __('بروزرسانی دسته'),
        'add_new_item' => __('افزودن دسته جدید'),
        'new_item_name' => __('نام جدید دسته'),
        'menu_name' => __('دسته بندی'),
    );

    $ar = array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
    );

    register_taxonomy('cat_torob', 'torob', $ar);
}

add_action('init', 'create_taxonomies_for_torob');

/***************************/
add_action('init', 'create_taxonomies_for_torob');
function custom_shortcode_func()
{
    ob_start();
    $current_user = wp_get_current_user();
    echo $current_user->display_name;
    $output = ob_get_clean();
    return $output;
}

add_shortcode('current_user', 'custom_shortcode_func');

function get_user_id()
{
    ob_start();
    $current_user = wp_get_current_user();
    echo $current_user->ID;
    $output = ob_get_clean();
    return $output;
}

/* strart create  table*/

add_action("after_switch_theme", "torob_create_extra_table");
function torob_create_extra_table()
{
    global $wpdb;
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    $table_name = $wpdb->prefix . "user_history";
    $torob_product = $wpdb->prefix . "torob_product";
    $torob_separation_seller = $wpdb->prefix . "torob_separation_seller";
    $torob_product_categories = $wpdb->prefix . "torob_product_categories";
    $torob_product_descriptions = $wpdb->prefix . "torob_product_descriptions";
    $torob_main_product = $wpdb->prefix . "torob_main_product";
    $torob_wishlist = $wpdb->prefix . "torob_wishlist";
    $torob_proposal = $wpdb->prefix . "torob_proposal";
    $torob_banner = $wpdb->prefix . "torob_banner";
    $torob_user_selected_banners = $wpdb->prefix . "torob_user_selected_banners";
    $torob_integration = $wpdb->prefix . "torob_integration";
    $torob_change_category_mine_product_intgration = $wpdb->prefix . "torob_change_category_mine_product_intgration";
    $torob_feedback = $wpdb->prefix . "torob_feedback";

    $sql_torob_feedback = "CREATE TABLE $wpdb->dbname.$torob_feedback (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id_feedback` bigint(20) NOT NULL,
  `shop` varchar(64) NOT NULL,
  `complaint_form` varchar(255) NOT NULL,
  `price` varchar(64) NOT NULL,
  `noanswers` varchar(255) NOT NULL,
  `ordercode` bigint(20) NOT NULL,
  `date` varchar(11) NOT NULL,
  `buyer_name` varchar(255) NOT NULL,
  `order_tracking` text NOT NULL,
  `link` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8";
    $sql_change_category_mine_product_intgration = "CREATE TABLE $wpdb->dbname.$torob_change_category_mine_product_intgration (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(255) NOT NULL,
  `product_id` bigint(20) NOT NULL,
  `category` varchar(255) NOT NULL,
  `current_category` varchar(255) NOT NULL,
  `status_update_product_type` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8";


    $sql_user_history = "CREATE TABLE $wpdb->dbname.$table_name  (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `product_id` int(16) NOT NULL,
  `user_id` int(16) NOT NULL,
  `date` time NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8";

    $sql_torob_integration = "CREATE TABLE $wpdb->dbname.$torob_integration  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `product_integration_id` bigint(20) NOT NULL,
  `product_main_id` bigint(20) NOT NULL,
  `time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `integration_status` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8";

    $sql_separation_seller = "CREATE TABLE $wpdb->dbname.$torob_separation_seller (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `current_category` varchar(255) NOT NULL,
  `suggested_category` varchar(255) NOT NULL,
  `time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `shop_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8";

    $sql_user_selected_banners = "CREATE TABLE $wpdb->dbname.$torob_user_selected_banners  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) NOT NULL,
  `collection_banner` varchar(255) NOT NULL,
  `link_banner` varchar(255) NOT NULL,
  `utm_medium` varchar(255) NOT NULL,
  `utm_content` varchar(255) NOT NULL,
  `utm_campaign` varchar(255) NOT NULL,
  `utm_term` varchar(255) NOT NULL,
  `utm_source` varchar(255) NOT NULL,
  `site_banner` varchar(255) NOT NULL,
  `app_banner` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8";

    $sql_torob_product = "CREATE TABLE $wpdb->dbname.$torob_product (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `price` int(64) NOT NULL,
  `link` varchar(256) NOT NULL,
  `category` varchar(256) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `shopid` int(11) DEFAULT NULL,
  `productid` int(11) NOT NULL,
  `adv` int(2) NOT NULL DEFAULT '0',
  `stock` int(2) NOT NULL DEFAULT '1',
  `image_link` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8";

    $sql_torob_product_categories = "CREATE TABLE $wpdb->dbname.$torob_product_categories (
  `product_id` bigint(20) NOT NULL,
  `category` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8";

    $sql_torob_product_descriptions = "CREATE TABLE $wpdb->dbname.$torob_product_descriptions  (
  `product_id` bigint(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8";


    $sql_torob_main_product = "CREATE TABLE $wpdb->dbname.$torob_main_product  (
  `product_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(255) NOT NULL,
  `url_image` varchar(255) NOT NULL,
  `stock` int(2) NOT NULL DEFAULT '1',
  `brand` varchar(255) NOT NULL,
  `product_type` varchar(16) DEFAULT NULL,
  `time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `check` int(11) NOT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8";

    $sql_torob_wishlist = "CREATE TABLE $wpdb->dbname.$torob_wishlist  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user-id` bigint(20) NOT NULL,
  `product_id` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8";

    $sql_torob_proposal = "CREATE TABLE $wpdb->dbname.$torob_proposal  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) NOT NULL,
  `proposal` bigint(20) NOT NULL,
  `time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8";

    $sql_torob_banner = "CREATE TABLE $wpdb->dbname.$torob_banner  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) NOT NULL,
  `collection_banner` varchar(255) NOT NULL,
  `link_banner` varchar(255) NOT NULL,
  `utm_medium` varchar(255) NOT NULL,
  `utm_content` varchar(255) NOT NULL,
  `utm_campaign` varchar(255) NOT NULL,
  `utm_term` varchar(255) NOT NULL,
  `utm_source` varchar(255) NOT NULL,
  `banner_site_torob` varchar(255) NOT NULL,
  `banner_app_torob` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8";


    dbDelta($sql_user_history);
    dbDelta($sql_separation_seller);
    dbDelta($sql_torob_product);
    dbDelta($sql_torob_product_categories);
    dbDelta($sql_torob_product_descriptions);
    dbDelta($sql_torob_main_product);
    dbDelta($sql_torob_wishlist);
    dbDelta($sql_torob_proposal);
    dbDelta($sql_torob_banner);
    dbDelta($sql_user_selected_banners);
    dbDelta($sql_torob_integration);
    dbDelta($sql_change_category_mine_product_intgration);
    dbDelta($sql_torob_feedback);
}

/* end create table*/

add_shortcode('current_user_id', 'get_user_id');

/* start api */
include_once 'response.php';
/* end api */

add_action('init', 'init_theme_method');
function init_theme_method()
{
    add_thickbox();
}

/*start ajax*/

function markWishlist()
{
    global $wpdb;
    $torob_torob_wishlist = $wpdb->prefix . 'torob_wishlist';
    $user_id = $_POST['user_id'];
    $product_id = $_POST['product_id'];
    $like = false;

    $result = $wpdb->get_results("SELECT * FROM $torob_torob_wishlist where user_id = $user_id && product_id = $product_id");
    if (!$result) {
        $like = true;
        $wpdb->insert(
            $torob_torob_wishlist,
            array(
                'user_id' => $user_id,
                'product_id' => $product_id,
            )
        );
    } else {
        $id = $result[0]->id;
        $torob_torob_wishlist = $wpdb->prefix . 'torob_wishlist';
        $wpdb->delete($torob_torob_wishlist, array('id' => $id));
    }


    wp_send_json(['like' => $like]);
//    var_dump($query);

}

add_action('wp_ajax_markWishlist', 'markWishlist');
add_action('wp_ajax_nopriv_markWishlist', 'markWishlist');
/*end ajax*/


function handle_my_file_upload()
{

    // will return the attachment id of the image in the media library
    $attachment_id = media_handle_upload('my_file_field', 0);

    // test if upload succeeded
    if (is_wp_error($attachment_id)) {
        http_response_code(400);
        echo 'Failed to upload file.';
    } else {
        http_response_code(200);
        echo $attachment_id;
    }

    // done!
    die();
}

add_action('wp_ajax_my_file_upload', 'handle_my_file_upload');
add_action('wp_ajax_nopriv_my_file_upload', 'handle_my_file_upload');

//
function submit_data()
{
    global $wpdb;
    $torob_product = $wpdb->prefix . 'torob_product';
    $products = $_POST['products'];
    $result_submit_data = $wpdb->get_results("SELECT * FROM $torob_product  WHERE `id` IN (" . implode(',', $products) . ")");
    wp_send_json(['products' => $result_submit_data]);
}

add_action('wp_ajax_submit_data', 'submit_data');
add_action('wp_ajax_nopriv_submit_data', 'submit_data');
//
function integration()
{
    global $wpdb;
    $torob_main_product = $wpdb->prefix . 'torob_main_product';
    $torob_product_descriptions = $wpdb->prefix . 'torob_product_descriptions';
    $id = $_POST['id'];
    $product = $wpdb->get_results("SELECT * FROM $torob_main_product  WHERE `product_id`= $id");
    $descriptions = $wpdb->get_results("SELECT * FROM $torob_product_descriptions  WHERE `product_id`= $id");
    wp_send_json(['product' => $product, 'descriptions' => $descriptions]);
}

add_action('wp_ajax_integration', 'integration');
add_action('wp_ajax_nopriv_integration', 'integration');

//
function integration2()
{
    global $wpdb;
    $torob_main_product = $wpdb->prefix . 'torob_main_product';
    $torob_product_descriptions = $wpdb->prefix . 'torob_product_descriptions';
    $id = $_POST['id'];
    $product = $wpdb->get_results("SELECT * FROM $torob_main_product  WHERE `product_id`= $id");
    $descriptions = $wpdb->get_results("SELECT * FROM $torob_product_descriptions  WHERE `product_id`= $id");
    wp_send_json(['product' => $product, 'descriptions' => $descriptions]);
}

add_action('wp_ajax_integration2', 'integration2');
add_action('wp_ajax_nopriv_integration2', 'integration2');
//

function filter_price()
{
    global $wpdb;
    $torob_main_product = $wpdb->prefix . 'torob_main_product';
    $torob_integration  = $wpdb->prefix . 'torob_integration';
    $torob_product = $wpdb->prefix . 'torob_product';
    $torob_product_categories = $wpdb->prefix . 'torob_product_categories';
    $category = $_POST['category-status-integration'];
    $stock = $_POST['inventory-status-integration'];
    $access_status_integration = $_POST['access-status-integration'];
    $integration_status = $_POST['integration-status'];
    $term = $_POST['term-integration'];
    $name_product = $_POST['integration-name-product'];
    $query = "SELECT *, (SELECT COUNT('id') FROM $torob_product WHERE $torob_product.productid=$torob_main_product.product_id) AS 'count' FROM $torob_main_product JOIN $torob_product_categories ON $torob_main_product.product_id=$torob_product_categories.product_id LEFT JOIN $torob_integration on $torob_integration.product_main_id = $torob_main_product.product_id where $torob_main_product.product_id > 0 ";
    if ($stock && $stock !== 'همه') {
        if ($stock == 2) {
            $query .= " AND $torob_main_product.stock = 0";
        } else {
            $query .= " AND $torob_main_product.stock = $stock";
        }
    }
    if ($category !== "") {
        if ($category == 0) {
            $query .= " AND $torob_main_product.product_type IS NULL";
        } else {
            $query .= " AND $torob_main_product.product_type IS NOT NULL";
        }
    }
    if ($access_status_integration) {
        $query .= " AND $torob_main_product.check = '$access_status_integration'";
    }
    if ($term) {
        $query .= " AND $torob_product_categories.category = '$term[0]'";
    }
    if ($integration_status !== '') {
        $query .= " AND $torob_integration.integration_status = '$integration_status'";
    }
    if ($name_product) {
        $query .= " AND $torob_main_product.product_name = '$name_product'";
    }
    $query .= " GROUP BY product_name";

    $product_filter = $wpdb->get_results($query);
    wp_send_json(['products' => $product_filter]);

}

add_action('wp_ajax_filter_price', 'filter_price');
add_action('wp_ajax_nopriv_filter_price', 'filter_price');
//

function filter_sort()
{
    global $wpdb;
    $torob_main_product = $wpdb->prefix . 'torob_main_product';
    $torob_product = $wpdb->prefix . 'torob_product';
    $sort = $_POST['sort'];
    $pagination_sort = $_POST['pagination-sort'];
    $query_filter = "SELECT *, (SELECT COUNT('id') FROM $torob_product WHERE $torob_product.productid=$torob_main_product.product_id) AS 'count' FROM $torob_main_product";
    if ($sort == 0) {
        $query_filter = $query_filter . " order by time asc";
    } else {
        $query_filter = $query_filter . " order by time desc";
    }
    if ($pagination_sort) {
        $query_filter = $query_filter . " LIMIT" . " $pagination_sort";
    }

    $product = $wpdb->get_results($query_filter);
    wp_send_json(['orderProduct' => $product, 'orderQuery' => $query_filter]);
}

add_action('wp_ajax_filter_sort', 'filter_sort');
add_action('wp_ajax_nopriv_filter_sort', 'filter_sort');
//
function getshopData(){
    global $wpdb;
    $torob_posts = $wpdb->prefix . 'posts';
    $id = $_POST['id'];
    $get_posts  = $wpdb->get_results("SELECT * FROM $torob_posts where ID=$id");
    wp_send_json(['shopData' => $get_posts]);
}
add_action('wp_ajax_getshopData', 'getshopData');
add_action('wp_ajax_nopriv_getshopData', 'getshopData');
//

function remove_submenus()
{
    global $submenu;
    unset($submenu['edit.php?post_type=torob'][25]); // Removes 'ویرایش محصول پیشنهادی'.
    unset($submenu['edit.php?post_type=torob'][20]); // Removes 'ویرایش محصول'.
    unset($submenu['edit.php?post_type=torob'][17]); // Removes 'لیست محصولات'.
    unset($submenu['edit.php?post_type=torob'][29]); // Removes 'بررسی پیگیری سفارش'.
}

add_action('admin_menu', 'remove_submenus');