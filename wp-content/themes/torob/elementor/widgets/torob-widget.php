<?php


class Elementor_torob_commercial_rows_Widget extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'hello_world_widget_1';
    }

    public function get_title()
    {
        return esc_html__('ردیف های تجاری ترب', 'elementor-addon');
    }

    public function get_icon()
    {
        return 'eicon-wrap';
    }

    public function get_categories()
    {
        return ['basic'];
    }

    public function get_keywords()
    {
        return ['ردیف های تجاری ترب'];
    }
    function get_name_posts()
    {
        global $wpdb;
        $posts = $wpdb->prefix . "posts";
        $result = $wpdb->get_results("SELECT * FROM $posts where post_type = 'torob' && post_status = 'publish'");
        $name = [];
        foreach ($result as $item){
            $name[$item->post_title] = $item->post_title;
        }
        return $name;
    }
    protected function register_controls()
    {

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('تنظیمات', 'plugin-name'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'name-post',
            [
                'label' => esc_html__('نام فروشگاه', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $this->get_name_posts()
            ]
        );

        $this->end_controls_section();

    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        ?>

        <div class="d-flex justify-content-between mb-3 align-items-center">

            <div><h5><a href="<?php echo get_home_url().'/torob/'.$settings['name-post']?>" target="_blank"><?php echo $settings['name-post']; ?></a></h5></div>
            <div><a href="#" class="btn btn-primary" target="_blank">بیشتر</a></div>
        </div>
        <div class="owl-torob">
            <div class="owl-carousel owl-theme">
                <div class="item item-discounts ">
                    <img src="<?php echo get_template_directory_uri().'/images/product.jpg' ?>">
                    <p>روغن آفتابگردان توکوفرول غنچه پلاس 810 گرمی ا -</p>
                    <div class="d-flex justify-content-end">
                        <span class="shop-discounts">vista در</span>
                        <span class="discounts-price">60%</span>
                    </div>
                    <p class="price-discounts">280/000 از</p>
                    <span class="shop-discounts-2">vista در</span>
                    <div class="d-flex justify-content-between mt-3 icon-discounts">
                        <i class="far fa-heart"></i>
                        <i class="far fa-bell"></i>
                    </div>
                </div>

            </div>
        </div>

        <?php
    }
}


