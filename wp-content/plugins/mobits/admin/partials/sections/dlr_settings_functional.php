<?php 
$options = get_options("
'_dlr_login_status',
'_dlr_register_status',
'_dlr_redirect_url',
'_dlr_redirect_logout',
'_dlr_page_slug',
'_dlr_auto_confirm',
'_dlr_recovery_status',
'_dlr_login_force_all',
'_dlr_support_digits',
'_dlr_support_woocommerce',
'_dlr_admin_login_redirect',
'_dlr_register_in_login_form',
'_dlr_resend_code_time',
'_dlr_export_csv'");
?>

<tr>
    <th><?php echo __('Login Form', 'dlr'); ?></th>
    
    <td>
        <fieldset>
            <input name="_dlr_login_status" id="dlr_login_status" type="checkbox" <?php checked( esc_attr($options['_dlr_login_status']), 1); ?> value="1"> 
            <label for="dlr_login_status"><?php echo __('Active', 'dlr'); ?></label>
        </fieldset>
        <p><?php echo __('By enabling this option, login tab and form will be displayed.', 'dlr'); ?></p>
    </td>
</tr>

<tr>
    <th><?php echo __('Register Form', 'dlr'); ?></th>
    
    <td>
        <fieldset>
            <input name="_dlr_register_status" id="dlr_register_status" type="checkbox" <?php checked( esc_attr($options['_dlr_register_status']), 1); ?> value="1"> 
            <label for="dlr_register_status"><?php echo __('Active', 'dlr'); ?></label>
        </fieldset>
        <p><?php echo __('By enabling this option, Register tab and form will be displayed.', 'dlr'); ?></p>
    </td>
</tr>

<tr>
    <th><?php echo __('Login/Register page slug', 'dlr'); ?></th>
    
    <td>
        <fieldset>
            <input name="_dlr_page_slug" type="" class="regular-text text-left" placeholder="" value="<?php echo get_option('_dlr_page_slug', 'dlr-login-register'); ?>">
            <p class="description" id="tagline-description">
                
                   <?php echo __('<strong>Important Note:</strong> Permalink structure should not be simple. To change it, go to the settings menu and the unique links submenu and change the simple option. Your current login page link ', 'dlr'); ?>
                
                    <a target="_blank" href="<?php echo home_url() . '/' . esc_attr($options['_dlr_page_slug']); ?>">
                        <?= home_url() . '/' . esc_attr($options['_dlr_page_slug']); ?>
                        </a>
                <?php echo __('Note that while logging in, you will not be able to view the Mobits form. The name of the login page should be unique and not similar to any post or tab on the site. ', 'dlr'); ?>
            </p>
        </fieldset>
    </td>
</tr>

<tr>
    <th><?php echo __('Register user in login form', 'dlr'); ?></th>
    
    <td>
        <fieldset>
            <input name="_dlr_register_in_login_form" id="_dlr_register_in_login_form" type="checkbox" <?php checked( esc_attr($options['_dlr_register_in_login_form']), 1); ?> value="1"> 
            <label for="_dlr_register_in_login_form"><?php echo __('Active', 'dlr'); ?></label>
        </fieldset>
            <p class="description" id="tagline-description">
                <?php echo __('By activating this option, the Mobits login form registers new users. Note that in this case, the user will not have a first and last name. ', 'dlr'); ?>
            </p>
        </fieldset>
    </td>
</tr>

<tr>
    <th><?php echo __('Resend code time (Seconds)', 'dlr'); ?></th>
    
    <td>
        <fieldset>
            <input type="number" value="<?php echo esc_attr($options['_dlr_resend_code_time']); ?>" placeholder="120" name="_dlr_resend_code_time" class="regular-text text-left dlr_resend_code">
            <p class="description" id="tagline-description">
                <?php echo __('Specifies the resend time of the verification code in seconds.', 'dlr'); ?>
            </p>
        </fieldset>
    </td>
</tr>

<tr>
    <th><?php echo __('Email or username recovery', 'dlr'); ?></th>
    
    <td>
        <fieldset>
            <input name="_dlr_recovery_status" id="_dlr_recovery_status" type="checkbox" <?php checked( esc_attr($options['_dlr_recovery_status']), 1); ?> value="1"> 
            <label for="_dlr_recovery_status"><?php echo __('Active', 'dlr'); ?></label>
        </fieldset>
        <p><?php echo __('By enabling this option, you will allow your old users who have registered with a username to have their mobile number replaced with a username, and from now on they can log in with a mobile number.', 'dlr'); ?> </p>
    </td>
</tr>

<tr>
    <th><?php echo __('CSV export numbers', 'dlr'); ?></th>
    
    <td>
        <fieldset>
            <input name="_dlr_export_csv" id="_dlr_export_csv" type="checkbox" <?php checked( esc_attr($options['_dlr_export_csv']), 1); ?> value="1"> 
            <label for="_dlr_export_csv"><?php echo __('Active', 'dlr'); ?></label>
        </fieldset>
        <p><?php echo __('With this option enabled, it is possible to output Excel from users mobile numbers on the page of all users in the admin panel.', 'dlr'); ?></p>
    </td>
</tr>

<tr><th><h3 class="m-0"><span class="dashicons dashicons-admin-links"></span> &nbsp;<?php echo __('Redirect', 'dlr'); ?></h3></th></tr>

<tr>
    <th><?php echo __('Page link after login', 'dlr'); ?></th>
    
    <td>
        <fieldset>
            <input value="<?php echo esc_attr($options['_dlr_redirect_url']); ?>" placeholder="<?php echo home_url(); ?>" name="_dlr_redirect_url" class="regular-text text-left">
            <p class="description" id="tagline-description">
                <?php echo __('The user will be redirected to this page after successful login.', 'dlr'); ?>
            </p>
        </fieldset>
    </td>
</tr>

<tr>
    <th><?php echo __('Page link after logout', 'dlr'); ?></th>
    
    <td>
        <fieldset>
            <input value="<?php echo esc_attr($options['_dlr_redirect_logout']); ?>" placeholder="<?php echo home_url(); ?>" name="_dlr_redirect_logout" class="regular-text text-left">
            <p class="description" id="tagline-description">
               <?php echo __('The user will be redirected to this page after logout.', 'dlr'); ?>
            </p>
        </fieldset>
    </td>
</tr>

<tr>
    <th><?php echo __('Auto redirect after code entered ', 'dlr'); ?></th>
    
    <td>
        <fieldset>
            <input name="_dlr_auto_confirm" id="_dlr_auto_confirm" type="checkbox" <?php checked( esc_attr($options['_dlr_auto_confirm']), 1); ?> value="1"> 
            <label for="_dlr_auto_confirm"><?php echo __('Active', 'dlr'); ?></label>
        </fieldset>
        <p>
            <?php echo __('By enabling this option, the user, after entering 4 digits of the code, will be automatically transferred to the next step without pressing a button.', 'dlr'); ?>
        </p>
    </td>
</tr>

<tr>
    <th><?php echo __('Require login to view the site ', 'dlr'); ?></th>
    
    <td>
        <fieldset>
            <input name="_dlr_login_force_all" id="_dlr_login_force_all" type="checkbox" <?php checked( esc_attr($options['_dlr_login_force_all']), 1); ?> value="1"> 
            <label for="_dlr_login_force_all"><?php echo __('Active', 'dlr'); ?></label>
        </fieldset>
        <p><?php echo __('By enabling this option, you will need to log in to view all sections of the site, and the user will be taken to the Mobits login page.', 'dlr'); ?></p>
    </td>
</tr>

<tr>
    <th><?php echo __('Redirect admin login to mobits', 'dlr'); ?></th>
    
    <td>
        <fieldset>
            <input name="_dlr_admin_login_redirect" id="_dlr_admin_login_redirect" type="checkbox" <?php checked( esc_attr($options['_dlr_admin_login_redirect']), 1); ?> value="1"> 
            <label for="_dlr_admin_login_redirect"><?php echo __('Active', 'dlr'); ?></label>
        </fieldset>
        <p><?php echo __('With this option enabled, the user will be redirected from the WordPress admin login page (wp-admin or wp-login.php) to the Mobits form. <strong>Important Note:</strong> Before activating this option, make sure that there is an admin user with Mobits and a mobile number in the panel. ', 'dlr'); ?></p>
    </td>
</tr>

<tr>
    <th><?php echo __('Redirect a page to mobits', 'dlr'); ?></th>
    
    <td>
        <fieldset>
            <input value='[go_mobits back="pageUrl"]' readonly class="regular-text text-left">
        </fieldset>
        <p><?php echo __('If you want to redirect a non-logged in user to a mobits form, use this shortcode on that page. The back parameter specifies the return page address of Mobits after login or register. If you do not use this parameter, the user will return to the page where the shortcode is placed (current page). ', 'dlr'); ?></p>
    </td>
</tr>



<tr><th><h3 class="m-0"><span class="dashicons dashicons-admin-plugins"></span> &nbsp;<?php echo __('Other Plugins', 'dlr'); ?></h3></th></tr>

<tr>
    <th><?php echo __('Digits users support', 'dlr'); ?></th>
    
    <td>
        <fieldset>
            <input name="_dlr_support_digits" id="_dlr_support_digits" type="checkbox" <?php checked( esc_attr($options['_dlr_support_digits']), 1); ?> value="1"> 
            <label for="_dlr_support_digits"><?php echo __('Active', 'dlr'); ?></label>
        </fieldset>
        <p><?php echo __('If your site users have already registered with Digits plugin and you have now migrated to Mobits, and you want previous users to be able to login with registered mobile number, Enable this option. ', 'dlr'); ?></p>
    </td>
</tr>

<tr>
    <th><?php echo __('Woocommerce Support', 'dlr'); ?></th>
    
    <td>
        <fieldset>
            <input name="_dlr_support_woocommerce" id="_dlr_support_woocommerce" type="checkbox" <?php checked( esc_attr($options['_dlr_support_woocommerce']), 1); ?> value="1"> 
            <label for="_dlr_support_woocommerce"><?php echo __('Active', 'dlr'); ?></label>
        </fieldset>
        <p><?php echo __('Enabling this option activates WooCommerce plugin features in Mobits.', 'dlr'); ?></p>
    </td>
</tr>
