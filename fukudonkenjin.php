<?php
/*
Plugin Name: Fukudonkenjin
Version: 0.2
Description: "Fukudonkenjin(福丼県人)" means the people living in "Fukudonken(福丼県)". Fukudonken is a holy place of rice bowls in Japan. Activating this plugin, you can see some "福井県(Fukui-ken)" strings are replaced with "福丼県" on your website. Please see also the "福丼県" official website(http://fukudon.jp/).
Author: tecking
Author URI: https://github.com/tecking
Text Domain: fukudonkenjin
Domain Path: /languages
License: GPLv2
*/

/*  Copyright 2014 tecking (email : tecking@tecking.org)

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


/*
 * Initialize
 */
$entries  = array( 'wp_title', 'bloginfo', 'the_title', 'the_content', 'the_excerpt', 'the_author_description', 'widget_title', 'widget_text', 'the_category', 'wp_list_categories', 'the_tags', 'wp_tag_cloud', 'entire_page' );
$settings = array();

load_plugin_textdomain( 'fukudonkenjin', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );


/*
 * Register admin menu
 */
add_action( 'admin_menu', 'my_admin_menu' );
function my_admin_menu() {

	add_options_page(
		__( 'Fukudonkenjin', 'fukudonkenjin' ),
		__( 'Fukudonkenjin', 'fukudonkenjin' ),
		'manage_options',
		'fukudonkenjin',
		'my_submenu'
	);
}


/*
 * Build option setting page
 */
function my_submenu() {
	?>
	<div id="fukudonkenjin" class="wrap">
		<h2><?php _e( 'Fukudonkenjin settings', 'fukudonkenjin' ); ?></h2>
		<form method="post" id="my-submenu-form" action="">
			<?php wp_nonce_field( 'my-nonce-key', 'fukudonkenjin' ); ?>

			<?php
			global $entries;
			$settings = get_option('fkd_settings');
			?>

			<p><?php _e( 'Check any entries you want to replace.', 'fukudonkenjin' ); ?></p>

			<?php
			// Notice
			// Because of "entire_page" entry uses JavaScript, it may decrease performance  
			?>
			<?php foreach ( $entries as $entry ) : $entry = esc_attr( $entry ); ?>
			<p>
			<input type="checkbox" id="<?php echo $entry; ?>" name="<?php echo $entry; ?>" value="1" <?php if ( isset( $settings ) && $settings["$entry"] == 1 ) echo 'checked'; ?>><label for="<?php echo $entry; ?>"><?php _e( $entry, 'fukudonkenjin' ); ?></label></input>
			</p>
			<?php endforeach; ?>

			<p class="submit"><input type="submit" class="button-primary" value="<?php _e('Save Changes', 'fukudonkenjin'); ?>"></p>
		</form>
	</div>

<?php
}


/*
 * Save settings
 */
add_action( 'admin_init', 'my_admin_init' );
function my_admin_init() {

	global $entries;

	if ( isset( $_POST['fukudonkenjin'] ) && $_POST['fukudonkenjin'] ) {
		if ( check_admin_referer( 'my-nonce-key', 'fukudonkenjin' ) ) {

			foreach ( $entries as $entry ) {
				if ( isset( $_POST["$entry"] ) && $_POST["$entry"] ) {
					$settings["$entry"] = intval( $_POST["$entry"] );
				}
				else {
					$settings["$entry"] = intval(0);
				}
			}

			update_option( 'fkd_settings', $settings );

			wp_safe_redirect( menu_page_url( 'my-submenu', false ) );

		}
	}
}


/*
 * Load admin stylesheet file
 */ 
add_action( 'admin_enqueue_scripts', 'my_admin_enqueue_scripts' );
function my_admin_enqueue_scripts() {
	if (isset($_GET['page']) && $_GET['page'] === 'fukudonkenjin') {
		wp_enqueue_style(
			'admin-fukudonkenjin-style',
			plugins_url('css/admin-fukudonkenjin.css', __FILE__ ),
			array(),
			'0.2',
			'all'
		);
	}
}


/*
 * Replace strings
 */
function fdk_str_replace( $content ) {
	return str_replace( '福井県', '福丼県', $content );
}

$settings = get_option('fkd_settings'); 
foreach ( (array)$settings as $key => $filter ) {
	if ( $key === 'entire_page' ) break;
	if ( $filter == 1 ) add_filter( $key, 'fdk_str_replace' );
}

if ( isset( $settings ) && $settings['entire_page'] == 1 ) {
	add_action( 'wp_head', 'fkd_wp_head' );
	function fkd_wp_head() {
		if ( !is_admin() ) {
			wp_enqueue_script( 'jquery' );
			wp_enqueue_script( 'config', plugins_url( 'js/fukudonkenjin.js', __FILE__ ), array( 'jquery' ), '0.2', true );
		}
	}
}
