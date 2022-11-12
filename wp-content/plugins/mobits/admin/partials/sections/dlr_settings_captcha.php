<?php 
$options = get_options("
'_dlr_google_captcha_in_login_form',
'_dlr_google_captcha_in_register_form',
'_dlr_google_captcha_in_recovery_form',
'_dlr_google_recaptchav2_site_key'");
?>
<tr>
    <th>
        <?php echo __('Google captcha in login form', 'dlr'); ?>
    </th>
    
    <td>
        <fieldset>
            <input name="_dlr_google_captcha_in_login_form" id="_dlr_google_captcha_in_login_form" type="checkbox" <?php checked( esc_attr($options['_dlr_google_captcha_in_login_form']), 1); ?> value="1"> 
            <label for="_dlr_google_captcha_in_login_form"><?php echo __('Active', 'dlr'); ?></label>
        </fieldset>
        <p><?php echo __('By activating this option, Captcha will be activated in the login form. ', 'dlr'); ?></p>
    </td>
</tr>

<tr>
    <th>
        <?php echo __('Google captcha in register form', 'dlr'); ?>
    </th>
    
    <td>
        <fieldset>
            <input name="_dlr_google_captcha_in_register_form" id="_dlr_google_captcha_in_register_form" type="checkbox" <?php checked( esc_attr($options['_dlr_google_captcha_in_register_form']), 1); ?> value="1"> 
            <label for="_dlr_google_captcha_in_register_form"><?php echo __('Active', 'dlr'); ?></label>
        </fieldset>
        <p><?php echo __('By activating this option, Captcha will be activated in the register form. ', 'dlr'); ?></p>
    </td>
</tr>

<tr>
    <th>
        <?php echo __('Google captcha in recovery form', 'dlr'); ?>
    </th>
    
    <td>
        <fieldset>
            <input name="_dlr_google_captcha_in_recovery_form" id="_dlr_google_captcha_in_recovery_form" type="checkbox" <?php checked( esc_attr($options['_dlr_google_captcha_in_recovery_form']), 1); ?> value="1"> 
            <label for="_dlr_google_captcha_in_recovery_form"><?php echo __('Active', 'dlr'); ?></label>
        </fieldset>
        <p><?php echo __('By activating this option, Captcha will be activated in the recovery form. ', 'dlr'); ?></p>
    </td>
</tr>

<tr>
    <th><?php echo __('Google recaptcha(V2) site key ', 'dlr'); ?></th>
    
    <td>
        <fieldset>
            <input name="_dlr_google_recaptchav2_site_key" type="" class="regular-text text-left" placeholder="" value="<?php echo get_option('_dlr_google_recaptchav2_site_key', ''); ?>">
            <p class="description" id="tagline-description"><?php echo __('Go to <a target="_blank" href="http://www.google.com/recaptcha/admin">this page</a> and create your site key.', 'dlr'); ?></p>
        </fieldset>
    </td>
</tr>