<div id="melipayamak">
    <h3><?php echo __('Melipayamak settings', 'dlr'); ?></h3>
    
    <div>
        <?php echo __('To use the melipayamak SMS panel, first go to the address on its website ', 'dlr'); ?>
        <a target="_blank" href="https://www.melipayamak.com">https://www.melipayamak.com</a> 
        <?php echo __('Register and purchase the SMS panel.', 'dlr'); ?>
    </div>
    
    <table class="form-table">
    <tr>
        <th><?php echo __('Username', 'dlr'); ?></th>
        
        <td>
            <input type="text" name="_dlr_sms_melipayamak_username" value="<?php echo esc_attr($options['_dlr_sms_melipayamak_username']); ?>" placeholder=""/>
        </td>
    </tr>
    
    <tr>
        <th><?php echo __('Password', 'dlr'); ?></th>
        
        <td>
            <input type="password" autocomplete="new-password" name="_dlr_sms_melipayamak_password" value="<?php echo esc_attr($options['_dlr_sms_melipayamak_password']); ?>" placeholder=""/>
        </td>
    </tr>
    
    <tr>
        <th><?php echo __('Template code', 'dlr'); ?></th>
        
        <td>
            <input type="text" name="_dlr_sms_melipayamak_theme" value="<?php echo esc_attr($options['_dlr_sms_melipayamak_theme']); ?>" placeholder=""/>
        </td>
    </tr>
    
    <tr>
        <th><?php echo __('Template pattern', 'dlr'); ?></th>
        
        <td>
            <textarea readonly rows="4" class="pattern"><?php echo __('Your verification code is {0} &#13;&#13;Your site name&#13;Yoursite.com', 'dlr'); ?></textarea>
            <p><?php echo __('The pattern text you create in melipayamak should be exactly the same as the text above, and change your site name and site address. ', 'dlr'); ?></p>
        </td>
    </tr>
    </table>
</div>