<?php
/* Template Name: Auction */
?>
<?php
global $wpdb;
$torob_proposal = $wpdb->prefix . "torob_proposal";

$user_name = wp_get_current_user()->user_login;
if (isset($_POST['sent'])) {
    global $wpdb;
    $table_proposal = $wpdb->prefix . 'torob_proposal';
    $wpdb->insert($table_proposal, array(
        'user_id' => $_POST['user_id'],
        'proposal' => $_POST['proposal'],
    ), array('%s', '%d')
    );
}
$result = $wpdb->get_results("SELECT * FROM $torob_proposal where user_id = '$user_name' order by time desc limit 1");
if (isset($_POST['remove-auction']) && $result) {
    $wpdb->delete($torob_proposal, array('id' => $result[0]->id));
}
    $result1 = $wpdb->get_results("SELECT * FROM $torob_proposal where user_id = '$user_name' order by time desc limit 1");
?>
<link rel="stylesheet" href="<?php echo get_template_directory_uri() . '/css/custom-page.css' ?>">
<link rel="stylesheet" href="<?php echo get_template_directory_uri() . '/css/bootstrap.css' ?>">
<body class="body-auction">
<main class="main-page-auction" dir="auto">

    <?php if (is_user_logged_in()): ?>
    <?php while (have_posts()) : the_post(); ?>
        <?php the_content(); ?>
    <?php endwhile; ?>
    <div class="d-flex justify-content-around">
        <form method="post" style="border-left: solid 1px;padding-left: 33px;">
            <h6 class="text-center mb-5" style="color: #000">مبلغ پیشنهادی شما برای دریافت بنر</h6>
            <input type="number" name="proposal">
            <input id="user_id" type="hidden" name="user_id" value="<?php echo $user_name ?>"/>
            <button type="submit" name="sent" class="btn btn-primary">ارسال</button>
        </form>
        <div>
            <h6 style="color: #000">پیشنهاد فعلی شما</h6>
            <?php if ($result1 && $result1[0]->user_id == $user_name) : ?>
                <?php foreach ($result1 as $item): ?>
                    <p class="text-center" style="color: #000"><?php echo $item->proposal ?> تومان</p>
                <?php endforeach; ?>
            <?php else: ?>
                <p>ثبت نشده است</p>
            <?php endif; ?>
            <form method="post">
                <button type="submit" name="remove-auction" class="btn btn-secondary">لغو پیشنهاد</button>
            </form>
        </div>
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
<script src="<?php echo get_template_directory_uri() . '/js/bootstrap.js' ?>"></script>
