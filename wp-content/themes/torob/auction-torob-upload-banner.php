<?php
/* Template Name: upload banner */
?>
<?php
global $wpdb;
$torob_banner = $wpdb->prefix . "torob_banner";
$user_name = wp_get_current_user()->user_login;
$result1 = $wpdb->get_results("SELECT * FROM $torob_banner");
?>

<?php
if (isset($_POST['save-banner'])) {

    global $wpdb;
    $torob_banner = $wpdb->prefix . 'torob_banner';
    $banner_uoload = UploadSitebanner();
    $banner_App_uoload = UploadAppbanner();
    $wpdb->insert($torob_banner, array(
        'user_name' => $user_name,
        'collection_banner' => $_POST['collection-banner'],
        'link_banner' => $_POST['link-banner'],
        'utm_medium' => $_POST['utm_medium'],
        'utm_content' => $_POST['utm_content'],
        'utm_campaign' => $_POST['utm_campaign'],
        'utm_term' => $_POST['utm_term'],
        'utm_source' => $_POST['utm_source'],
        'banner_site_torob' => $banner_uoload,
        'banner_app_torob' => $banner_App_uoload,
    ), array('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')
    );
}

function UploadSitebanner()
{
    $wordpress_upload_dir = wp_upload_dir();

    $i = 1; // number of tries when the file with the same name is already exists

    $profilepicture = $_FILES['banner-site-torob'];
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


function UploadAppbanner()
{
    $wordpress_upload_dir = wp_upload_dir();

    $i = 1; // number of tries when the file with the same name is already exists

    $profilepicture = $_FILES['banner-app-torob'];
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

<link rel="stylesheet" href="<?php echo get_template_directory_uri() . '/css/custom-page.css' ?>">
<link rel="stylesheet" href="<?php echo get_template_directory_uri() . '/css/bootstrap.css' ?>">
<body class="body-auction">
<main class="main-page-auction" dir="auto" style='font-family: "iranyekan";font-size: 14px;'>

    <?php if (is_user_logged_in()): ?>
    <?php while (have_posts()) : the_post(); ?>
        <?php the_content(); ?>
    <?php endwhile; ?>
    <div class="form-banner">
        <form action="" method="post" enctype="multipart/form-data" autocomplete="off">
            <div class="d-flex gap-2 mb-3">
                <label for="collection-banner">نام مجموعه</label><br>
                <input name="collection-banner" type="text"><br>
            </div>
            <div class="d-flex gap-3 align-items-center">
                <label for="app-banner">بنر اپلیکیشن</label>
                <div style="width: 140px;height: 80px;background-color: white;text-align: center;position: relative;"
                     class="d-flex align-items-center justify-content-center">720 × 406
                </div>
                <input id="browse1" type="file" value="انتخاب فایل" name="banner-app-torob" accept="image/*">
                <div id="preview1"></div>
            </div>
            <div class="d-flex gap-4 align-items-center mt-3">
                <label for="app-banner">بنر سایت</label>
                <div style="width: 140px;height: 50px;background-color: white;text-align: center;position: relative;"
                     class="d-flex align-items-center justify-content-center">980 × 310
                </div>
                <input id="browse2" type="file" value="انتخاب فایل" name="banner-site-torob" accept="image/*">
                <div id="preview2"></div>
            </div>

            <div class="d-flex gap-3 align-items-center mt-3">
                <label for="app-banner">لینک بنر</label>
                <input name="link-banner" type="text"><br>
                <button type="button" class="btn btn-primary" onclick="utmFunction()">تنظیمات UTM
                    <svg style="width: 12px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path fill="#fff"
                              d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z"/>
                    </svg>
                </button>
            </div>
            <div id="utm-box" class="mt-3"
                 style="display: none; transition: 0.5s; background: #fff !important;line-height: 32px;margin: 0 20px; padding: 30px">
                <div class="row">
                    <div class="col-6">
                        <label for="utm_medium">utm_medium</label><br>
                        <input type="text" name="utm_medium">
                    </div>
                    <div class="col-6">
                        <label for="utm_medium">utm_content</label><br>
                        <input type="text" name="utm_content">
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <label for="utm_campaign">utm_campaign</label><br>
                        <input type="text" name="utm_campaign" value="banner_torob">
                    </div>
                    <div class="col-6">
                        <label for="utm_term">utm_term</label><br>
                        <input type="text" name="utm_term">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <label for="utm_source">utm_source</label><br>
                        <input type="text" name="utm_source" value="torob">
                    </div>
                </div>
                <div class="notice-utm">
                    <p>این utm‌ها به صورت خودکار به انتهای آدرس فرود کمپین اضافه می‌شوند و نباید به هنگام ساخت تبلیغ
                        تکرار شوند.
                    </p>
                </div>
            </div>
            <button type="submit" name="save-banner" class="btn btn-primary mt-4" style="padding: 4px 60px;">ذخیره
            </button>
        </form>
    </div>
</main>
<?php else: ?>

    <div class="row">
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
<script>
    function utmFunction() {
        var x = document.getElementById("utm-box");
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }
</script>
<script src="<?php echo get_template_directory_uri() . '/js/bootstrap.js' ?>"></script>
<script>

    var EL_browse = document.getElementById("browse1");
    var EL_preview = document.getElementById("preview1");

    function readImage(file) {
        var img = new Image();
        img.addEventListener("load", () => {
            console.log(img.width + "×" + img.height);
            console.log(file.size / 1024 + "KB");
            window.URL.revokeObjectURL(img.src); // Free some memory
        });
        img.src = window.URL.createObjectURL(file);
    };

    EL_browse.addEventListener("change", (ev) => {
        EL_preview.innerHTML = ""; // Remove old images and data
        var files = ev.target.files;
        if (!files || !files[0]) return alert("File upload not supported");
        [...files].forEach(readImage);
    });


    var EL_browse2 = document.getElementById("browse2");
    var EL_preview2 = document.getElementById("preview2");

    function readImage(file) {
        var img = new Image();
        img.addEventListener("load", () => {
            console.log(img.width + "×" + img.height);
            console.log(file.size / 1024 + "KB");
            window.URL.revokeObjectURL(img.src); // Free some memory
        });
        img.src = window.URL.createObjectURL(file);
    };

    EL_browse2.addEventListener("change", (ev) => {
        EL_preview2.innerHTML = ""; // Remove old images and data
        var files = ev.target.files;
        if (!files || !files[0]) return alert("File upload not supported");
        [...files].forEach(readImage);
    });

</script>
