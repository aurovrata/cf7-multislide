<?php
/**
 * Register a new shortcode with CF7
 */
function cf7slide_add_shortcode_multislide() {
    if (function_exists('wpcf7_add_shortcode')) {
        wpcf7_add_shortcode( 
            array( 'multislide', 'multislide*' ), 
            'cf7slide_multislide_shortcode_handler', 
            true 
        );
    }
}
add_action( 'wpcf7_init', 'cf7slide_add_shortcode_multislide' );


/**
 * Add to the wpcf7 tag generator.
 */
function cf7slide_add_tag_generator_multislide() {
    if ( class_exists( 'WPCF7_TagGenerator' ) ) {
        $tag_generator = WPCF7_TagGenerator::get_instance();
        $tag_generator->add( 'multislide', __( 'multislide', 'cf7slide' ), 'cf7slide_multislide_tag_generator' );
    }
}
add_action( 'admin_init', 'cf7slide_add_tag_generator_multislide', 30 );

/**
 * Handle the multistep handler
 * This shortcode lets the plugin determine if the form is a multi-step form
 * and if it should redirect the user to step 1.
 */
function cf7slide_multislide_shortcode_handler( $tag ) {
    $tag = new WPCF7_Shortcode( $tag );
    $validation_error = wpcf7_get_validation_error( $tag->name );
    $class = wpcf7_form_controls_class( $tag->type, 'cf7slide-multislide' );
    if ( $validation_error ) {
        $class .= ' wpcf7-not-valid';
    }
    $class .= ' cf7slide-multislide';
    if ( 'multislide*' === $tag->type ) {
        $class .= ' wpcf7-validates-as-required';
    }
		//use this as unique identifier
		$security_nonce = wp_create_nonce( "cf7-multislide-nonce" );
    $value = (string) reset( $tag->values );
		//first explode by code
		//$slide_values = explode( ':jscode:',$value );
		//$code='';
		//if(isset($slide_values[1])) $code = $slide_values[1];
    $slide_values = explode( 'of',$value );
		//error_log("Multislide: ".$value."\n".print_r($slide_values,true));
		
    $curr_slide = $slide_values[0];
    
    $total_slides = $slide_values[1];

    $atts1 = array(
				'id'                 => 'current-slide-'.$curr_slide,
        'type'               => 'hidden',
        'class'              => $tag->get_class_option( $class. ' cf7slide-current' ),
        'value'              => $curr_slide,
        'name'               => 'current_slide'
    );
		$atts2 = array(
        'type'               => 'hidden',
        'class'              => $tag->get_class_option( $class.' cf7slide-total' ),
        'value'              => $total_slides,
        'name'               => 'total_slides'
    );
		$atts3 = array(
        'type'               => 'hidden',
        'class'              => $tag->get_class_option( $class.' cf7slide-security' ),
        'value'              => $security_nonce,
        'name'               => 'cf7slide_security'
    );
    $atts1 = wpcf7_format_atts( $atts1 );
		$atts2 = wpcf7_format_atts( $atts2 );
		$atts3 = wpcf7_format_atts( $atts3 );
		
    $html = sprintf( '<input %1$s /><br><input %2$s /><input %3$s /> %4$s', $atts1, $atts2, $atts3, $validation_error );
    //$html = sprintf( '<input %1$s /><br><input %2$s />%3$s', $atts1, $atts2, $validation_error );

    //populate rest of form in hidden tags.
    $submission = WPCF7_Submission::get_instance();
    
    //get all posted data
    foreach ($_POST as $name => $value) {
        //add hidden elements for any not in current form.

        //if multistep posted value is greater than current step, populate elements.

        //print hidden elements
    }

    //$wpcf7 = WPCF7_ContactForm::get_current();

    return $html;
}

/**
 * Multislide tag pane.
 */
function cf7slide_multislide_tag_generator( $contact_form, $args = '' ) {

    $args = wp_parse_args( $args, array() );
?>
<div class="control-box cf7slide-multislide">
    <fieldset>
        <legend>Mulstislide form using contact form 7</legend>

        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row">
                        <?php _e('Current Slide', 'cf7slide'); ?>
                    </th>
                    <td>
                        <input id="tag-generator-panel-current-slide" type="number" name="values_current_slide" class="oneline cf7slide-multislide-values" min="1" />
                        <label for="tag-generator-panel-current-slide">
                            <span class="description">The current slide of this multi-slide form.</span>
                        </label>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <?php _e('Total Slides', 'cf7slide'); ?>
                    </th>
                    <td>
                        <input id="tag-generator-panel-total-slides" type="number" name="values_total_slides" class="oneline cf7slide-multislide-values" min="1" />
                        <label for="tag-generator-panel-total-slides">
                            <span class="description">The total number of slides in your multi-slide form.</span>
                        </label>
                        <br>
                    </td>
                </tr>
								<!--tr>
                    <th scope="row">
                        <?php _e('Javascript to move to next slide', 'cf7msm'); ?>
                    </th>
                    <td>
                        <input id="tag-generator-panel-next-slide" type="text" name="next_slide" class="oneline cf7slide-multislide-values" />
                        <br>
                        <label for="tag-generator-panel-next-slide">
                            <span class="description">The javascript code to trigger the slider to the next slide.  (Leave blank on last step)</span>
                        </label>
                    </td>
                </tr-->
            </tbody>
        </table>
    </fieldset>
</div>
    <div class="insert-box">
        <input type="hidden" name="values" value="" />
        <input type="text" name="multislide" class="tag code" readonly="readonly" onfocus="this.select()" />

        <div class="submitbox">
            <input type="button" class="button button-primary insert-tag" value="<?php echo esc_attr( __( 'Insert Tag', 'contact-form-7' ) ); ?>" />
        </div>

        <br class="clear" />

        <p class="description mail-tag"><label><?php echo esc_html( __( "This field should not be used on the Mail tab.", 'contact-form-7' ) ); ?></label>
        </p>
    </div>
<?php
}

/**
 * Remove br from hidden tags.
 */


function cf7slide_admin_enqueue_scripts( $hook_suffix ) {
    if ( false === strpos( $hook_suffix, 'wpcf7' ) ) {
        return;
    }
    wp_enqueue_script( 'cf7slide-admin-taggenerator',
         get_stylesheet_directory_uri() .'/js/tag-generator.js' ,
        array( 'jquery' ), 1.0, true );

    wp_enqueue_style( 'cf7slide-admin',
        get_stylesheet_directory_uri() .'/css/cf7slide.css' ,
        array( 'contact-form-7-admin' ), 1.0 );
}
add_action( 'admin_enqueue_scripts', 'cf7slide_admin_enqueue_scripts' );

function cf7slide_mail_on_last_slide( $wpcf7 ) {
		$form_items = $wpcf7->form_scan_shortcode();
  //error_log("MultislideForm: \n".print_r($form_items,true));
	foreach($form_items as $item){
		//error_log("MultislideForm: \n".print_r($item,true));
		if('multislide' == $item['type']){
				$slides = explode('of',$item['values'][0]);
				error_log("MultislideForm: slides,\n".print_r($slides,true));
				if( isset($slides[1]) && ($slides[0] != $slides[1]) ){
						
						//add_filter('wpcf7_ajax_json_echo', 'cf7slide_hide_multislide_form', 10, 2);
				}
		}
	}
}
//add_action( 'wpcf7_before_send_mail', 'cf7slide_mail_on_last_slide', 8 );

function cf7slide_hide_success_msg($items, $result) {
    remove_filter('wpcf7_ajax_json_echo', 'cf7slide_hide_success_msg');
    if ($items['mailSent'] && isset($items['onSentOk']) && count($items['onSentOk']) > 0) {
        $items['onSentOk'][] = "$('" . $items['into'] . "').find('div.wpcf7-response-output').css('opacity',0);";
				//error_log("MultislideForm: items\n".print_r($items,true)."\n\n-------results-----\n\n".print_r($result,true));
    }
    return $items;
}

function cf7slide_next_slide($cf7) {
    $has_wpcf7_class = class_exists( 'WPCF7_ContactForm' ) && method_exists($cf7, 'prop');
    $form_id  = '';
    if ( $has_wpcf7_class ) {
        $formstring = $cf7->prop('form');
        $form_id = $cf7->id();
    }
    else {
        $formstring = $cf7->form;
        $form_id = $cf7->id;
    }

    //check if form has a slide field
    if (!is_admin() && 
        ( preg_match('/\[multislide "(\d+)of(\d+)"\]/', $formstring, $matches) ) ) {
        
        if ( $matches[1] != $matches[2]) {
            add_filter('wpcf7_ajax_json_echo', 'cf7slide_hide_success_msg', 10, 2);
        }
    }

    return $cf7;
}
add_action('wpcf7_contact_form', 'cf7slide_next_slide');

function cf7slide_merge_slide_posted_data($posted_data){
		error_log("Multislide INITIAL data: \n".print_r($posted_data,true));
		//Is this a multislide form?
		$security = $posted_data['cf7slide_security'];
		if( empty($security) ) return $posted_data;
		$current_slide = $posted_data['current_slide'];
		$total_slides = $posted_data['total_slides'];
		
		if($current_slide != $total_slides){
				//we need to store this slide's posted_data
				set_transient('cf7_multislide_'.$current_slide.'_'.$security, $posted_data, DAY_IN_SECONDS );
				//we can skip the mail
				$wpcf7 = WPCF7_ContactForm::get_current();
        $wpcf7->skip_mail = true;
		}else{
				//merge the previous slides posted data into this one
				for($slide = $total_slides-1;$slide > 0;$slide--){
						//merge them in reverse order so that the oldest slide comes last
						//and any fields that repeat across slides will be set to the most recent slide  
						$stored_data = get_transient('cf7_multislide_'.$slide.'_'.$security);
						error_log("Mulstislide merging stored data, cf7_multislide_".$slide." \n".print_r($stored_data,true));
						//array_merge will overwrite similar keyed values with the later array values
						$posted_data = array_merge($stored_data, $posted_data);
						error_log("Mulstislide merged posted data, \n".print_r($posted_data,true));
				}
		}
		
		return $posted_data;
}
//add filter later, incase we have other plugins altering the data
add_filter( 'wpcf7_posted_data', 'cf7slide_merge_slide_posted_data', 30 );

?>