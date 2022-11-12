<div id="ippanel">
    <h3><?php echo __('Ippanel settings', 'dlr'); ?></h3>
    
    <div>
        <?php echo __('To use the ippanel SMS panel, first go to the address on its website ', 'dlr'); ?>
        <a target="_blank" href="http://sms.baloot.agency/">http://sms.baloot.agency/</a> 
        <?php echo __('Register and purchase the SMS panel.', 'dlr'); ?>
    </div>
    
    <table class="form-table">
    <tr>
        <th><?php echo __('Username', 'dlr'); ?></th>
        
        <td>
            <input class="text-left" type="text" name="_dlr_sms_ippanel_username" value="<?php echo esc_attr($options['_dlr_sms_ippanel_username']); ?>" placeholder=""/>
        </td>
    </tr>
    
    <tr>
        <th><?php echo __('Password', 'dlr'); ?></th>
        
        <td>
            <input class="text-left" type="password" autocomplete="new-password" name="_dlr_sms_ippanel_password" value="<?php echo esc_attr($options['_dlr_sms_ippanel_password']); ?>" placeholder=""/>
        </td>
    </tr>
    
    <tr>
        <th><?php echo __('Sender', 'dlr'); ?></th>
        
        <td>
            <input class="text-left" type="text" name="_dlr_sms_ippanel_from" value="<?php echo esc_attr($options['_dlr_sms_ippanel_from']); ?>" placeholder=""/>
        </td>
    </tr>
    
    <tr>
        <th><?php echo __('Template code', 'dlr'); ?></th>
        
        <td>
            <input type="text" name="_dlr_sms_ippanel_theme" value="<?php echo esc_attr($options['_dlr_sms_ippanel_theme']); ?>" />
        </td>
    </tr>
    
    <tr>
        <th><?php echo __('Tempate pattern', 'dlr'); ?></th>
        
        <td>
            <textarea readonly rows="4" class="pattern"><?php echo __('Your verification code is %verification-code%&#13;&#13;Your site name&#13;Yoursite.com', 'dlr'); ?></textarea>
        <p><?php echo __('The pattern text you create in ippanel should be exactly the same as the text above, and change your site name and site address. ', 'dlr'); ?></p>
        </td>
    </tr>
    </table>
</div>