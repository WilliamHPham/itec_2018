function loading_icon(){
    jQuery("#img-loader").show();
    jQuery(document).ajaxStart(function () {
        jQuery("#img-loader").css("display", "block");
    });
}
function ajax_normalize(){
    jQuery(document).ajaxComplete(function(){
        setTimeout(function() {
            jQuery("#img-loader").css("display", "none");
            jQuery("#img-loader").hide();
        }, 1000);
    });
}