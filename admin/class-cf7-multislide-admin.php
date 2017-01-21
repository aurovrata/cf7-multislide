<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://syllogic.in
 * @since      1.0.0
 *
 * @package    Cf7_Multislide
 * @subpackage Cf7_Multislide/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Cf7_Multislide
 * @subpackage Cf7_Multislide/admin
 * @author     Aurovrata V. <vrata@syllogic.in>
 */
class Cf7_Multislide_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Cf7_Multislide_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Cf7_Multislide_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/cf7-multislide-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Cf7_Multislide_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Cf7_Multislide_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/cf7-multislide-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Register a [multislide] shortcode with CF7.
	 *
	 * This function registers a callback function to expand the shortcode for the multislide form fields.
	 * @since 1.0.0
	 */
	function add_cf7_shortcode_multislide() {
    if( class_exists('WPCF7_FormTagsManager') ) {
      wpcf7_add_form_tag(
        array( 'multislide', 'multislide*' ),
        array($this,'multislide_shortcode_handler'),
        true
      );
    }
	}
	/**
	 * Add to the wpcf7 tag generator.
	 * This function registers a callback function with cf7 to display
	 * the tag generator help screen in the form editor.
	 * @since 1.0.0
	 */
	function add_cf7_tag_generator_multislide() {
	    if ( class_exists( 'WPCF7_TagGenerator' ) ) {
	        $tag_generator = WPCF7_TagGenerator::get_instance();
	        $tag_generator->add( 'multislide', __( 'multislide', 'cf7slide' ), array($this,'multislide_tag_generator') );
	    }
	}
	/**
	 * Function for multislide shortcode handler.
	 * This function expands the shortcode into the required hiddend fields
	 * to manage the multislide forms.  This function is called by cf7 directly, registered above.
	 *
	 * @since 1.0.0
	 * @param strng $tag the tag name designated in the tag help screen
	 * @return string a set of html fields to capture the multislide information
	 */
	function multislide_shortcode_handler( $tag ) {
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
			//determine how many slides we have and which one this is
	    $slide_values = explode( 'of',$value );
			//error_log("Multislide: ".$value."\n".print_r($slide_values,true));
	    $curr_slide = $slide_values[0];
	    $total_slides = $slide_values[1];
			//current slide hidden field
	    $atts1 = array(
					'id'                 => 'current-slide-'.$curr_slide,
	        'type'               => 'hidden',
	        'class'              => $tag->get_class_option( $class. ' cf7slide-current' ),
	        'value'              => $curr_slide,
	        'name'               => 'current_slide'
	    );
			//number of slides hidden field
			$atts2 = array(
	        'type'               => 'hidden',
	        'class'              => $tag->get_class_option( $class.' cf7slide-total' ),
	        'value'              => $total_slides,
	        'name'               => 'total_slides'
	    );
			//unique identified + secure nonce for this slide
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

	    return $html;
	}
	/**
	 * Multislide tag help screen.
	 *
	 * This function is called by cf7 plugin, and is registered with a hooked function above
	 *
	 * @since 1.0.0
	 * @param WPCF7_ContactForm $contact_form the cf7 form object
	 * @param array $args arguments for this form.
	 */
	function multislide_tag_generator( $contact_form, $args = '' ) {
			include( plugin_dir_path( __FILE__ ) . '/partials/cf7-multislide-admin-display.php');
	}
	/**
	* Hides success msg on form submit response.
	*
	* Called by a 'wpcf7_ajax_json_echo' cf7 hook, hooked on intermediate slides by the intermediate_slides function.
	* @since 1.0.0
	* @param array $items list of cf7 form items passed back to client form
	* @param array @result submitted form values
	* @return arry list of modified items to return to the client form
	*/
	function hide_success_msg($items, $result) {
	    remove_filter('wpcf7_ajax_json_echo', 'cf7slide_hide_success_msg');
	    if ($items['mailSent'] && isset($items['onSentOk']) && count($items['onSentOk']) > 0) {
	        $items['onSentOk'][] = "$('" . $items['into'] . "').find('div.wpcf7-response-output').css('opacity',0);";
					//error_log("MultislideForm: items\n".print_r($items,true)."\n\n-------results-----\n\n".print_r($result,true));
	    }
	    return $items;
	}
	/**
	* Hide cf7 success msg on intermediate slides.
	*
	*The each slide is a cf7 form, each get submmited.  Only the last should show the sucess msg.
	*
	* @since 1.0.0
	* @param WPCF7_ContactForm $cf7 form object
	* @return WPCF7_ContactForm form object
	*/
	function intermediate_slides($cf7) {
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
							//hook cf7 ajaz echo msg to intercept the success msg
	            add_filter('wpcf7_ajax_json_echo', array( $this,'hide_success_msg'), 10, 2);
	        }
	    }
	    return $cf7;
	}
	/**
	* Merge all slide form with last one.
	* This is the crux of this module.  Each intermediate slide forms are stored as transients
	* in the WP db.  On the last slide form, this funciton merges the previous forms data into the last
	* last slide form data array to ensure that the last slide form mail composition has access to the
	* entire range of fields.  This function also applies a hook 'cf7_mulstislide_merged_posted_data' allowing
	* other plugins to changed the final merged $posted_data.
	*
	* @since 1.0.0
	* @param array $posted_data for current form
	* @return array merged list of data fields from all slides if this is last slide.
	*/
	function merge_all_slide_posted_data($posted_data){
			//Is this a multislide form?
      if( !isset($posted_data['cf7slide_security']) ){
				return $posted_data;
			}
			$security = $posted_data['cf7slide_security'];


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
							//error_log("Mulstislide merging stored data, cf7_multislide_".$slide." \n".print_r($stored_data,true));
							//array_merge will overwrite similar keyed values with the later array values
							$posted_data = array_merge($stored_data, $posted_data);
							//error_log("Mulstislide merged posted data, \n".print_r($posted_data,true));
					}
	        //next we need to apply a filter to allow other plugins to set data in final submission
	        $posted_data = apply_filters('cf7_mulstislide_merged_posted_data', $posted_data);
			}
			return $posted_data;
	}

}
