<?php 
require DLR_BASE . '/admin/partials/sections/dlr_settings_header.php';

if( !isset($_GET['dlr_tab']) || (isset($_GET['dlr_tab']) && $_GET['dlr_tab'] == 'functional') ){
    require DLR_BASE . '/admin/partials/sections/dlr_settings_functional.php';
}
elseif( isset($_GET['dlr_tab']) && $_GET['dlr_tab'] == 'woocommerce' ){
    require DLR_BASE . '/admin/partials/sections/dlr_settings_woocommerce.php';
}
elseif( isset($_GET['dlr_tab']) && $_GET['dlr_tab'] == 'design' ){
    require DLR_BASE . '/admin/partials/sections/dlr_settings_design.php';
}
elseif( isset($_GET['dlr_tab']) && $_GET['dlr_tab'] == 'sms' ){
    require DLR_BASE . '/admin/partials/sections/dlr_settings_sms.php';
}
elseif( isset($_GET['dlr_tab']) && $_GET['dlr_tab'] == 'captcha' ){
    require DLR_BASE . '/admin/partials/sections/dlr_settings_captcha.php';
}

require DLR_BASE . '/admin/partials/sections/dlr_settings_footer.php';

?>