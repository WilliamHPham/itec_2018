//validate
function validateVoucher()
{
    var flag = 1;
    jQuery('#smartVoucher').each(function () {
        radiobtn = document.getElementById("p_method_smart_voucher");
        if (jQuery(this).val() == "" && radiobtn.checked == true) {
            jQuery(this).addClass('alert alert-danger');
            jQuery('.messageVoucher').css('display', 'block');
            flag = 0;
        }
        else{
            jQuery(this).removeClass('alert alert-danger');
            jQuery('.messageVoucher').css('display', 'none');
        }
    });
    return flag;
}
// payment
var Payment = Class.create();
Payment.prototype = {
    switchMethod: function(method){
        if (this.currentMethod && $('payment_form_'+this.currentMethod)) {
            this.changeVisible(this.currentMethod, true);
            $('payment_form_'+this.currentMethod).fire('payment-method:switched-off', {method_code : this.currentMethod});
        }
        if ($('payment_form_'+method)){
            this.changeVisible(method, false);
            $('payment_form_'+method).fire('payment-method:switched', {method_code : method});
        } else {
            //Event fix for payment methods without form like "Check / Money order"
            document.body.fire('payment-method:switched', {method_code : method});
        }
        if (method == 'free' && quoteBaseGrandTotal > 0.0001
            && !(($('use_reward_points') && $('use_reward_points').checked) || ($('use_customer_balance') && $('use_customer_balance').checked))
        ) {
            if ($('p_method_' + method)) {
                $('p_method_' + method).checked = false;
                if ($('dt_method_' + method)) {
                    $('dt_method_' + method).hide();
                }
                if ($('dd_method_' + method)) {
                    $('dd_method_' + method).hide();
                }
            }
            method == '';
        }
        if (method) {
            this.lastUsedMethod = method;
        }
        this.currentMethod = method;
    },

    changeVisible: function(method, mode) {
        var block = 'payment_form_' + method;
        [block + '_before', block, block + '_after'].each(function(el) {
            element = $(el);
            if (element) {
                element.style.display = (mode) ? 'none' : '';
                element.select('input', 'select', 'textarea', 'button').each(function(field) {
                    field.disabled = mode;
                });
            }
        });
    },
};