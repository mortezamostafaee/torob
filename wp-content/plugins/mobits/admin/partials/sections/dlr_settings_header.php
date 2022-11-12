<div class="wrap dlr_setting">
	<h1><?php echo __('Mobits', 'dlr'); ?>
	<bdi class="version"><?php echo __('V2.1', 'dlr'); ?></bdi>
    	<span>Email: 
    	<a href="mailto:mobits.ir@gmail.com">mobits.ir@gmail.com</a>
    	<br>
    	<bdi class="telegram">Telegram: @mobits_ir</bdi>
    	</span>
	</h1>
	<?php
	
	$tabs = array( 
	    'functional'    => __('Functional', 'dlr'), 
	    'design'        => __('Design', 'dlr'),
	    'sms'           => __('Webservice', 'dlr'),
	    'captcha'       => __('Google Captcha', 'dlr')
	);
	
	if( get_option('_dlr_support_woocommerce', 0) == 1 )
	{
	    $tabs['woocommerce'] = __('Woocommerce', 'dlr');
	}
	
    echo '<nav class="nav-tab-wrapper">';
    $i=0;
    foreach( $tabs as $tab => $name ){
        $class = ( isset($_GET['dlr_tab']) && $tab == $_GET['dlr_tab'] ) || ( !isset($_GET['dlr_tab']) && $i==0 ) ? ' nav-tab-active' : '';
        echo "<a class='nav-tab $class nav-tab' href='?page=dlr-settings&dlr_tab=$tab'>$name</a>";
        $i++;
    }
    echo '</nav>';
	
	?>
    
    <form method="post" action="" id="dlr_setting_wrapper">
    <table class="form-table">
        
        <tbody>