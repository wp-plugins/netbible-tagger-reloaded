<?php
/**
 * dashboard.php
 *
 * This is used to load all the admin functions if Wordpress is accessed
 * through the dashboard.
 *
 * @package	Netbible Tagger Reloaded
 * @since 	1.0
 * @author 	Adam (Zerzix) Kellogg
 * @uses 	is_admin()
 */
/* Prevent direct access to the plugin */
if (!defined('ABSPATH')) {
	exit("Sorry, you are not allowed to access this page directly.");
}

wp_netbible_tagger_admin_init();

/**
 * wp_netbible_tagger_memus()
 *
 * Adds the Menu linkes for Netbible Tagger to the Wordpress Dashbard.
 *
 * @package	Netbible Tagger Reloaded
 * @since 	1.0
 * @author 	Adam (Zerzix) Kellogg
 * @uses 	add_submenue_page()
 */
function wp_netbible_tagger_menus() {
	// Add submenu item
	add_menu_page( WP_NETBIBLE_TAGGER_NAME, WP_NETBIBLE_TAGGER_NAME, 'manage_options', WP_NETBIBLE_TAGGER_FILE_HOOK, WP_NETBIBLE_TAGGER_PAGEHOOK );
}

/**
 * wp_netbible_tagger_options_page()
 *
 * Generates the Netbuble Tagger Configuration page for the Wordpress Dashboard.
 * This page allows the user to change Netbible Tagger configuration options.
 *
 * @package	Netbible Tagger Reloaded
 * @since 	1.0
 * @author 	Adam (Zerzix) Kellogg
 * @uses 	get_option()()
 */
function wp_netbible_tagger_options_page() {
	//load netbible tagger options from database
	$wp_netbible_tagger_options = get_option('wp-netbible-tagger-options');
	$wp_netbible_tagger_css = get_option('wp-netbible-tagger-css');

	?>
<DIV class='wrap'>

	<?php 
	screen_icon( 'options-general' );
	echo "<h2>NETBible Tagger Options</h2>";
	?>

	<P>
		Use the options below to change the way NETBible Tagger works on your
		site. A detailed explanation of these options can be found <A
			href='http://labs.bible.org/blog/netbibletagger_configuration_options'>here</A>.
		<BR />An overview of the way NETBible Tagger works can be found at the
		<A href='http://labs.bible.org/NETBibleTagger'>NETBible Tagger web
			site</A>.

	</P>
	<FORM method='post' name='wp-netbible-tagger-options' action=''>
		<TABLE class="form-table">
			<TR valign="top">
				<TH scope="row"><LABEL for="voidOnMouseOut">Popups</LABEL></TH>
				<TD><INPUT name="voidOnMouseOut" type="checkbox" id="voidOnMouseOut"
					class="checkbox"
					<?php checked( $wp_netbible_tagger_options['voidOnMouseOut'] ); ?> />
					Remove the popup when the mouse leaves a link/popup?</TD>
			</TR>
			<TR valign="top">
				<TH scope="row"><LABEL for="parseAnchors">Existing links</LABEL></TH>
				<TD><INPUT name="parseAnchors" type="checkbox" id="parseAnchors"
					class="checkbox"
					<?php checked( $wp_netbible_tagger_options['parseAnchors'] ); ?> />
					Make NETBibleTagger work with your existing links?</TD>
			</TR>
			<TR valign="top">
				<TH scope="row"><LABEL for="customCSS">CSS</LABEL></TH>
				<TD><INPUT name="customCSS" type="checkbox" id="customCSS"
					class="checkbox"
					<?php checked( $wp_netbible_tagger_options['customCSS'] ); ?> />
					Override the default CSS and provide your own?</TD>
			</TR>
			<TR valign="top">
				<TH scope="row"><LABEL for="css">Custom CSS</LABEL></TH>
				<TD>
					<P>
						<LABEL for="css">This only works if the 'Override the default CSS
							and provide your own' checkbox above is checked. Here's some <A
							href='http://labs.bible.org/api/NETBibleTagger/netbibletagger.css'>default
								CSS</A>.
						</LABEL>
					</P>
					<P>
						<TEXTAREA name="css" rows="10" cols="50" id="css"
							class="large-text large-text-code">
							<?php echo stripslashes( $wp_netbible_tagger_css ); ?>
						</TEXTAREA>
					</P>
				</TD>
			</TR>
		</TABLE>
		<P class='submit'>
			<INPUT name='wpNetbibleTaggerOptionsSaved' value='true' type="hidden" />
			<INPUT type='submit' class='button-primary' value='Save Changes' />
		</P>
	</FORM>
</DIV>
<?php
}

/**
 * wp_netbible_tagger_options_page()
 *
 * This function Saves the Netbible Tagger options if they are changed through
 * the configuration page.
 *
 * @package	Netbible Tagger Reloaded
 * @since 	1.0
 * @author 	Adam (Zerzix) Kellogg
 * @uses 	update_option()()
 * @global	$wpdb
 * @param	$force	TRUE or False weather to run function or not.
 */
function wp_netbible_tagger_save_options( $force=false ) {
	global $wpdb;

	// Is the user allowed to do this? Probably not needed...
	if ( function_exists('current_user_can') && !current_user_can('manage_options') ) {
		die( 'Sorry. You do not have permission to do this.' );
	}

	//check wether to save options or not
	if ( ! isset( $_POST['wpNetbibleTaggerOptionsSaved'] ) && !$force )
		return;
	// Load Post data array
	$voidOnMouseOut = isset( $_POST['voidOnMouseOut'] ) ? 1 : 0;
	$customCSS 		= isset( $_POST['customCSS'] ) ? 1 : 0;
	$parseAnchors 	= isset( $_POST['parseAnchors'] ) ? 1 : 0;
	$css			= isset( $_POST['css'] ) ? $_POST['css'] : '';
	//write netbible tagger options to database
	$wp_netbible_tagger_options = compact( 'voidOnMouseOut', 'customCSS', 'parseAnchors' );
	//write netbible tagger options to database
	update_option( 'wp-netbible-tagger-options', $wp_netbible_tagger_options );
	update_option( 'wp-netbible-tagger-css', $css );
}

/**
 * wp_netbible_tagger_admin_init()
 *
 * Adds the admin functions to the Wordpress dashbaord admin functions.
 *
 * @package	Netbible Tagger Reloaded
 * @since 	1.0
 * @author 	Adam (Zerzix) Kellogg
 * @uses 	add_action()
 * @global	$wpdb
 */
function wp_netbible_tagger_admin_init() {
	add_action( 'admin_menu', 'wp_netbible_tagger_menus' );
	add_action( 'admin_init', 'wp_netbible_tagger_save_options' );
}

?>