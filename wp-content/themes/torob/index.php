<span class="index-header"><?php get_header() ?></span>
    <div class="row">
        <div class="home-torob position-relative">
            <div class="d-flex">
                <img src="<?php echo get_template_directory_uri() . '/images/logo.png' ?>">
                <h1 class="h1-torob">ترب</h1>
            </div>
            <p class="position-absolute home-p">مقایسه قیمت میلیون ها محصول بین هزاران فروشگاه</p>
            <form class="position-relative">
                <div class="d-flex input-hpme mt-4">
                    <?php echo do_shortcode("[wd_asp id=2]"); ?>
                </div>

            </form>
        </div>
    </div>
<?php get_footer() ?>