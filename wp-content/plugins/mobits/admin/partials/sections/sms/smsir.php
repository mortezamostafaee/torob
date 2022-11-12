<div id="smsir">
    <h3><?php echo __('Sms.ir settings', 'dlr'); ?></h3>
    
    <div>
        <?php echo __('To use the sms.ir SMS panel, first go to the address on its website ', 'dlr'); ?>
        <a target="_blank" href="https://sms.ir">https://sms.ir</a> 
        <?php echo __('Register and purchase the SMS panel.', 'dlr'); ?>
    </div>
    
    <table class="form-table">
    <tr>
        <th><?php echo __('Security code', 'dlr'); ?></th>
        
        <td>
            <input type="text" name="_dlr_sms_smsir_appKey" value="<?php echo esc_attr($options['_dlr_sms_smsir_appKey']); ?>" placeholder=""/>
        </td>
    </tr>
    
    <tr>
        <th><?php echo __('Api key', 'dlr'); ?></th>
        
        <td>
            <input type="password" autocomplete="new-password" name="_dlr_sms_smsir_secretKey" value="<?php echo esc_attr($options['_dlr_sms_smsir_secretKey']); ?>" placeholder=""/>
        </td>
    </tr>
    
    <tr>
        <th><?php echo __('Template code', 'dlr'); ?></th>
        
        <td>
            <input type="text" name="_dlr_sms_smsir_theme" value="<?php echo esc_attr($options['_dlr_sms_smsir_theme']); ?>" placeholder=""/>
        </td>
    </tr>
    
    <tr>
        <th><?php echo __('Template pattern', 'dlr'); ?></th>
        
        <td>
            <textarea readonly rows="4" class="pattern"><?php echo __('Your verification code is [code] &#13;&#13;Your site name&#13;Yoursite.com', 'dlr'); ?></textarea>  
            <p><?php echo __('The pattern text you create in sms.ir should be exactly the same as the text above, and change your site name and site address. ', 'dlr'); ?></p>
        </td>
    </tr>
    </table>
</div>