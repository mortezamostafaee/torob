<?php
/* Template Name: select image  */
global $wpdb;
//$page = $_GET['page'] ?? 1;
//$skip = $page - 1;
$torob_banner = $wpdb->prefix . "torob_banner";
$user_name = wp_get_current_user()->user_login;
//if ($skip > 0) {
$result1 = $wpdb->get_results("SELECT * FROM $torob_banner where user_name = '$user_name'");
//} else {
//    $result1 = $wpdb->get_results("SELECT * FROM $torob_banner where user_name = '$user_name' LIMIT 1");
//}

if (isset($_POST['select-banner'])) {

    global $wpdb;
    $torob_user_selected_banners = $wpdb->prefix . "torob_user_selected_banners";

    $wpdb->insert($torob_user_selected_banners, array(
        'user_name' => $_POST['user_name'],
        'collection_banner' => $_POST['collection_banner'],
        'link_banner' => $_POST['link_banner'],
        'utm_medium' => $_POST['utm_medium'],
        'utm_content' => $_POST['utm_content'],
        'utm_campaign' => $_POST['utm_campaign'],
        'utm_term' => $_POST['utm_term'],
        'utm_source' => $_POST['utm_source'],
        'site_banner' => $_POST['site-banner'],
        'app_banner' => $_POST['app-banner'],

    ), array('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')
    );
}
?>
<link rel="stylesheet" href="<?php echo get_template_directory_uri() . '/css/custom-page.css' ?>">
<style>
    ul {
        list-style-type: none;
    }

    li {
        display: inline-block;
    }

    <?php foreach ($result1 as $item): ?>
    input[type="checkbox"][id^="sitebanner-<?php echo $item->id?>"],
    input[type="checkbox"][id^="sitebanner-<?php echo $item->user_name?>-<?php echo $item->id?>"] {
        display: none;
    }

    <?php endforeach;?>
    label {
        border: 1px solid #fff;
        padding: 10px;
        display: block;
        position: relative;
        margin: 10px;
        cursor: pointer;
    }

    label:before {
        background-color: white;
        color: white;
        content: " ";
        display: block;
        border-radius: 50%;
        border: 1px solid grey;
        position: absolute;
        top: -5px;
        left: -5px;
        width: 25px;
        height: 25px;
        text-align: center;
        line-height: 28px;
        transition-duration: 0.4s;
        transform: scale(0);
    }

    label img {
        height: 100px;
        width: 100px;
        transition-duration: 0.2s;
        transform-origin: 50% 50%;
    }

    :checked + label {
        border-color: #ddd;
    }

    :checked + label:before {
        content: "✓";
        background-color: grey;
        transform: scale(1);
    }

    :checked + label img {
        transform: scale(0.9);
        /* box-shadow: 0 0 5px #333; */
        z-index: -1;
    }

    .pagination {
        display: inline-block;
    }

    .pagination a {
        color: black;
        float: left;
        padding: 8px 16px;
        text-decoration: none;
    }

    .pagination a.active {
        background-color: #4CAF50;
        color: white;
    }

    .pagination a:hover:not(.active) {
        background-color: #ddd;
    }
</style>
<body>
<?php if (is_user_logged_in()): ?>
<?php foreach ($result1 as $item): ?>

    <form method="post">
        <input type="hidden" name="user_name" value="<?php echo $item->user_name ?>">
        <input type="hidden" name="collection_banner" value="<?php echo $item->collection_banner ?>">
        <input type="hidden" name="link_banner" value="<?php echo $item->link_banner ?>">
        <input type="hidden" name="utm_medium" value="<?php echo $item->utm_medium ?>">
        <input type="hidden" name="utm_content" value="<?php echo $item->utm_content ?>">
        <input type="hidden" name="utm_campaign" value="<?php echo $item->utm_campaign ?>">
        <input type="hidden" name="utm_term" value="<?php echo $item->utm_term ?>">
        <input type="hidden" name="utm_source" value="<?php echo $item->utm_source ?>">
        <input type="hidden" name="utm_source" value="<?php echo $item->utm_source ?>">
        <div>

            <ul>
                <p class="collection_banner">
                    <?php echo $item->collection_banner ?>
                </p>
                <li>
                    <input type="checkbox" name="site-banner" value="<?php echo $item->banner_site_torob ?>"
                           id="sitebanner-<?php echo $item->id ?>"/>
                    <label for="sitebanner-<?php echo $item->id ?>"><img
                                src="<?php echo $item->banner_site_torob ?>"/></label>
                </li>
                <li>
                    <input type="checkbox" value="<?php echo $item->banner_app_torob ?>" name="app-banner"
                           id="sitebanner-<?php echo $item->user_name ?>-<?php echo $item->id ?>"/>
                    <label for="sitebanner-<?php echo $item->user_name ?>-<?php echo $item->id ?>"><img
                                src="<?php echo $item->banner_app_torob ?>"/></label>
                </li>
            </ul>
        </div>
        <div class="w-100" style="height: 40px;">
            <button type="submit" name="select-banner" class="btn btn-primary"
                    style='background: #4a90e2;border: none;padding: 10px 30px;color: #fff;font-family: "iranyekan" !important;border-radius: 5px; right: 0; position: absolute;cursor: pointer;'>
                انتخاب بنر
            </button>
        </div>
    </form>
<hr>
<?php endforeach; ?>
<?php else: ?>

    <div class="row">
        <div class="container d-flex justify-content-center" style="background-color: #fff;">

            <img src="<?php echo get_template_directory_uri() . '/images/user-premision.jpg' ?>">

        </div>
        <div class="container" style="background-color: #fff;">
            <p class="access-user">شما اجازه دسترسی به این صفحه را ندارید</p>
            <p class="access-user">برای مشاهده این صفحه وارد سایت شوید </p>
            <iframe src="<?php echo get_home_url() . '/login-register' ?>"
                    style="width: 100% ; height: 266px ; border: none;"></iframe>
        </div>
    </div>


<?php endif; ?>
<!--<div class="pagination">-->
<!--    <a href="#">&laquo;</a>-->
<!--    <a href="#">1</a>-->
<!--    <a class="active" href="#">2</a>-->
<!--    <a href="#">3</a>-->
<!--    <a href="#">4</a>-->
<!--    <a href="#">5</a>-->
<!--    <a href="#">6</a>-->
<!--    <a href="#">&raquo;</a>-->
<!--</div>-->
</body>
