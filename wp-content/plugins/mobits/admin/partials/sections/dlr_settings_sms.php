<?php 
$options = get_options("
'_dlr_sms_service',
'_dlr_sms_melipayamak_username',
'_dlr_sms_melipayamak_password',
'_dlr_sms_melipayamak_theme',
'_dlr_sms_smsir_appKey',
'_dlr_sms_smsir_secretKey',
'_dlr_sms_smsir_theme',
'_dlr_sms_ippanel_username',
'_dlr_sms_ippanel_password',
'_dlr_sms_ippanel_from',
'_dlr_sms_ippanel_theme'
");
?>

<table class="form-table">
    <tr>
        <th><?php echo __('Select webservice', 'dlr'); ?></th>
        
        <td>
            <fieldset>
                <select name="_dlr_sms_service">
                    <option value="ippanel" <?php selected( esc_attr($options['_dlr_sms_service']) , 'ippanel' ); ?>>ippanel</option>
                	<option value="melipayamak" <?php selected( esc_attr($options['_dlr_sms_service']) , 'melipayamak' ); ?>>melipayamak</option>
                	<option value="smsir" <?php selected( esc_attr($options['_dlr_sms_service']) , 'smsir' ); ?>>sms.ir</option>
            	</select>
            </fieldset>
        </td>
    </tr>
</table>

<?php 
require dirname(__FILE__) . '/sms/melipayamak.php';
require dirname(__FILE__) . '/sms/smsir.php'; 
require dirname(__FILE__) . '/sms/ippanel.php'; 
?>