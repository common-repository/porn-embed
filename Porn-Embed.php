<?php
/*
Plugin Name: Porn Embed
Plugin URI: http://scobiform.com/wordpress-porn-embed-plugin
Description: Adds Embed support for xhamster.com, xvideos.com, youporn.com, tub8.com and pornhub.com in WordPress posts, pages and custom post types.
Version: 0.0.3
Author: Scobiform
Author URI: http://scobiform.com
License: GPL2
*/
//######################################################
//CSS Styling
//######################################################
function porn_embed_stylesheet() {
    wp_register_style( 'porn_embed_style', plugins_url('style.css', __FILE__) );
    wp_enqueue_style( 'porn_embed_style' );
} 
add_action( 'wp_enqueue_scripts', 'porn_embed_stylesheet' );

//######################################################
//Porn Hosts Handlers
//######################################################

//Xhamster embed Handler
wp_embed_register_handler( 'xhamster', '#http://.*\.xhamster.com/movies/(.+?)($|&)#i', 'wp_embed_handler_xhamster' );

function wp_embed_handler_xhamster( $matches, $attr, $url, $rawattr ) {

	$embed = sprintf(
			'<div id="pornembed"><iframe src="http://xhamster.com/xembed.php?video=%1$s"></iframe></div>',
			esc_attr($matches[1])
			);
	return apply_filters( 'embed_xhamster', $embed, $matches, $attr, $url, $rawattr );
}

//Xvideos embed Handler
wp_embed_register_handler( 'xvideos', '#http://.*\.xvideos.com/video(.+?)($|&)#i', 'wp_embed_handler_xvideos' );

function wp_embed_handler_xvideos( $matches, $attr, $url, $rawattr ) {

	$embed = sprintf(
			'<div id="pornembed"><iframe src="http://www.xvideos.com/embedframe/%1$s"></iframe></div>',
			esc_attr($matches[1])
			);
	return apply_filters( 'embed_xvideos', $embed, $matches, $attr, $url, $rawattr );
}

//Pornhub embed Handler
wp_embed_register_handler( 'pornhub', '#http://.*\.pornhub.com/view_video.php\?viewkey=(.+?)($|&)#i', 'wp_embed_handler_pornhub' );


function wp_embed_handler_pornhub( $matches, $attr, $url, $rawattr ) {

	$embed = sprintf(
			'<div id="pornembed"><iframe src="http://www.pornhub.com/embed/%1$s" class="noScrolling"></iframe></div>',
			esc_attr($matches[1])
			);

	return apply_filters( 'embed_pornhub', $embed, $matches, $attr, $url, $rawattr );
}


//Youporn embed Handler
wp_embed_register_handler( 'youporn', '#http://.*\.youporn.com/watch/(.+)#i', 'wp_embed_handler_youporn' );


function wp_embed_handler_youporn( $matches, $attr, $url, $rawattr ) {

	$embed = sprintf(
			'<div id="pornembed"><iframe src="http://www.youporn.com/embed/%1$s" class="noScrolling"></iframe></div>',
			esc_attr($matches[1])
			);

	return apply_filters( 'embed_youporn', $embed, $matches, $attr, $url, $rawattr );
}

//Tube8 embed Handler
wp_embed_register_handler( 'tube8', '#http://.*\.tube8.com/(.+)#i', 'wp_embed_handler_tube8' );


function wp_embed_handler_tube8( $matches, $attr, $url, $rawattr ) {

	$embed = sprintf(
			'<div id="pornembed"><iframe src="http://www.tube8.com/embed/%1$s" class="noScrolling"></iframe></div>',
			esc_attr($matches[1])
			);

	return apply_filters( 'embed_tube8', $embed, $matches, $attr, $url, $rawattr );
}



//######################################################
//ADMIN MENU
//######################################################

add_action('admin_menu', 'porn_embed_menu');

function porn_embed_menu() {

	//create new top-level menu
	add_menu_page('Porn Embed Settings', 'Porn Embed', 'administrator', __FILE__, 'porn_embed_settings_page' , plugins_url('/images/icon.svg', __FILE__) );

	//call register settings function
	add_action( 'admin_init', 'register_porn_embed_settings' );
}


function register_porn_embed_settings() {
	//register our settings
	register_setting( 'porn-embed-settings-group', 'iframe_height' );
}

function porn_embed_settings_page() {
?>
<div class="wrap">
<h2>Porn Embed Settings</h2>
<p>Here you can adjust the iFrame Height</p>
<form method="post" action="options.php">
    <?php settings_fields( 'porn-embed-settings-group' ); ?>
    <?php do_settings_sections( 'porn-embed-settings-group' ); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">Height</th>
        <td><input type="text" name="new_option_name" value="<?php echo esc_attr( get_option('iframe_height') ); ?>" /></td>
        </tr>
    </table>   
    <?php submit_button(); ?>
</form>
</div><?php } 








//######################################################
//Whitespace Fix
/*
Author: Michal "Wejn" Jirků {box at wejn dot org}
License: MIT
Version: 2.1*/
//######################################################

function ___wejns_wp_whitespace_fix($input) {
	/* valid content-type? */
	$allowed = false;

	/* found content-type header? */
	$found = false;

	/* we mangle the output if (and only if) output type is text/* */
	foreach (headers_list() as $header) {
		if (preg_match("/^content-type:\\s+(text\\/|application\\/((xhtml|atom|rss)\\+xml|xml))/i", $header)) {
			$allowed = true;
		}

		if (preg_match("/^content-type:\\s+/i", $header)) {
			$found = true;
		}
	}

	/* do the actual work */
	if ($allowed || !$found) {
		return preg_replace("/\\A\\s*/m", "", $input);
	} else {
		return $input;
	}
}

/* start output buffering using custom callback */
ob_start("___wejns_wp_whitespace_fix");


?>





