jQuery(document).ready(function(){
  // This button will increment the value
    jQuery('.quantity-up').click(function(e){
      // Stop acting like a button
      e.preventDefault();
      // Get the field name
      fieldName = jQuery(this).attr('field');
      // Get its current value
      var currentVal = parseInt(jQuery('input[name='+fieldName+']').val());
      // If is not undefined
      if (!isNaN(currentVal)) {
          // Increment
          jQuery('input[name='+fieldName+']').val(currentVal + 1);
      } else {
          // Otherwise put a 0 there
          jQuery('input[name='+fieldName+']').val(0);
      }
  });
  // This button will decrement the value till 0
    jQuery(".quantity-down").click(function(e) {
      // Stop acting like a button
      e.preventDefault();
      // Get the field name
      fieldName = jQuery(this).attr('field');
      // Get its current value
      var currentVal = parseInt(jQuery('input[name='+fieldName+']').val());
      // If it isn't undefined or its greater than 0
      if (!isNaN(currentVal) && currentVal > 1) {
          // Decrement one
          jQuery('input[name='+fieldName+']').val(currentVal - 1);
      } else {
          // Otherwise put a 0 there
          jQuery('input[name='+fieldName+']').val(1);
      }
  });
});
