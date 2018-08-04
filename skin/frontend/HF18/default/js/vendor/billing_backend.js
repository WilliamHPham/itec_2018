// document.getElementById("billing[use_for_shipping]").checked = true;

function ajaxRegion(value,link,method) {
    jQuery.ajax({
        method: 'POST',
        url: link,
        data: {
            value:value
        },
        success: function (data) {

            if(data.length == 0)
            {
                jQuery( ".regionSelect"+method ).addClass('hidden');
                jQuery( ".regionInput"+method ).removeClass('hidden');
                jQuery( ".regionInput"+method ).attr('title',"*");
            }
            else{
                jQuery( ".regionSelect"+method ).removeClass('hidden');
                jQuery( ".regionInput"+method ).addClass('hidden');
                jQuery( ".regionInput"+method ).removeAttr('title');
                jQuery('.message_region'+method).css('display', 'none');
            }
            jQuery( ".regionSelect"+method ).html('');
            jQuery.each(data, function(index, value) {
                jQuery( ".regionSelect"+method ).append( "<option value='"+ value.region_id +"'>" + value.name + "</option>");
            });
        }
    });
};

jQuery(document).ready(function() {
    jQuery('.countryShipping').on('click', function() {
        value=jQuery( ".countryShipping option:selected" ).data('value');
        var link=jQuery( ".countryShipping option:selected" ).data('link');
        ajaxRegion(value,link,"Shipping");
    })
    jQuery('.countryBilling').on('click', function() {
        value=jQuery( ".countryBilling option:selected" ).data('value');
        var link=jQuery( ".countryBilling option:selected" ).data('link');
        ajaxRegion(value,link,"Billing");
    })

    jQuery('input[id="login:register"]').change(function () {
        if (jQuery('input[id="login:register"]').is(":checked")) {
            jQuery('input[name=checkout_method]').val("register");
        }
        else {
            jQuery('input[name=checkout_method]').val("guest");
        }
    })

    jQuery('input[id="_newslettersubscription"]').change(function () {
        if (jQuery('input[id="_newslettersubscription"]').is(":checked")) {
            jQuery(this).val("1");
        }
        else {
            jQuery(this).val("0");
        }
    })

    jQuery('select.shipping-option').change(function() {
        var $option = jQuery(this).find('option:selected');

        var value = $option.val();//to get content of "value" attrib
        if(value=="new"){
            jQuery('.shipping-form').show();
        }
        else jQuery('.shipping-form').hide();
    });


    jQuery('.billing_add').on('click', function () {
        id=jQuery(this).data('value');
        jQuery('.billing_add').removeClass('dashed');
        jQuery(this).addClass('dashed');
        radiobtn = document.getElementById("id_" + id);
        radiobtn.checked = true;
    });
    jQuery('.shipping_add').on('click', function () {
        id=jQuery(this).data('value');
        jQuery('.shipping_add').removeClass('dashed');
        jQuery(this).addClass('dashed');
        radiobtn = document.getElementById("idShipping_" + id);
        radiobtn.checked = true;
    });
});
var listAddress = Class.create();
listAddress.prototype={
    switchAddress: function(id){
        if( this.curId == null)
        {
            this.curId = id;
        }
        else
        {
            var temp = this.curId;
            jQuery(document).ready(function () {
                jQuery('#input_'+temp).attr('disabled',true);
                jQuery('#input_'+id).removeAttr('disabled');
            });
            this.curId = id;
        }
    }
}

