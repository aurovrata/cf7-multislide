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
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
	 $('form.tag-generator-panel .cf7slide-multislide .cf7slide-multislide-values').change(function(){
			 var current_step = $('input[name="values_current_slide"]', $(this.form)).val();
			 var total_steps = $('input[name="values_total_slides"]', $(this.form)).val();
			 var value = current_step + 'of' + total_steps;// + next_slide;

			 $('input[name="values"]', $(this.form)).val( value );
			 $('.insert-box input.tag', $(this.form)).val('[multislide "' + value + '"]');

	 });

	 $('#tag-generator-panel-dropzone-field').change(function(){
			 var field_name = $('input[name="dropzone_field_name"]', $(this.form)).val();
			 var value = field_name;

			 $('input[name="name"]', $(this.form)).val( value );
			 $('.insert-box input.tag', $(this.form)).val('[dropzone ' + value + ']');

	 });

})( jQuery );
