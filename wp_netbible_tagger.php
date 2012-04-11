<?php
/*
 Plugin Name: NETBible Tagger Reloaded
Plugin URI: http://www.kelloggskorner.com
Description: Automatically insert NETBible Tagger into your footer(For Wordpress 3+)<br/>Powered by <a href="http://labs.bible.org/NETBibleTagger">NETBible Tagger</a>
Author: Adam (zerzix) Kellogg
Version: 1.1
Author URI: http://www.kelloggskorner.com
*/

/*  Copyright 2012  Adam (Zerzix) Kellogg  (email : adam@kelloggskorner.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
 * wp_netbible_tagger.php
*
* Net Bible Tagger reloaded is a wordpress plugin use to customize and inject the
* netbible Tagger code into user facing Wordpress pages. It has been streamlined
* to load only the functions needed for User or Admin sections based on wether you
* are loged into the dashboard or looking at one of the display pages.
*
* @package	Netbible Tagger Reloaded
* @since 	1.0
* @author 	Adam (Zerzix) Kellogg
* @uses 	is_admin()
* @requires	dashbord.php
* @requires	injector.php
*/
/* Prevent direct access to the plugin */
if (!defined('ABSPATH')) {
	exit("Sorry, you are not allowed to access this page directly.");
}

/* Set constants for plugin */
define( 'WP_NETBIBLE_TAGGER_URL', WP_PLUGIN_URL.'/netbible-tagger-reloaded' );
define( 'WP_NETBIBLE_TAGGER_DIR', WP_PLUGIN_DIR.'/netbible-tagger-reloaded' );
define( 'WP_NETBIBLE_TAGGER_VER', '1.2' );
define( 'WP_NETBIBLE_TAGGER_NAME', 'NETBile Tagger' );
define( 'WP_NETBIBLE_TAGGER_DOMAIN', 'wp-netbible-tagger' );
define( 'WP_NETBIBLE_TAGGER_WP_VERSION_REQ', '3.3' );
define( 'WP_NETBIBLE_TAGGER_FILE_NAME', 'netbible-tagger-reloaded/wp-netbible-tagger.php' );
define( 'WP_NETBIBLE_TAGGER_FILE_HOOK', 'wp_netbible_tagger' );
define( 'WP_NETBIBLE_TAGGER_PAGEHOOK', WP_NETBIBLE_TAGGER_FILE_HOOK.'_options_page');


/***** Load files needed for plugin to run ********************/

/* 	Load files needed for plugin to run
 *
*	Required for Serial Posts list display
*	public-core.php				Template tag, shortcode functions
*
*	Required for Admin
*	admin-core.php					Main Admin Functions: add page and related functions, options handling/upgrading
*
*	@since	1.0
*/
// Public files
if( !is_admin() ) {
	include_once( WP_NETBIBLE_TAGGER_DIR . '/includes/public-core.php');
}

// Admin-only files
if( is_admin() ) {
	require_once( WP_NETBIBLE_TAGGER_DIR . '/includes/admin-core.php');
}
?>