<?php 
if( is_user_logged_in() )
{
    wp_redirect( get_option('_dlr_redirect_url', home_url() ) );
    exit;
}

require DLR_BASE_PARTIALS . 'header.php';
    
if(!isset($_GET['type'])) 
{
    $options = get_options("
    '_dlr_checkout_notif',
    '_dlr_recovery_status'
    ");

    require DLR_BASE_PARTIALS . 'login-form.php';
    require DLR_BASE_PARTIALS . 'register-form.php';
}
elseif( isset($_GET['type']) && $_GET['type'] == 'recovery'){
    require DLR_BASE_PARTIALS . 'recovery-form.php';
}
else {
    require DLR_BASE_PARTIALS . 'confirm-form.php';
}

require DLR_BASE_PARTIALS . 'footer.php';        