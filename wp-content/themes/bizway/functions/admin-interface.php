<?php
// OptionsFramework Admin Interface
/* ----------------------------------------------------------------------------------- */
/* Options Framework Admin Interface - optionsframework_add_admin */
/* ----------------------------------------------------------------------------------- */
// Load static framework options pages 
$functions_path = get_template_directory() . '/functions/';

function bizway_optionsframework_add_admin() {
    global $query_string;

    $themename = bizway_get_option('of_themename');
    $shortname = bizway_get_option('of_shortname');

    if (isset($_REQUEST['page']) && $_REQUEST['page'] == 'optionsframework') {
        if (isset($_REQUEST['of_save']) && 'reset' == $_REQUEST['of_save']) {
            $options = bizway_get_option('of_template');
            bizway_reset_options($options, 'optionsframework');
            header("Location: admin.php?page=optionsframework&reset=true");
            die;
        }
    }


    $of_page = add_theme_page($themename, __('Theme Options', 'bizway'), 'edit_theme_options', 'optionsframework', 'bizway_optionsframework_options_page', 'div');

    // Add framework functionaily to the head individually
    add_action("admin_print_scripts-$of_page", 'bizway_load_only');
}

add_action('admin_menu', 'bizway_optionsframework_add_admin');
/* ----------------------------------------------------------------------------------- */
/* Options Framework Reset Function - of_reset_options */
/* ----------------------------------------------------------------------------------- */

function bizway_reset_options($options, $page = '') {
    global $wpdb;
    $count = 0;

    $excludes = array('blogname', 'blogdescription');
    delete_option('bizway_options');

    //When Theme Options page is reset - Add the of_options option
    if ($page == 'optionsframework') {
        bizway_delete_option('of_options');
    }
}

/* ----------------------------------------------------------------------------------- */
/* Build the Options Page - optionsframework_options_page */
/* ----------------------------------------------------------------------------------- */

function bizway_optionsframework_options_page() {
    $options = bizway_options();
    $themename = bizway_get_option('of_themename');
	$pro_theme_url = 'http://www.inkthemes.com/wp-themes/simple-wordpress-theme/';
	$pro_theme_demo = 'http://www.inkthemes.com/previews/?demo_id=96';
    $site_url = 'http://www.inkthemes.com';
    ?>
    <div class="bizway_advert" id="bizway_advert">	
				<div class="bizway_block_wrapper">
				<h3><?php _e('bizway Pro Version Features', 'bizway'); ?></h3>
				<div class="bizway_block block_two">				
					<ul>						
						<li><div class="dashicons dashicons-controls-play"></div><?php 
						_e('10 Built in Color Schemes', 'bizway'); ?></li>
						<li><div class="dashicons dashicons-controls-play"></div><?php 
						_e('PDF/Video Documentations', 'bizway'); ?></li>
						<li><div class="dashicons dashicons-controls-play"></div><?php 
						_e('Cool Styling Features', 'bizway'); ?></li>
						<li><div class="dashicons dashicons-controls-play"></div><?php 
						_e('Multiple Slider Options', 'bizway'); ?></li>
					</ul>
				</div>
				<div class="bizway_block block_three">
					<ul>
						<li><div class="dashicons dashicons-controls-play"></div><?php 
						_e('Seo optimized Theme', 'bizway'); ?></li>
						<li><div class="dashicons dashicons-controls-play"></div><?php 
						_e('Translation Ready', 'bizway'); ?></li>
						<li><div class="dashicons dashicons-controls-play"></div><?php 
						_e('Improved Gallery Effect', 'bizway'); ?></li>
						<li><div class="dashicons dashicons-controls-play"></div><?php 
						_e('Gallery & Contact Page', 'bizway'); ?></li>						
					</ul>
				</div>
				<a href="<?php echo esc_url($pro_theme_demo); ?>" target="blank" class="btn btn-demo"><?php _e('View Pro Demo', 'bizway'); ?></a>
				<a href="<?php echo esc_url($pro_theme_url); ?>" target="_blank" class="btn btn-upgrade"><?php _e('Upgrade to Pro', 'bizway'); ?></a>
				</div>
				<div class="bizway_block block_four">				
				<img class="bizway_img_responsive " src="<?php echo get_template_directory_uri(); ?>/images/advert.png">				
			</div>
		</div>
		<div class="clear"></div>
    <div class="theme-option">
    <div class="wrap" id="of_container">
        <div id="of-popup-save" class="of-save-popup">
            <div class="of-save-save"><?php _e('Options Updated', 'bizway'); ?></div>
        </div>
        <div id="of-popup-reset" class="of-save-popup">
            <div class="of-save-reset"><?php _e('Options Reset', 'bizway'); ?></div>
        </div>
        <form action="" enctype="multipart/form-data" id="ofform">
            <?php wp_nonce_field('bizwaytheme-update-option', 'bizway_option_nonce'); ?>
            <div id="header">
                <div class="logo">
                    <h2><?php echo $themename; _e('Options', 'bizway'); ?></h2>
                </div>
                <a href="http://www.inkthemes.com" target="_new">
                    <div class="icon-option"> </div>
                </a>
                <div class="clear"></div>
            </div>
            <?php
            // Rev up the Options Machine
            $return = bizway_optionsframework_machine($options);
            ?>
            <div id="main">
                <div id="of-nav">
                    <ul>
                        <?php echo $return[1] ?>
                    </ul>
                </div>
                <div id="content"> <?php echo $return[0]; /* Settings */ ?> </div>
                <div class="clear"></div>
            </div>
            <div class="save_bar_right save_bar_top">
                <img style="display:none" src="<?php echo get_template_directory_uri(); ?>/functions/images/loading-bottom.gif" class="ajax-loading-img ajax-loading-img-bottom" alt="Working..." />
                <input type="submit" value="<?php _e('Save All Changes', 'bizway'); ?>" class="button-primary" />
            </div>
        </form>
        <div class="save_bar_left save_bar_top">
            <form action="<?php echo esc_attr($_SERVER['REQUEST_URI']) ?>" method="post" style="display:inline" id="ofform-reset">
                <span class="submit-footer-reset">
                    <input name="reset" type="submit" value="<?php _e('Reset Options', 'bizway'); ?>" class="button submit-button reset-button" onclick="return confirm('Click OK to reset. Any settings will be lost!');" />
                    <input type="hidden" name="of_save" value="reset" />
                </span>
            </form>
        </div>
        <?php
        if (!empty($update_message))
            echo $update_message;
        ?>
        <div style="clear:both;"></div>
    </div>
	</div>
	<div class="theme-notification">
        <div class="notification-header">
            <span class="wrap notification-heading"><h2><?php _e('Notifications', 'bizway'); ?></h2></span>
        </div>
        <div class="postbox-container" id="main">
            <div class="notification-box">
                <h3><?php _e("Get Themes email updates and a free WordPress ebook", "bizway"); ?></h3>
                <p><?php _e("We'll send you new updates about themes and WordPress and a free WordPress tips & tricks ebook!", 'bizway'); ?>
                </p>
                <div class = "form-container">
                    <form accept-charset="UTF-8" action="//www.formget.com/mailget/signups/subscribe/IjgwNCI_3D " name="mailget_form" method="post" onsubmit="return v_mailget()" >
                        <div class="form-button-container">
                            <input name="utf8" type="hidden" value="?"/>
                            <input name="subs_set_url" type="hidden" value="<?php echo esc_url($site_url); ?>"/>
                            <input name="subs_name" type="text" placeholder="<?php _e('Your Name', 'bizway'); ?>" required />
                            <input name="subs_email" type="email" value="<?php echo get_option('admin_email', 'email address'); ?>" required/>
                        </div>                           
                        <input type="submit" value="Subscribe and get a free ebook" name="subscribe" class="button button-primary">
                    </form>
                </div>
            </div>
            <div class="horizontal-line"></div>
            <div>
                <h3><?php _e('Get the bizway Pro Theme', 'bizway'); ?></h3>
                <p><?php _e('You are using the Lite Version of bizway Theme. Upgrade to Pro for extra features like Home Page Slider Contact Page, Gallery Features, Portfolio Page Template, FullWidth Page Templates, Multiple Color Options and much more.', 'bizway'); ?></p>
                <a class="button-primary" href="<?php echo esc_url($pro_theme_url); ?>" target="_blank"><?php _e('Get the bizway Pro', 'bizway'); ?></a>
            </div>
            <div class="horizontal-line"></div>
            <div>
                <h3><?php _e('Rate us on WordPress.org ', 'bizway'); ?></h3>
                <p><?php _e('Get Best Theme support. We are always ready to solve your queries. Just started your query at InkThemes.com', 'bizway'); ?></p>
                <a class="button-primary" href="<?php echo esc_url('http://www.inkthemes.com/community'); ?>" target="_blank"><?php _e('Get Free Support', 'bizway'); ?></a>
            </div>
        </div>
    </div>
    <!--wrap-->
    <?php
}

/* ----------------------------------------------------------------------------------- */
/* Load required javascripts for Options Page - of_load_only */
/* ----------------------------------------------------------------------------------- */

function bizway_admin_style() {
    wp_enqueue_style('bizway-adminstyle', get_template_directory_uri() . '/functions/admin-style.css', false);
}

add_action('init', 'bizway_admin_style');

function bizway_load_only() {
    add_action('admin_head', 'of_admin_head');

    wp_enqueue_script('jquery-ui-core');
    wp_register_script('jquery-input-mask', get_template_directory_uri() . '/functions/js/jquery.maskedinput-1.2.2.js', array('jquery'));
    wp_enqueue_script('jquery-input-mask');

    function of_admin_head() {
        // COLOR Picker 

        wp_enqueue_style('bizway-colorpicker', get_template_directory_uri() . '/functions/css/colorpicker.css', false);
        wp_enqueue_script('bizway-colorpicker', get_template_directory_uri() . '/functions/js/colorpicker.js', array('jquery'));
        ?>
        <script type="text/javascript" language="javascript">
            jQuery(document).ready(function () {
                //Color Picker
        <?php
        $options = bizway_get_option('of_template');

        foreach ($options as $option) {
            if ($option['type'] == 'color' OR $option['type'] == 'typography' OR $option['type'] == 'border') {
                if ($option['type'] == 'typography' OR $option['type'] == 'border') {
                    $option_id = $option['id'];
                    $temp_color = bizway_get_option($option_id);
                    $option_id = $option['id'] . '_color';
                    $color = $temp_color['color'];
                } else {
                    $option_id = $option['id'];
                    $color = bizway_get_option($option_id);
                }
                ?>
                        jQuery('#<?php echo $option_id; ?>_picker').children('div').css('backgroundColor', '<?php echo $color; ?>');
                        jQuery('#<?php echo $option_id; ?>_picker').ColorPicker({
                            color: '<?php echo $color; ?>',
                            onShow: function (colpkr) {
                                jQuery(colpkr).fadeIn(500);
                                return false;
                            },
                            onHide: function (colpkr) {
                                jQuery(colpkr).fadeOut(500);
                                return false;
                            },
                            onChange: function (hsb, hex, rgb) {
                                //jQuery(this).css('border','1px solid red');
                                jQuery('#<?php echo $option_id; ?>_picker').children('div').css('backgroundColor', '#' + hex);
                                jQuery('#<?php echo $option_id; ?>_picker').next('input').attr('value', '#' + hex);

                            }
                        });
                <?php
            }
        }
        ?>

            });

        </script>
        <?php
        //AJAX Upload
        wp_enqueue_script('bizway-ajaxupload', get_stylesheet_directory_uri() . '/functions/js/ajaxupload.js', array('jquery'));
        ?>
        <script type="text/javascript">
            jQuery(document).ready(function () {

                var flip = 0;

                jQuery('#expand_options').click(function () {
                    if (flip == 0) {
                        flip = 1;
                        jQuery('#of_container #of-nav').hide();
                        jQuery('#of_container #content').width(755);
                        jQuery('#of_container .group').add('#of_container .group h2').show();

                        jQuery(this).text('[-]');

                    } else {
                        flip = 0;
                        jQuery('#of_container #of-nav').show();
                        jQuery('#of_container #content').width(595);
                        jQuery('#of_container .group').add('#of_container .group h2').hide();
                        jQuery('#of_container .group:first').show();
                        jQuery('#of_container #of-nav li').removeClass('current');
                        jQuery('#of_container #of-nav li:first').addClass('current');

                        jQuery(this).text('[+]');

                    }

                });

                jQuery('.group').hide();
                jQuery('.group:first').fadeIn();

                jQuery('.group .collapsed').each(function () {
                    jQuery(this).find('input:checked').parent().parent().parent().nextAll().each(
                            function () {
                                if (jQuery(this).hasClass('last')) {
                                    jQuery(this).removeClass('hidden');
                                    return false;
                                }
                                jQuery(this).filter('.hidden').removeClass('hidden');
                            });
                });

                jQuery('.group .collapsed input:checkbox').click(unhideHidden);

                function unhideHidden() {
                    if (jQuery(this).attr('checked')) {
                        jQuery(this).parent().parent().parent().nextAll().removeClass('hidden');
                    }
                    else {
                        jQuery(this).parent().parent().parent().nextAll().each(
                                function () {
                                    if (jQuery(this).filter('.last').length) {
                                        jQuery(this).addClass('hidden');
                                        return false;
                                    }
                                    jQuery(this).addClass('hidden');
                                });

                    }
                }

                jQuery('.of-radio-img-img').click(function () {
                    jQuery(this).parent().parent().find('.of-radio-img-img').removeClass('of-radio-img-selected');
                    jQuery(this).addClass('of-radio-img-selected');

                });
                jQuery('.of-radio-img-label').hide();
                jQuery('.of-radio-img-img').show();
                jQuery('.of-radio-img-radio').hide();
                jQuery('#of-nav li:first').addClass('current');
                jQuery('#of-nav li a').click(function (evt) {

                    jQuery('#of-nav li').removeClass('current');
                    jQuery(this).parent().addClass('current');

                    var clicked_group = jQuery(this).attr('href');

                    jQuery('.group').hide();

                    jQuery(clicked_group).fadeIn();

                    evt.preventDefault();

                });

                if ('<?php
        if (isset($_REQUEST['reset'])) {
            echo $_REQUEST['reset'];
        } else {
            echo 'false';
        }
        ?>' == 'true') {

                    var reset_popup = jQuery('#of-popup-reset');
                    reset_popup.fadeIn();
                    window.setTimeout(function () {
                        reset_popup.fadeOut();
                    }, 2000);
                    //alert(response);

                }

                //Update Message popup
                jQuery.fn.center = function () {
                    this.animate({"top": (jQuery(window).height() - this.height() - 200) / 2 + jQuery(window).scrollTop() + "px"}, 100);
                    this.css("left", 250);
                    return this;
                }


                jQuery('#of-popup-save').center();
                jQuery('#of-popup-reset').center();
                jQuery(window).scroll(function () {

                    jQuery('#of-popup-save').center();
                    jQuery('#of-popup-reset').center();

                });



                //AJAX Upload
                jQuery('.image_upload_button').each(function () {

                    var clickedObject = jQuery(this);
                    var clickedID = jQuery(this).attr('id');
                    new AjaxUpload(clickedID, {
                        action: '<?php echo admin_url("admin-ajax.php"); ?>',
                        name: clickedID, // File upload name
                        data: {// Additional data to send
                            action: 'of_ajax_post_action',
                            type: 'upload',
                            data: clickedID,
                            option_nonce: jQuery('#bizway_option_nonce').val()
                        },
                        autoSubmit: true, // Submit file after selection
                        responseType: false,
                        onChange: function (file, extension) {
                        },
                        onSubmit: function (file, extension) {
                            clickedObject.text('Uploading'); // change button text, when user selects file	
                            this.disable(); // If you want to allow uploading only 1 file at time, you can disable upload button
                            interval = window.setInterval(function () {
                                var text = clickedObject.text();
                                if (text.length < 13) {
                                    clickedObject.text(text + '.');
                                }
                                else {
                                    clickedObject.text('Uploading');
                                }
                            }, 200);
                        },
                        onComplete: function (file, response) {
                            var data = JSON.parse(response);
                            window.clearInterval(interval);
                            clickedObject.text('Upload Image');
                            this.enable(); // enable upload button

                            // If there was an error
                            if (data.error) {
                                var buildReturn = '<span class="upload-error">' + data.error + '</span>';
                                jQuery(".upload-error").remove();
                                clickedObject.parent().after(buildReturn);

                            }
                            else {
                                var buildReturn = '<img class="hide of-option-image" id="image_' + clickedID + '" src="' + data.url + '" alt="" />';
                                jQuery(".upload-error").remove();
                                jQuery("#image_" + clickedID).remove();
                                clickedObject.parent().after(buildReturn);
                                jQuery('img#image_' + clickedID).fadeIn();
                                clickedObject.next('span').fadeIn();
                                clickedObject.parent().prev('input').val(data.url);
                            }
                        }
                    });

                });

                //AJAX Remove (clear option value)
                jQuery('.image_reset_button').click(function () {

                    var clickedObject = jQuery(this);
                    var clickedID = jQuery(this).attr('id');
                    var theID = jQuery(this).attr('title');

                    var ajax_url = '<?php echo admin_url("admin-ajax.php"); ?>';

                    var data = {
                        action: 'of_ajax_post_action',
                        type: 'image_reset',
                        data: theID,
                        option_nonce: jQuery('#bizway_option_nonce').val()
                    };

                    jQuery.post(ajax_url, data, function (response) {
                        var image_to_remove = jQuery('#image_' + theID);
                        var button_to_hide = jQuery('#reset_' + theID);
                        image_to_remove.fadeOut(500, function () {
                            jQuery(this).remove();
                        });
                        button_to_hide.fadeOut();
                        clickedObject.parent().prev('input').val('');



                    });

                    return false;

                });

                //Save everything else
                jQuery('#ofform').submit(function () {

                    function newValues() {
                        var serializedValues = jQuery("#ofform").serialize();
                        return serializedValues;
                    }
                    jQuery(":checkbox, :radio").click(newValues);
                    jQuery("select").change(newValues);
                    jQuery('.ajax-loading-img').fadeIn();
                    var serializedReturn = newValues();

                    var ajax_url = '<?php echo admin_url("admin-ajax.php"); ?>';

                    //var data = {data : serializedReturn};
                    var data = {
        <?php if (isset($_REQUEST['page']) && $_REQUEST['page'] == 'optionsframework') { ?>
                        type: 'options',
        <?php } ?>
                    action: 'of_ajax_post_action',
                            data: serializedReturn, option_nonce: jQuery('#bizway_option_nonce').val()
                    };

                    jQuery.post(ajax_url, data, function (response) {
                        var success = jQuery('#of-popup-save');
                        var loading = jQuery('.ajax-loading-img');
                        loading.fadeOut();
                        success.fadeIn();
                        window.setTimeout(function () {
                            success.fadeOut();


                        }, 2000);
                    });

                    return false;

                });

            });
        </script>
        <?php
    }

}

/* ----------------------------------------------------------------------------------- */
/* Ajax Save Action - bizway_ajax_callback */
/* ----------------------------------------------------------------------------------- */
add_action('wp_ajax_of_ajax_post_action', 'bizway_ajax_callback');

function bizway_ajax_callback() {
    global $wpdb; // this is how you get access to the database
    check_ajax_referer('bizwaytheme-update-option', 'option_nonce');

    $save_type = $_POST['type'];
    //Uploads
    if ($save_type == 'upload') {

        $clickedID = $_POST['data']; // Acts as the name
        $filename = $_FILES[$clickedID];
        $filename['name'] = preg_replace('/[^a-zA-Z0-9._\-]/', '', $filename['name']);

        $override['test_form'] = false;
        $override['action'] = 'wp_handle_upload';
        $uploaded_file = wp_handle_upload($filename, $override);

        $response = array();
        if (isset($uploaded_file) && ($uploaded_file['type'] == 'image/gif' || $uploaded_file['type'] == 'image/jpeg' || $uploaded_file['type'] == 'image/pjpeg' || $uploaded_file['type'] == 'image/png' || $uploaded_file['type'] == 'image/svg+xml' || $uploaded_file['type'] == 'image/x-icon')) {
            $upload_tracking[] = $clickedID;
            bizway_update_option($clickedID, $uploaded_file['url']);
            if (!empty($uploaded_file['error'])) {
                $response['error'] = __('Upload Error: ', 'bizway') . $uploaded_file['error'];
            } else {
                $response['url'] = $uploaded_file['url'];
            }
        } else {
            $response['error'] = __('Unsupported filetype uploaded.', 'bizway');
        } // Is the Response
        echo json_encode($response);
        die();
    } elseif ($save_type == 'image_reset') {

        $id = $_POST['data']; // Acts as the name
        bizway_delete_option($id);
    } elseif ($save_type == 'options' OR $save_type == 'framework') {
        $data = $_POST['data'];

        parse_str($data, $output);
        //print_r($output);
        //Pull options
        $options = bizway_options();

        foreach ($options['of_template'] as $option_array) {
            $id = $option_array['id'];
            $old_value = bizway_get_option($id);
            $new_value = '';

            if (isset($output[$id])) {
                $new_value = $output[$option_array['id']];
            }

            if (isset($option_array['id'])) { // Non - Headings...
                $type = $option_array['type'];

                if (is_array($type)) {
                    foreach ($type as $array) {
                        if ($array['type'] == 'text') {
                            $id = $array['id'];
                            $std = $array['std'];
                            $new_value = $output[$id];
                            if ($new_value == '') {
                                $new_value = $std;
                            }
                            bizway_update_option($id, stripslashes($new_value));
                        }
                    }
                } elseif ($new_value == '' && $type == 'checkbox') { // Checkbox Save
                    bizway_update_option($id, 'false');
                } elseif ($new_value == 'true' && $type == 'checkbox') { // Checkbox Save
                    bizway_update_option($id, 'true');
                } elseif ($type == 'multicheck') { // Multi Check Save
                    $option_options = $option_array['options'];

                    foreach ($option_options as $options_id => $options_value) {

                        $multicheck_id = $id . "_" . $options_id;

                        if (!isset($output[$multicheck_id])) {
                            bizway_update_option($multicheck_id, 'false');
                        } else {
                            bizway_update_option($multicheck_id, 'true');
                        }
                    }
                } elseif ($type == 'typography') {

                    $typography_array = array();

                    $typography_array['size'] = $output[$option_array['id'] . '_size'];

                    $typography_array['face'] = stripslashes($output[$option_array['id'] . '_face']);

                    $typography_array['style'] = $output[$option_array['id'] . '_style'];

                    $typography_array['color'] = $output[$option_array['id'] . '_color'];

                    bizway_update_option($id, $typography_array);
                } elseif ($type == 'border') {

                    $border_array = array();

                    $border_array['width'] = $output[$option_array['id'] . '_width'];

                    $border_array['style'] = $output[$option_array['id'] . '_style'];

                    $border_array['color'] = $output[$option_array['id'] . '_color'];

                    bizway_update_option($id, $border_array);
                } elseif ($type != 'upload_min') {

                    bizway_update_option($id, stripslashes($new_value));
                }
            }
        }
    }
    die();
}

/* ----------------------------------------------------------------------------------- */
/* Generates The Options Within the Panel - optionsframework_machine */
/* ----------------------------------------------------------------------------------- */

function bizway_optionsframework_machine($options) {
    $option_name = '';
    $counter = 0;
    $menu = '';
    $output = '';
    foreach ($options['of_template'] as $value) {

        $counter++;
        $val = '';
        //Start Heading
        if ($value['type'] != "heading") {
            $class = '';
            if (isset($value['class'])) {
                $class = $value['class'];
            }
            //$output .= '<div class="section section-'. $value['type'] .'">'."\n".'<div class="option-inner">'."\n";
            $output .= '<div class="section section-' . $value['type'] . ' ' . $class . '">' . "\n";
            $output .= '<h3 class="heading">' . $value['name'] . '</h3>' . "\n";
            $output .= '<div class="option">' . "\n" . '<div class="controls">' . "\n";
        }
        //End Heading
        $select_value = '';
        switch ($value['type']) {

            case 'text':
                $val = $value['std'];
                $std = bizway_get_option($value['id']);
                if ($std != "") {
                    $val = $std;
                }
                $output .= '<input class="of-input" name="' . $value['id'] . '" id="' . $value['id'] . '" type="' . $value['type'] . '" value="' . $val . '" />';
                break;

            case 'select':
                $output .= '<select class="of-input" name="' . $value['id'] . '" id="' . $value['id'] . '">';

                $select_value = bizway_get_option($value['id']);

                foreach ($value['options'] as $option) {

                    $selected = '';

                    if ($select_value != '') {
                        if ($select_value == $option) {
                            $selected = selected($options);
                        }
                    } else {
                        if (isset($value['std']))
                            if ($value['std'] == $option) {
                                $selected = selected();
                            }
                    }

                    $output .= '<option' . $selected . '>';
                    $output .= $option;
                    $output .= '</option>';
                }
                $output .= '</select>';

                break;




            case 'textarea':

                $cols = '8';
                $ta_value = '';

                if (isset($value['std'])) {

                    $ta_value = $value['std'];

                    if (isset($value['options'])) {
                        $ta_options = $value['options'];
                        if (isset($ta_options['cols'])) {
                            $cols = $ta_options['cols'];
                        } else {
                            $cols = '8';
                        }
                    }
                }
                $std = bizway_get_option($value['id']);
                if ($std != "") {
                    $ta_value = stripslashes($std);
                }
                $output .= '<textarea class="of-input" name="' . $value['id'] . '" id="' . $value['id'] . '" cols="' . $cols . '" rows="8">' . $ta_value . '</textarea>';


                break;
            case "radio":
                $select_value = bizway_get_option($value['id']);

                foreach ($value['options'] as $key => $option) {
                    $checked = '';
                    if ($select_value != '') {
                        if ($select_value == $key) {
                            $checked = ' checked';
                        }
                    } else {
                        if ($value['std'] == $key) {
                            $checked = ' checked';
                        }
                    }
                    $output .= '<input class="of-input of-radio" type="radio" name="' . $value['id'] . '" value="' . $key . '" ' . $checked . ' />' . $option . '<br />';
                }
                break;
            case "checkbox":
                $output .= '<input id="' . esc_attr($value['id']) . '" class="checkbox of-input" type="checkbox" name="' . esc_attr($option_name . '[' . $value['id'] . ']') . '" ' . checked($val, 1, false) . ' />';
                $output .= '<label class="explain" for="' . esc_attr($value['id']) . '">' . wp_kses($explain_value, $allowedtags) . '</label>';
                break;
            case "multicheck":
                foreach ($value['options'] as $key => $option) {
                    $checked = '';
                    $label = $option;
                    $option = preg_replace('/[^a-zA-Z0-9._\-]/', '', strtolower($key));
                    $id = $option_name . '-' . $value['id'] . '-' . $option;
                    $name = $option_name . '[' . $value['id'] . '][' . $option . ']';
                    if (isset($val[$option])) {
                        $checked = checked($val[$option], 1, false);
                    }
                    $output .= '<input id="' . esc_attr($id) . '" class="checkbox of-input" type="checkbox" name="' . esc_attr($name) . '" ' . $checked . ' /><label for="' . esc_attr($id) . '">' . esc_html($label) . '</label>';
                }
                break;
            case "upload":
                $value['std'] = '';
                if (isset($value['std'])) {
                    $output .= bizway_optionsframework_uploader_function($value['id'], $value['std'], null);
                }
                break;
            case "upload_min":

                $output .= bizway_optionsframework_uploader_function($value['id'], $value['std'], 'min');

                break;
            case "color":
                $val = $value['std'];
                $stored = bizway_get_option($value['id']);
                if ($stored != "") {
                    $val = $stored;
                }
                $output .= '<div id="' . $value['id'] . '_picker" class="colorSelector"><div></div></div>';
                $output .= '<input class="of-color" name="' . $value['id'] . '" id="' . $value['id'] . '" type="text" value="' . $val . '" />';
                break;

            case "typography":

                $default = $value['std'];
                $typography_stored = bizway_get_option($value['id']);

                /* Font Size */
                $val = $default['size'];
                if ($typography_stored['size'] != "") {
                    $val = $typography_stored['size'];
                }
                $output .= '<select class="of-typography of-typography-size" name="' . $value['id'] . '_size" id="' . $value['id'] . '_size">';
                for ($i = 9; $i < 71; $i++) {
                    if ($val == $i) {
                        $active = selected();
                    } else {
                        $active = '';
                    }
                    $output .= '<option value="' . $i . '" ' . $active . '>' . $i . 'px</option>';
                }
                $output .= '</select>';

                /* Font Face */
                $val = $default['face'];
                if ($typography_stored['face'] != "")
                    $val = $typography_stored['face'];
                $font01 = '';
                $font02 = '';
                $font03 = '';
                $font04 = '';
                $font05 = '';
                $font06 = '';
                $font07 = '';
                $font08 = '';
                $font09 = '';
                if (strpos($val, 'Arial, sans-serif') !== false) {
                    $font01 = selected();
                }
                if (strpos($val, 'Verdana, Geneva') !== false) {
                    $font02 = selected();
                }
                if (strpos($val, 'Trebuchet') !== false) {
                    $font03 = selected();
                }
                if (strpos($val, 'Georgia') !== false) {
                    $font04 = selected();
                }
                if (strpos($val, 'Times New Roman') !== false) {
                    $font05 = selected();
                }
                if (strpos($val, 'Tahoma, Geneva') !== false) {
                    $font06 = selected();
                }
                if (strpos($val, 'Palatino') !== false) {
                    $font07 = selected();
                }
                if (strpos($val, 'Helvetica') !== false) {
                    $font08 = selected();
                }

                $output .= '<select class="of-typography of-typography-face" name="' . $value['id'] . '_face" id="' . $value['id'] . '_face">';
                $output .= '<option value="Arial, sans-serif" ' . $font01 . '>Arial</option>';
                $output .= '<option value="Verdana, Geneva, sans-serif" ' . $font02 . '>Verdana</option>';
                $output .= '<option value="&quot;Trebuchet MS&quot;, Tahoma, sans-serif"' . $font03 . '>Trebuchet</option>';
                $output .= '<option value="Georgia, serif" ' . $font04 . '>Georgia</option>';
                $output .= '<option value="&quot;Times New Roman&quot;, serif"' . $font05 . '>Times New Roman</option>';
                $output .= '<option value="Tahoma, Geneva, Verdana, sans-serif"' . $font06 . '>Tahoma</option>';
                $output .= '<option value="Palatino, &quot;Palatino Linotype&quot;, serif"' . $font07 . '>Palatino</option>';
                $output .= '<option value="&quot;Helvetica Neue&quot;, Helvetica, sans-serif" ' . $font08 . '>Helvetica*</option>';
                $output .= '</select>';

                /* Font Weight */
                $val = $default['style'];
                if ($typography_stored['style'] != "") {
                    $val = $typography_stored['style'];
                }
                $normal = '';
                $italic = '';
                $bold = '';
                $bolditalic = '';
                if ($val == 'normal') {
                    $normal = selected();
                }
                if ($val == 'italic') {
                    $italic = selected();
                }
                if ($val == 'bold') {
                    $bold = selected();
                }
                if ($val == 'bold italic') {
                    $bolditalic = selected();
                }

                $output .= '<select class="of-typography of-typography-style" name="' . $value['id'] . '_style" id="' . $value['id'] . '_style">';
                $output .= '<option value="normal" ' . $normal . '>Normal</option>';
                $output .= '<option value="italic" ' . $italic . '>Italic</option>';
                $output .= '<option value="bold" ' . $bold . '>Bold</option>';
                $output .= '<option value="bold italic" ' . $bolditalic . '>Bold/Italic</option>';
                $output .= '</select>';

                /* Font Color */
                $val = $default['color'];
                if ($typography_stored['color'] != "") {
                    $val = $typography_stored['color'];
                }
                $output .= '<div id="' . $value['id'] . '_color_picker" class="colorSelector"><div></div></div>';
                $output .= '<input class="of-color of-typography of-typography-color" name="' . $value['id'] . '_color" id="' . $value['id'] . '_color" type="text" value="' . $val . '" />';
                break;

            case "border":

                $default = $value['std'];
                $border_stored = bizway_get_option($value['id']);

                /* Border Width */
                $val = $default['width'];
                if ($border_stored['width'] != "") {
                    $val = $border_stored['width'];
                }
                $output .= '<select class="of-border of-border-width" name="' . $value['id'] . '_width" id="' . $value['id'] . '_width">';
                for ($i = 0; $i < 21; $i++) {
                    if ($val == $i) {
                        $active = selected();
                    } else {
                        $active = '';
                    }
                    $output .= '<option value="' . $i . '" ' . $active . '>' . $i . 'px</option>';
                }
                $output .= '</select>';

                /* Border Style */
                $val = $default['style'];
                if ($border_stored['style'] != "") {
                    $val = $border_stored['style'];
                }
                $solid = '';
                $dashed = '';
                $dotted = '';
                if ($val == 'solid') {
                    $solid = selected();
                }
                if ($val == 'dashed') {
                    $dashed = selected();
                }
                if ($val == 'dotted') {
                    $dotted = selected();
                }

                $output .= '<select class="of-border of-border-style" name="' . $value['id'] . '_style" id="' . $value['id'] . '_style">';
                $output .= '<option value="solid" ' . $solid . '>Solid</option>';
                $output .= '<option value="dashed" ' . $dashed . '>Dashed</option>';
                $output .= '<option value="dotted" ' . $dotted . '>Dotted</option>';
                $output .= '</select>';

                /* Border Color */
                $val = $default['color'];
                if ($border_stored['color'] != "") {
                    $val = $border_stored['color'];
                }
                $output .= '<div id="' . $value['id'] . '_color_picker" class="colorSelector"><div></div></div>';
                $output .= '<input class="of-color of-border of-border-color" name="' . $value['id'] . '_color" id="' . $value['id'] . '_color" type="text" value="' . $val . '" />';
                break;
            case "images":
                $name = $option_name . '[' . $value['id'] . ']';
                foreach ($value['options'] as $key => $option) {
                    $selected = '';
                    $checked = '';
                    if ($val != '') {
                        if ($val == $key) {
                            $selected = ' of-radio-img-selected';
                        }
                        checked($options['$key'], $val);
                    }
                    $output .= '<input type="radio" id="' . esc_attr($value['id'] . '_' . $key) . '" class="of-radio-img-radio" value="' . esc_attr($key) . '" name="' . esc_attr($name) . '" ' . $checked . ' />';
                    $output .= '<div class="of-radio-img-label">' . esc_html($key) . '</div>';
                    $output .= '<img src="' . esc_url($option) . '" alt="' . $option . '" class="of-radio-img-img' . $selected . '" onclick="document.getElementById(\'' . esc_attr($value['id'] . '_' . $key) . '\').checked=true;" />';
                }
                break;

            case "info":
                $default = $value['std'];
                $output .= $default;
                break;

            case "heading":

                if ($counter >= 2) {
                    $output .= '</div>' . "\n";
                }
                $jquery_click_hook = preg_replace("/[^a-zA-Z0-9._\-]/", "", strtolower($value['name']));
                $jquery_click_hook = "of-option-" . esc_attr($jquery_click_hook);
                $menu .= '<li><a title="' . $value['name'] . '" href="#' . $jquery_click_hook . '">' . $value['name'] . '</a></li>';
                $output .= '<div class="group" id="' . $jquery_click_hook . '"><h2>' . $value['name'] . '</h2>' . "\n";
                break;
        }

        // if TYPE is an array, formatted into smaller inputs... ie smaller values
        if (is_array($value['type'])) {
            foreach ($value['type'] as $array) {

                $id = $array['id'];
                $std = $array['std'];
                $saved_std = bizway_get_option($id);
                if ($saved_std != $std) {
                    $std = $saved_std;
                }
                $meta = $array['meta'];

                if ($array['type'] == 'text') { // Only text at this point
                    $output .= '<input class="input-text-small of-input" name="' . $id . '" id="' . $id . '" type="text" value="' . $std . '" />';
                    $output .= '<span class="meta-two">' . $meta . '</span>';
                }
            }
        }
        if ($value['type'] != "heading") {
            if ($value['type'] != "checkbox") {
                $output .= '<br/>';
            }
            if (!isset($value['desc'])) {
                $explain_value = '';
            } else {
                $explain_value = $value['desc'];
            }
            $output .= '</div><div class="explain">' . $explain_value . '</div>' . "\n";
            $output .= '<div class="clear"> </div></div></div>' . "\n";
        }
    }
    $output .= '</div>';
    return array($output, $menu);
}

/* ----------------------------------------------------------------------------------- */
/* OptionsFramework Uploader - bizway_optionsframework_uploader_function */
/* ----------------------------------------------------------------------------------- */

function bizway_optionsframework_uploader_function($id, $std, $mod) {
    //$uploader .= '<input type="file" id="attachement_'.$id.'" name="attachement_'.$id.'" class="upload_input"></input>';
    //$uploader .= '<span class="submit"><input name="save" type="submit" value="Upload" class="button upload_save" /></span>';

    $uploader = '';
    $upload = bizway_get_option($id);

    if ($mod != 'min') {
        $val = $std;
        if (bizway_get_option($id) != "") {
            $val = bizway_get_option($id);
        }
        $uploader .= '<input class=\'of-input\' name=\'' . $id . '\' id=\'' . $id . '_upload\' type=\'text\' value=\'' . str_replace("'", "", $val) . '\' readonly />';
    }

    $uploader .= '<div class="upload_button_div"><span class="button image_upload_button" id="' . $id . '">' . __('Upload Image', 'bizway') . '</span>';

    if (!empty($upload)) {
        $hide = '';
    } else {
        $hide = 'hide';
    }

    $uploader .= '<span class="button image_reset_button ' . $hide . '" id="reset_' . $id . '" title="' . $id . '">' . __('Remove', 'bizway') . '</span>';
    $uploader .='</div>' . "\n";
    $uploader .= '<div class="clear"></div>' . "\n";
    $findme = 'wp-content/uploads';
    $imgvideocheck = strpos($upload, $findme);
    if ((!empty($upload)) && ($imgvideocheck === true)) {
        $uploader .= '<a class="of-uploaded-image" href="' . $upload . '">';
        $uploader .= '<img class="of-option-image" id="image_' . $id . '" src="' . $upload . '" alt="" />';
        $uploader .= '</a>';
    }
    $uploader .= '<div class="clear"></div>' . "\n";
    return $uploader;
}
?>