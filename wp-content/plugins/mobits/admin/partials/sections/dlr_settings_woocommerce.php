<?php 
$options = get_options("
'_dlr_redirect_my_account',
'_dlr_redirect_checkout',
'_dlr_save_mobile_in_woocommerce',
'_dlr_save_name_in_woocommerce',
'_dlr_checkout_notif'");
?>
<tr>
    <th>
        <?php echo __('Redirect from my-account', 'dlr'); ?>
    </th>
    
    <td>
        <fieldset>
            <input name="_dlr_redirect_my_account" id="_dlr_redirect_my_account" type="checkbox" <?php checked( esc_attr($options['_dlr_redirect_my_account']), 1); ?> value="1"> 
            <label for="_dlr_redirect_my_account"><?php echo __('Active', 'dlr'); ?></label>
        </fieldset>
        <p><?php echo __('With this option enabled, when the user goes to the WooCommerce login and registration page with the name my-account and is not logged in, it will be redirected to the Mobits login form.', 'dlr'); ?></p>
    </td>
</tr>

<tr>
    <th>
        <?php echo __('Redirect from checkout', 'dlr'); ?>
    </th>
    
    <td>
        <fieldset>
            <input name="_dlr_redirect_checkout" id="_dlr_redirect_checkout" type="checkbox" <?php checked( esc_attr($options['_dlr_redirect_checkout']), 1); ?> value="1"> 
            <label for="_dlr_redirect_checkout"><?php echo __('Active', 'dlr'); ?></label>
        </fieldset>
        <p><?php echo __('With this option enabled, when the customer goes to the checkout page and is not logged in, it will be redirected to the Mobits login form. ', 'dlr'); ?></p>
    </td>
</tr>

<tr>
    <th>
        <?php echo __('Must login warning', 'dlr'); ?>
    </th>
    
    <td>
        <fieldset>
            <input name="_dlr_checkout_notif" id="_dlr_checkout_notif" type="checkbox" <?php checked( esc_attr($options['_dlr_checkout_notif']), 1); ?> value="1"> 
            <label for="_dlr_checkout_notif"><?php echo __('Active', 'dlr'); ?></label>
        </fieldset>
        <p><?php echo __('With this option enabled, when the user is redirected from the checkout page to the Mobits login form, a warning is displayed at the top of the form with the title You must login or register to continue the order.', 'dlr'); ?></p>
    </td>
</tr>

<tr>
    <th>
        <?php echo __("Save user's mobile in woocommerce", 'dlr'); ?>
    </th>
    
    <td>
        <fieldset>
            <input name="_dlr_save_mobile_in_woocommerce" id="_dlr_save_mobile_in_woocommerce" type="checkbox" <?php checked( esc_attr($options['_dlr_save_mobile_in_woocommerce']), 1); ?> value="1"> 
            <label for="_dlr_save_mobile_in_woocommerce"><?php echo __('Active', 'dlr'); ?></label>
        </fieldset>
        <p><?php echo __("By activating this option, the user's mobile number is stored in the default billing and shipping address of the customer.", 'dlr'); ?></p>
    </td>
</tr>

<tr>
    <th>
        <?php echo __("Save user's name in woocommerce", 'dlr'); ?>
    </th>
    
    <td>
        <fieldset>
            <input name="_dlr_save_name_in_woocommerce" id="_dlr_save_name_in_woocommerce" type="checkbox" <?php checked( esc_attr($options['_dlr_save_name_in_woocommerce']), 1); ?> value="1"> 
            <label for="_dlr_save_name_in_woocommerce"><?php echo __('Active', 'dlr'); ?></label>
        </fieldset>
        <p><?php echo __("By activating this option, the user's name is stored in the default billing and shipping name field of the customer.", 'dlr'); ?></p>
    </td>
</tr>
