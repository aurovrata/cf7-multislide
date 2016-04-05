(function($) {
  $(document).ready(function() {
    
      // This will override the clearForm() function in jquery.form.js so that any
    // readonly fields will retain their value instead of clearing on submit.
    // Since we prefill these fields, clearing them would render them unusable.
    //$.fn.clearForm = function(includeHidden) {
    //  return this.each(function() {
    //    $('input,select,textarea', this).not('.wpcf7-form input,.wpcf7-form select,.wpcf7-form textarea').clearFields(includeHidden);
    //  });
    //};
    //let's override the 
    $.fn.resetForm = function() {
      return this.each(function() {
        // guard against an input with the name of 'reset'
        // note that IE reports the reset function as an 'object'
        if (typeof this.reset == 'function' || (typeof this.reset == 'object' && !this.reset.nodeType)) {
            var idx=0;
            var currentSlide,totalSlide;
            var resetForm = true;
            for(idx=0; idx<this.length; idx++){
              //console.log(this[idx]);
              if( $(this[idx]).hasClass('cf7slide-current') ){
                currentSlide = $(this[idx]).val();
                resetForm=false;
              }
              if( $(this[idx]).hasClass('cf7slide-total') ){
                totalSlide = $(this[idx]).val();
                resetForm=false;
              }
            }
            if (totalSlide!=null && currentSlide!=null && currentSlide==totalSlide) {
              resetForm= true;
            }
            if (resetForm) {
              this.reset();
            }
        }
    });
};
  });
  
    
})(jQuery);