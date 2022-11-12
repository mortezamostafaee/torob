<?php 
$options = get_options("
'_dlr_logo',
'_dlr_favicon',
'_dlr_background_image',
'_dlr_description',
'_dlr_color',
'_dlr_color_tab',
'_dlr_extra_style',
'_dlr_design_type',
'_dlr_dark_mode_status',
'_dlr_button_image'
");
?>

<tr>
    <th><?php echo __('Form design type', 'dlr'); ?></th>
    
    <td>
        <fieldset>
            <p>
                <input name="_dlr_design_type" id="_dlr_design_type_modern" type="radio" <?php checked( esc_attr($options['_dlr_design_type']), 'modern'); ?> value="modern">
                <label for="_dlr_design_type_modern"><?php echo __('Modern', 'dlr'); ?></label>
            </p>
            <p>
                <input name="_dlr_design_type" id="_dlr_design_type_classic" type="radio" <?php checked( esc_attr($options['_dlr_design_type']), 'classic'); ?> value="classic">
                <label for="_dlr_design_type_classic"><?php echo __('Classic', 'dlr'); ?></label>
            </p>
        </fieldset>
        <p>
           <?php echo __('Specifies the design of Mobits forms', 'dlr'); ?> 
        </p>
    </td>
</tr>

<tr>
    <th><?php echo __('Site logo', 'dlr'); ?></th>
    
    <td>
        <fieldset>
            <input name="_dlr_logo" value="<?php echo esc_attr($options['_dlr_logo']); ?>" type="" class="regular-text _dlr_logo_box">
            <button type="button" class="button-secondary" id="_dlr_logo_button">
                <?php echo __('Select Image', 'dlr'); ?>
            </button>
            <p class="description" id="tagline-description">
                <?php echo __('A png image with a width of 200 pixels and a height of 60 pixels is recommended ', 'dlr'); ?>
            </p>
        </fieldset>
    </td>
</tr>

<tr>
    <th><?php echo __('Site favicon', 'dlr'); ?></th>
    
    <td>
        <fieldset>
            <input name="_dlr_favicon" value="<?php echo esc_attr($options['_dlr_favicon']); ?>" type="" class="regular-text _dlr_favicon_box">
            <button type="button" class="button-secondary" id="_dlr_favicon_button">
                <?php echo __('Select image', 'dlr'); ?> 
            </button>
            <p class="description" id="tagline-description">
                <?php echo __('Select an image with a width of 32 x 32 pixels and in the recommended ico or png format.', 'dlr'); ?> 
            </p>
        </fieldset>
    </td>
</tr>

<tr>
    <th><?php echo __('Background image', 'dlr'); ?></th>
    
    <td>
        <fieldset>
            <input name="_dlr_background_image" value="<?php echo esc_attr($options['_dlr_background_image']); ?>" type="" class="regular-text _dlr_background_image_box">
            <button type="button" class="button-secondary" id="_dlr_background_image">
                <?php echo __('Select image', 'dlr'); ?> 
            </button>
            <p class="description" id="tagline-description">
                <?php echo __('It is recommended to choose a small jpg image with a length of 1440 pixels and a height of 954 pixels.', 'dlr'); ?> 
            </p>
        </fieldset>
    </td>
</tr>

<tr>
    <th><?php echo __("Button's Background image", 'dlr'); ?></th>
    
    <td>
        <fieldset>
            <input name="_dlr_button_image" id="_dlr_button_image" type="checkbox" <?php checked( esc_attr($options['_dlr_button_image']), 1); ?> value="1"> 
            <label for="_dlr_button_image"><?php echo __("Active", 'dlr'); ?></label>
        </fieldset>
        <p>
            <?php echo __('With this option enabled, the page background image will also appear on the buttons.', 'dlr'); ?> 
        </p>
    </td>
</tr>


<tr>
    <th><?php echo __("Button's color", 'dlr'); ?></th>
    
    <td>
        <fieldset>
            <input type="text" class="wpa-bgcolor-field text-left" name="_dlr_color" value="<?php echo esc_attr($options['_dlr_color']); ?>" placeholder="#000000"/>
        </fieldset>
        <p><?php echo __('This color is assigned to the buttons of Mobits forms.', 'dlr'); ?> </p>
    </td>
</tr>

<tr>
    <th><?php echo __("Tab's color", 'dlr'); ?></th>
    
    <td>
        <fieldset>
            <input type="text" class="wpa-bgcolor-field text-left" name="_dlr_color_tab" value="<?php echo esc_attr($options['_dlr_color_tab']); ?>" placeholder="#000000"/>
        </fieldset>
        <p><?php echo __('This color is assigned to the active login or registration tab at the top of Mobits forms.', 'dlr'); ?></p>
    </td>
</tr>

<tr>
    <th><?php echo __("Dark mode", 'dlr'); ?></th>
    
    <td>
        <fieldset>
            <input name="_dlr_dark_mode_status" id="_dlr_dark_mode_status" type="checkbox" <?php checked( esc_attr($options['_dlr_dark_mode_status']), 1); ?> value="1"> 
            <label for="_dlr_dark_mode_status"><?php echo __("Active", 'dlr'); ?></label>
        </fieldset>
        <p><?php echo __('With this option enabled, the Mobits form theme becomes dark and suitable for dark templates. It is recommended to disable the background image and button image in dark theme mode.', 'dlr'); ?></p>
    </td>
</tr>

<tr>
    <th><?php echo __("Footer text", 'dlr'); ?></th>
    
    <td>
        <fieldset>
            <?php
            echo '<div style="width: 50%;">';
            wp_editor( $options['_dlr_description'] , 'regText', [
            	'textarea_name' => '_dlr_description',
            	'editor_height' => 170,
                'textarea_rows' => 10, 
                'media_buttons' => FALSE,
            ]);
            echo '</div>';
            ?>
        </fieldset>
        <p><?php echo __('This text is displayed at the bottom of the Mobits forms.', 'dlr'); ?> </p>
    </td>
</tr>

<tr>
    <th><?php echo __("Extra Style", 'dlr'); ?></th>
    
    <td>
        <fieldset>
            <textarea class="text-left dlr_extra_style" rows="10" name="_dlr_extra_style"><?php echo esc_attr($options['_dlr_extra_style']); ?></textarea>
        </fieldset>
        <p><?php echo __('If you want to add your favorite styles to different sections of Mobits forms, be sure to enter those styles in this box.', 'dlr'); ?></p>
    </td>
</tr>