<?php 

/*
Plugin Name: Glyphs.co
Plugin URI: https://glyphs.co
Description: The easiest way to integrate your Glyphs.co Account with Wordpress. Search for images to embed and icons to use with your Premium Glyphs.co account right in the WordPress backend.
Version: 0.1
Author: Glyphs.co
Author URI: https://glyphs.co
License: Copyright 2016 Glyphs.co
*/



/* Add link to kit in backend header */
/* Add link to kit in frontend theme */
/* Prevent Visual editor from scrubbing the <svg> tags */
/* Add visual editor help to add an SVG icon */ 
	/* - that's already in your kit or find a new one and add it to the selected kit */
/* Add media browser to select Glyphs.co photos and add to your posts */
	/* - make sure this uses the embed tagging */
	
	
/* Eventually add goal tracking options on a per page or whole-site basis */



/* CREATE SETTINGS PAGE */

add_action('admin_menu', 'glyphsco_custom_admin_menu');

function glyphsco_custom_admin_menu() {
    add_menu_page('Glyphs.co Options', 'Glyphs.co', 'add_users','glyphsco_options', 'glyphsco_options_page', plugins_url() .'/glyphsco/img/glyphs-squares-16px.png');
	add_action( 'admin_init', 'register_glyphsco_settings' );
 }

function register_glyphsco_settings() {
	register_setting( 'glyphsco_options', 'glyphsco_kitid' );
 } 

function glyphsco_options_page() { ?>

<div class="wrap">
<h2>Glyphs.co Options</h2>
    <form method="post" action="options.php">
        <?php settings_fields( 'glyphsco_options' ); ?>
        <p>
        	<label>Your 6-digit Kit ID</label><br/>
        	<small>Like "27H529"</small>
        </p>
        <input type="text" name="glyphsco_kitid" value="<?php echo get_option('glyphsco_kitid'); ?>" />
        <p class="submit">
        <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
        </p>
    </form>
</div>

<?php }

/* END CREATE SETTINGS PAGE */

/* ADD LINK TO FRONTEND HEADER */
add_action('wp_head', 'glyphsco_frontend_insert');

function glyphsco_frontend_insert(){
	$output='<script type="text/javascript" src="//kit.glyphs.co/'.get_option('glyphsco_kitid').'.js"></script>';
	echo $output;
}
/* END ADD LINK TO FRONTEND HEADER */


/* ADD LINK TO BACKEND HEADER */
add_action('admin_head', 'glyphsco_backend_insert');

function glyphsco_backend_insert(){
	$output='<script type="text/javascript" src="//kit.glyphs.co/'.get_option('glyphsco_kitid').'.js"></script>';
	echo $output;
}
/* END ADD LINK TO BACKEND HEADER */