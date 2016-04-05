(function($) {
    $('form.tag-generator-panel .cf7slide-multislide .cf7slide-multislide-values').change(function(){
        var current_step = $('input[name="values_current_slide"]', $(this.form)).val();
        var total_steps = $('input[name="values_total_slides"]', $(this.form)).val();
        //var next_slide = $('input[name="next_slide"]', $(this.form)).val();
        //if (next_slide) {
        //    next_slide=':jscode:'+next_slide;
        //}
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
})(jQuery);