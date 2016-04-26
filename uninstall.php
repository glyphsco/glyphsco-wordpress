<?php 


if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit();
}
 
$option_name = 'glyphsco_kitid';
 
delete_option( $option_name );
 
// For site options in Multisite
delete_site_option( $option_name ); 

