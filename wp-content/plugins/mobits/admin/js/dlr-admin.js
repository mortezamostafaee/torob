jQuery(document).ready(function($){
    
     $( document ).on( 'click', '#_dlr_logo_button',  function(e1) {
        e1.stopImmediatePropagation();
        e1.preventDefault();
        var image = wp.media({
            title: 'انتخاب عکس',
            multiple: false
        }).open()
        .on('select', function(e){
            var uploaded_image = image.state().get('selection').first();
            var image_url = uploaded_image.toJSON().url;
            $('._dlr_logo_box').val( image_url );
        });
    
    });
    
    $( document ).on( 'click', '#_dlr_favicon_button',  function(e1) {
        e1.stopImmediatePropagation();
        e1.preventDefault();
        var image = wp.media({
            title: 'انتخاب عکس',
            multiple: false
        }).open()
        .on('select', function(e){
            var uploaded_image = image.state().get('selection').first();
            var image_url = uploaded_image.toJSON().url;
            $('._dlr_favicon_box').val( image_url );
        });
    
    });
    
    $( document ).on( 'click', '#_dlr_background_image',  function(e1) {
        e1.stopImmediatePropagation();
        e1.preventDefault();
        var image = wp.media({
            title: 'انتخاب عکس',
            multiple: false
        }).open()
        .on('select', function(e){
            var uploaded_image = image.state().get('selection').first();
            var image_url = uploaded_image.toJSON().url;
            $('._dlr_background_image_box').val( image_url );
        });
    
    });
    
    function smsView() 
    {
        var sms = $('select[name="_dlr_sms_service"]').find(":selected").val();
        var all = ['smsir', 'melipayamak', 'ippanel'];
        all.forEach(e=> {
            if(e!=sms) $('#'+e).hide(); else $('#'+e).show();
        });
    }
    
    smsView();
    
    $(document).on('change', 'select[name="_dlr_sms_service"]', function(){
        smsView();
        console.log(123);
    });

    $(document).on('click', '.nav-tab', function(){
        $('#dlr_setting_wrapper').animate({opacity: .4}, 200);
    })
    
});
