<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://syllogic.in
 * @since      1.0.0
 *
 * @package    Cf7_Multislide
 * @subpackage Cf7_Multislide/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

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
