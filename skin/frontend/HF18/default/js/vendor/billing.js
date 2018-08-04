var flag = []; // check validate all flag
var getCheckBack = 0;
var getCheckShippingForm = 0;
var getCheckNewShipping = 0;
var getCheckShipping = 0;
var getCheckBilling = 0;
var getLogin = 0;

function handleValidEmail(email) {
    var filter = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    ;
    if (filter.test(email.val())) {
        email.removeClass('alert alert-danger');
        email.next('.message').css('display', 'none');
        flag.push(1);
    }
    else {
        email.addClass('alert alert-danger');
        email.next('.message').css('display', 'block');
        flag.push(0);
    }
}

function validateEmail() {
    var bEmail = jQuery('input[id="billing:email"]');
    var sEmail = jQuery('input[id="shipping:email"]');

    if ((getCheckShippingForm == 1 && getCheckNewShipping == 1) || (getCheckShippingForm == 1 && getCheckNewShipping == 0)) {
        handleValidEmail(sEmail);
    }

    if (getCheckShipping == 0 || getCheckBack == 1) {
        handleValidEmail(bEmail);
    }

}

function handleValidPhone(phone) {
    var filter = /((^[0-9]{1,11}$)|(^\+[0-9]{1,11}$))/;
    if (filter.test(phone.val())) {
        phone.removeClass('alert alert-danger');
        phone.next('.message_phone').css('display', 'none');
        flag.push(1);
    }
    else {
        phone.addClass('alert alert-danger');
        phone.next('.message_phone').css('display', 'block');
        flag.push(0);
    }
}

function validatePhone() {
    var bPhone = jQuery('input[id="billing:telephone"]');
    var sPhone = jQuery('input[id="shipping:telephone"]');

    if ((getCheckShippingForm == 1 && getCheckNewShipping == 1) || (getCheckShippingForm == 1 && getCheckNewShipping == 0)) {
        handleValidPhone(sPhone);
    }

    if (getCheckShipping == 0 || getCheckBack == 1) {
        handleValidPhone(bPhone)
    }
}

function handleValidZip(zip) {
    var filter = /^[0-9]{1,6}$/;
    if (filter.test(zip.val())) {
        zip.removeClass('alert alert-danger');
        zip.next('.message_zip').css('display', 'none');
        flag.push(1);
    }
    else {
        zip.addClass('alert alert-danger');
        zip.next('.message_zip').css('display', 'block');
        flag.push(0);
    }
}

function validateZip() {
    var bZip = jQuery('input[id="billing:postcode"]');
    var sZip = jQuery('input[id="shipping:postcode"]');

    if ((getCheckShippingForm == 1 && getCheckNewShipping == 1) || (getCheckShippingForm == 1 && getCheckNewShipping == 0)) {
        handleValidZip(sZip);
    }

    if (getCheckShipping == 0 || getCheckBack == 1) {
        handleValidZip(bZip)
    }
}

function handleValidEmpty(empty) {
    if (empty.val() == "") {
        empty.addClass('alert alert-danger');
        empty.next('.message').css('display', 'block');
        flag.push(0);
    }
    else {
        empty.removeClass('alert alert-danger');
        empty.next('.message').css('display', 'none');
        flag.push(1);
    }
}

function validateEmpty() {
    var bFirstName = jQuery('input[id="billing:firstname"]');
    var bLastName = jQuery('input[id="billing:lastname"]');
    var bCompany = jQuery('input[id="billing:company"]');
    var bStreet = jQuery('input[id="billing:street1"]');
    var bCity = jQuery('input[id="billing:city"]');

    var sFirstName = jQuery('input[id="shipping:firstname"]');
    var sLastName = jQuery('input[id="shipping:lastname"]');
    var sCompany = jQuery('input[id="shipping:company"]');
    var sStreet = jQuery('input[id="shipping:street1"]');
    var sCity = jQuery('input[id="shipping:city"]');

    if ((getCheckShippingForm == 1 && getCheckNewShipping == 1) || (getCheckShippingForm == 1 && getCheckNewShipping == 0)) {
        handleValidEmpty(sFirstName);
        handleValidEmpty(sLastName);
        handleValidEmpty(sCompany);
        handleValidEmpty(sStreet);
        handleValidEmpty(sCity);
    }

    if (getCheckShipping == 0 || getCheckBack == 1) {
        handleValidEmpty(bFirstName);
        handleValidEmpty(bLastName);
        handleValidEmpty(bCompany);
        handleValidEmpty(bStreet);
        handleValidEmpty(bCity);
    }
}

function checkPassword() {
    var password = jQuery('input[id="billing:customer_password"]');
    var confirmPassword = jQuery('input[id="billing:confirm_password"]');

    if(getLogin == 1)
    {
        handleValidEmpty(password);
    }

    if (password.val() != confirmPassword.val()) {
        confirmPassword.addClass('alert alert-danger');
        confirmPassword.next('.message_password').css('display', 'block');
    } else {
        confirmPassword.removeClass('alert alert-danger');
        confirmPassword.next('.message_password').css('display', 'none');
    }
}

//show billing form
function showBilling() {
    jQuery('.new_billing').show();
    jQuery('.address_items_billing').hide();
    jQuery('.roll_back_billing').show();
    jQuery('.newBilling').hide();
    getCheckBilling = 1;
}

//hide billing form
function hideBilling() {
    jQuery('.new_billing').hide();
    jQuery('.address_items_billing').show();
    jQuery('.roll_back_billing').hide();
    jQuery('.newBilling').show();
    getCheckBilling = 0;
}

//show shipping form
function showShipping() {
    jQuery('.new_shipping').show();
    jQuery('.address_items_shipping').hide();
    jQuery('.roll_back_shipping').show();
    jQuery('.newShipping').hide();
    getCheckShipping = 1;
}

//hide shipping form
function hideShipping() {
    jQuery('.new_shipping').hide();
    jQuery('.address_items_shipping').show();
    jQuery('.roll_back_shipping').hide();
    jQuery('.newShipping').show();
    getCheckBack = 1;
}

jQuery(document).ready(function () {
    jQuery('#btn-order').click(function () {
        if (!jQuery('#billing_empty').is(":hidden") || !jQuery('#shipping_empty').is(":hidden")) {
            validateEmpty();
            validateEmail();
            validatePhone();
            validateZip();
            flag.push(validateVoucher());
            console.log(flag);

            if (getLogin == 1) {
                checkPassword();
            }


            if (!flag.includes(0)) {
                data = jQuery(".form-order").serialize();
                loading_icon();
                jQuery("#errorList").hide();
                jQuery("#errorContent").empty();
                jQuery.ajax({
                    type: "POST",
                    data: data,
                    url: jQuery("#btn-order").data('execute')
                }).done(function (data) {
                    ajax_normalize();
                    if (data.success == 0) {
                        jQuery("#errorList").show();
                        var errors = "";
                        var errorsListLength = data.errorsList.length;
                        for (i = 0; i < errorsListLength; i++) {
                            errors += "<p>" + data.errorsList[i] + "</p>";
                        }
                        jQuery("#errorContent").append(errors);

                        jQuery('html, body').animate({
                            scrollTop: jQuery('#top-header').offset().top
                        }, 800);
                    }
                    else {
                        window.location.href = jQuery('#btn-order').data('redirect');
                    }
                });

            }
            else {
                flag = [];
            }
        }
        else {
            data = jQuery(".form-order").serialize();
            console.log(data);
            loading_icon();
            jQuery("#errorList").hide();
            jQuery("#errorContent").empty();
            jQuery.ajax({
                type: "POST",
                data: data,
                url: jQuery("#btn-order").data('execute')
            }).done(function (data) {
                ajax_normalize();
                if (data.success == 0) {
                    jQuery("#errorList").show();
                    var errors = "";
                    var errorsListLength = data.errorsList.length;
                    for (i = 0; i < errorsListLength; i++) {
                        errors += "<p>" + data.errorsList[i] + "</p>";
                    }
                    jQuery("#errorContent").append(errors);

                    jQuery('html, body').animate({
                        scrollTop: jQuery('#top-header').offset().top
                    }, 800);
                }
                else {
                    window.location.href = jQuery('#btn-order').data('redirect');
                }
            });
        }
    });


    jQuery('input[name="billing[use_for_shipping]"]').change(function () {
        if (jQuery(this).val() == 0) {
            jQuery('.shipping-form').css('display', 'block');
            getCheckShippingForm = 1;
            jQuery('#ship_add').show();
        }
        else {
            jQuery('#ship_add').hide();
            jQuery('.shipping-form').css('display', 'none');
            getCheckShippingForm = 0;
        }
    });

    jQuery('select.shipping-option').change(function () {
        var $option = jQuery(this).find('option:selected');

        var value = $option.val();//to get content of "value" attrib
        if (value == "new") {
            jQuery('#shipping_empty').show();
            getCheckNewShipping = 1;
        }
        else {
            jQuery('.shipping_empty').hide();
            getCheckNewShipping = 0;
        }
    });

    jQuery('input[id="login:register"]').change(function () {
        var pw = jQuery('input[id="billing:customer_password"]');
        var confirmPw = jQuery('input[id="billing:confirm_password"]');
        if (jQuery(this).is(":checked")) {
            jQuery('#new_account').show();
            getLogin = 1;
        }
        else {
            jQuery('#new_account').hide();
            getLogin = 0;
            pw.removeClass('alert alert-danger');
            pw.next('.message').css('display', 'none');
            pw.val("");
            confirmPw.val("");
        }
        console.log(getLogin);
    });

    jQuery('.roll_back_billing').hide();

    jQuery('.roll_back_shipping').hide();

    jQuery('.newBilling').on('click', function () {
        showBilling();
    });

    jQuery('.roll_back_billing').on('click', function () {
        hideBilling();
        jQuery('.billing_add').removeClass('dashed');
        jQuery("#billing_list").children().first().addClass('dashed');
        id = jQuery("#billing_list").children().first().find('input[name="billing_address_id"]').attr('id');
        document.getElementById(id).checked = true;
    });

    jQuery('.newShipping').on('click', function () {
        showShipping();
    });

    jQuery('.roll_back_shipping').on('click', function () {
        hideShipping();
        jQuery('.shipping_add').removeClass('dashed');
        jQuery(".address_items_shipping").children().first().addClass('dashed');
        id = jQuery(".address_items_shipping").children().first().find('input[name="shipping_address_id"]').attr('id');
        document.getElementById(id).checked = true;
        getCheckShipping = 0;
    });
});

