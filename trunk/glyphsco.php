<?php 

/*
Plugin Name: Glyphs.co
Plugin URI: https://glyphs.co
Description: The easiest way to integrate your Glyphs.co Account with Wordpress. Search for images to embed and icons to use with your Premium Glyphs.co account right in the WordPress backend.
Version: 0.3
Author: Glyphs.co
Author URI: https://glyphs.co
License: Copyright 2016 Glyphs.co
*/

/* Add visual editor help to add an SVG icon */ 
	/* - that's already in your kit or find a new one and add it to the selected kit */
/* Add media browser to select Glyphs.co photos and add to your posts */
	/* - make sure this uses the embed tagging */
	
	
/* Eventually add goal tracking options on a per page or whole-site basis */



/* CREATE SETTINGS PAGE */

	add_action('admin_menu', 'glyphsco_custom_admin_menu');
	
	function glyphsco_custom_admin_menu() {
	    add_menu_page('Glyphs.co Options', 'Glyphs.co', 'add_users','glyphsco_options', 'glyphsco_options_page', plugins_url() .'/glyphs-company/img/glyphs-squares-16px.png');
		add_action( 'admin_init', 'register_glyphsco_settings' );
	 }
	
	function register_glyphsco_settings() {
		register_setting( 'glyphsco_options', 'glyphsco_kitid' );
		register_setting( 'glyphsco_options', 'glyphsco_apikey' );
	 } 
	
	function glyphsco_options_page() { ?>
	
	<link rel="stylesheet" href="<?php echo plugins_url(); ?>/glyphs-company/plugin-styles.css" type="text/css" media="all" />
	
	<div class="wrap glyphsco">
				
		<div class="main-content col col-2">
			<h2><img src="<?php echo plugins_url() .'/glyphs-company/img/glyphs-logo.png'; ?>" width="150"  alt="Glyphs.co Logo" /></h2>
		    <form method="post" action="options.php">
		        <?php settings_fields( 'glyphsco_options' ); ?>
		        <p>
		        	<label>Your 6-digit Kit ID</label><br/>
		        	<small>Like "27H529"</small>
		        </p>
		        <input type="text" name="glyphsco_kitid" value="<?php echo get_option('glyphsco_kitid'); ?>" />
		        <!--<p>
		        	<label>Your API Key for this kit</label><br/>
		        </p>
		        <input type="text" name="glyphsco_apikey" value="<?php echo get_option('glyphsco_apikey'); ?>" />-->
		        
		        <p class="submit">
		        <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
		        </p>
		    </form>
		</div>
		<div class="sidebar col col-4">
			<h3>How to use the Glyphs Shortcode</h3>
			<p>The shortcode is basically <pre>[glyphs]</pre> but you'll need at least one parameter filled in. If you want to copy and paste the svg code from Glyphs.co to use, we recommend using <pre>[glyphs svg='']</pre> and putting the SVG tag inside the single quotes of the SVG parameter. For example:<pre>[glyphs svg='<?php echo htmlentities("<svg class='glyphs signia key' style='width:100px;'><use xlink:href='#signia-key'></use></svg>"); ?>']</pre></p>
			<p>Alternatively, you can use the class and id parameters simultaneously and pass any inline css with the css parameter. Like this:<pre>[glyphs class="glyphs signia key" id="signia-key" css="width:100px;"]</pre></p>
			<p>Note that if you use the class or id parameters, they must both be filled in to work properly.</p>
			<p>This shortcode will output the SVG in your posts and pages correctly and won't be overridden by the Visual editor.</p>
		</div>
		<div class="clear"></div>
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

/* Prevent Visual editor from scrubbing the <svg> tags */
//[foobar]
function glyphsco_shortcode( $atts ){
	if ($atts['class']){
		$class = $atts['class'];
	} else {
		$class = '';
	}
	if ($atts['id']) {
		$id = $atts['id'];
	} else {
		$id = '';
	}
	if ($atts['css']){
		$css = $atts['css'];
	} else { 
		$css = '';
	}
	if ($atts['svg']){
		$svg = $atts['svg'];
		return html_entity_decode($svg);
	} else {
		return "<svg class='$class' style='$css'><use xlink:href='#$id'></use></svg>";
	}
	
	
}
add_shortcode( 'glyphs', 'glyphsco_shortcode' );



// add new buttons
function my_mce_buttons_2( $buttons ) {	
	/**
	 * Add in a core button that's disabled by default
	 */
	

	return $buttons;
}
add_filter( 'mce_buttons_2', 'my_mce_buttons_2' );


add_filter( 'mce_buttons', 'glyphsco_register_buttons' );

function glyphsco_register_buttons( $buttons ) {
   array_push( $buttons, 'separator', 'glyphsco' );
   return $buttons;
}




