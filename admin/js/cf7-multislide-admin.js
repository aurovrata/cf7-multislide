(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 */
	$(function() {

  	 $('#multislide-tag-generator .cf7slide-multislide-values').on('change',function(){
  			 var current_step = $('input[name="values_current_slide"]', $(this.form)).val();
  			 var total_steps = $('input[name="values_total_slides"]', $(this.form)).val();
  			 var value = current_step + 'of' + total_steps;// + next_slide;

  			 $('input[name="values"]', $(this.form)).val( value );
  			 $('.insert-box input.tag', $(this.form)).val('[multislide "' + value + '"]');

  	 });
  });

})( jQuery );
