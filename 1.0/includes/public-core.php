<?php
/**
 * injector.php()
 *
 * injects the Netbible Tagger code intot he footer and header
 * of all user end Wordpress pages.
 *
 * @package	Netbible Tagger Reloaded
 * @since 	1.0
 * @author 	Adam (Zerzix) Kellogg
 * @uses 	add_action()
 */
if (!defined('ABSPATH')) {
	exit("Sorry, you are not allowed to access this page directly.");
}

global $wp_netbible_tagger_options;
//load netbibler tagger options from database
$wp_netbible_tagger_options = get_option('wp-netbible-tagger-options');

//Write Netbible Tagger code.
if (! function_exists('wp_netbible_tagger_footer')) {
	function wp_netbible_tagger_footer() {
		global $wp_netbible_tagger_options;
		echo '<script type="text/javascript" defer="defer" src="http://labs.bible.org/api/NETBibleTagger/netbibletagger.js">';
		if ( isset( $wp_netbible_tagger_options['voidOnMouseOut'] ) && 1 == $wp_netbible_tagger_options['voidOnMouseOut'] )
			echo ' org.bible.NETBibleTagger.voidOnMouseOut = true;';
		if ( isset( $wp_netbible_tagger_options['parseAnchors'] ) && 1 == $wp_netbible_tagger_options['parseAnchors'])
			echo ' org.bible.NETBibleTagger.parseAnchors = true;';
		if ( isset( $wp_netbible_tagger_options['customCSS'] ) && 1 == $wp_netbible_tagger_options['customCSS'])
			echo ' org.bible.NETBibleTagger.customCSS = true;';
		echo '</script>';
	}
}

// write Custom CSS for NETBible Tagger
if (! function_exists('wp_netbible_tagger_css_header')) {
	function wp_netbible_tagger_css_header() {
		global $wp_netbible_tagger_options;
		$wp_netbible_tagger_css = 	get_option('wp-netbible-tagger-css');
		if ( isset( $wp_netbible_tagger_options['customCSS'] ) && 1 == $wp_netbible_tagger_options['customCSS'] && isset( $wp_netbible_tagger_css ) && !empty( $wp_netbible_tagger_css) ) {
			echo '<style type="text/css">';
			echo stripslashes( $wp_netbible_tagger_css );
			echo '</style>';
		}
	}
}

//Add Netbible Tagger code to the footer of every page.
add_action('wp_footer', 'wp_netbible_tagger_footer', 40);
//Add custome CSS to header.
add_action( 'wp_head', 'wp_netbible_tagger_css_header' );
?>