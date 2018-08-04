jQuery(document).ready(function() {
    var isChecked = jQuery('.shipping').is(':checked');
    if(isChecked){
        var value_checked = jQuery('.shipping').val();
        var shipping_checked = jQuery('.shipping').data('value');
        var url = jQuery('.shipping').data('link');
        shippingPriceAjax(value_checked,shipping_checked,url);
    }
    jQuery('.shipping').on('click', function() {
        loading_icon();
        if(jQuery(this).val()){
            var value = jQuery(this).val();
            var shippingType = jQuery(this).data('value');
        }else{
            alert("No value for shipping method");
        }
        var link=jQuery(this).data('link');
        shippingPriceAjax(value,shippingType,link);
    });
    var checkbtn_placeOrder = jQuery("#showbuttonOther").data('value');
    if(checkbtn_placeOrder == -1){
        jQuery("#btn-order").hide();
    }
});

function shippingPriceAjax(value,shippingType,link) {
    jQuery.ajax({
        method: 'POST',
        url: link,
        data: {
            code_value: value,
            shipping_type:shippingType
        },
        dataType: 'json',
        success:function(data){
            ajax_normalize();
            jQuery('#grandTotal-id').html(data.GrandTotal);
            jQuery('#shipping-id').html(data.ShippingAmount);
            jQuery('#tax-id').html(data.TaxAmount);
        }
    });
}
