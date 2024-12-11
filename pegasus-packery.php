<?php
/*
Plugin Name: Pegasus Packery Plugin
Plugin URI:  https://developer.wordpress.org/plugins/the-basics/
Description: This allows you to create a packery grid of items on your website with just a shortcode.
Version:     1.0
Author:      Jim O'Brien
Author URI:  https://visionquestdevelopment.com/
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: wporg
Domain Path: /languages
*/

	/**
	 * Silence is golden; exit if accessed directly
	 */
	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}

	function packery_check_main_theme_name() {
		$current_theme_slug = get_option('stylesheet'); // Slug of the current theme (child theme if used)
		$parent_theme_slug = get_option('template');    // Slug of the parent theme (if a child theme is used)

		//error_log( "current theme slug: " . $current_theme_slug );
		//error_log( "parent theme slug: " . $parent_theme_slug );

		if ( $current_theme_slug == 'pegasus' ) {
			return 'Pegasus';
		} elseif ( $current_theme_slug == 'pegasus-child' ) {
			return 'Pegasus Child';
		} else {
			return 'Not Pegasus';
		}
	}

	function pegasus_packery_menu_item() {
		if ( packery_check_main_theme_name() == 'Pegasus' || packery_check_main_theme_name() == 'Pegasus Child' ) {
			//do nothing
		} else {
			//echo 'This is NOT the Pegasus theme';
			add_menu_page(
				"Packery", // Page title
				"Packery", // Menu title
				"manage_options", // Capability
				"pegasus_packery_plugin_options", // Menu slug
				"pegasus_packery_plugin_settings_page", // Callback function
				null, // Icon
				88 // Position in menu
			);
		}
	}
	add_action("admin_menu", "pegasus_packery_menu_item");

	function pegasus_packery_plugin_settings_page() { ?>
	    <div class="wrap pegasus-wrap">
			<h1>Packery Usage</h1>

			<div>
				<h3>Packery Usage 1:</h3>
				<style>
					pre {
						background-color: #f9f9f9;
						border: 1px solid #aaa;
						page-break-inside: avoid;
						font-family: monospace;
						font-size: 15px;
						line-height: 1.6;
						margin-bottom: 1.6em;
						max-width: 100%;
						overflow: auto;
						padding: 1em 1.5em;
						display: block;
						word-wrap: break-word;
					}

					input[type="text"].code {
						width: 100%;
					}
				</style>
				<pre >[packery]<?php echo htmlspecialchars('
	<img src="https://via.placeholder.com/250/250/">
	<img src="https://via.placeholder.com/250/250/">
	<img src="https://via.placeholder.com/250/500/">
	<img src="https://via.placeholder.com/250/250/">
	<img src="https://via.placeholder.com/250/500/">
	<img src="https://via.placeholder.com/250/250/">
	<img src="https://via.placeholder.com/250/250/">
	<img src="https://via.placeholder.com/250/500/">
	<img src="https://via.placeholder.com/250/250/">
	<img src="https://via.placeholder.com/250/250/">
	<img src="https://via.placeholder.com/250/500/">'); ?>

[/packery]</pre>

				<input
					type="text"
					readonly
					value="<?php echo esc_html('[packery]<img src="https://via.placeholder.com/250/250/"><img src="https://via.placeholder.com/250/250/"><img src="https://via.placeholder.com/250/500/"><img src="https://via.placeholder.com/250/250/"><img src="https://via.placeholder.com/250/500/"><img src="https://via.placeholder.com/250/250/"><img src="https://via.placeholder.com/250/250/"><img src="https://via.placeholder.com/250/500/"><img src="https://via.placeholder.com/250/250/"><img src="https://via.placeholder.com/250/250/"><img src="https://via.placeholder.com/250/500/">[/packery]'); ?>"
					class="regular-text code"
					id="my-shortcode"
					onClick="this.select();"
				>
			</div>

			<p style="color:red;">MAKE SURE YOU DO NOT HAVE ANY RETURNS OR <?php echo htmlspecialchars('<br>'); ?>'s IN YOUR SHORTCODES, OTHERWISE IT WILL NOT WORK CORRECTLY</p>

		</div>
	<?php
	}

	// function pegasus_packery_menu_item() {
	// 	//add_menu_page("Packery", "Packery", "manage_options", "pegasus_packery_plugin_options", "pegasus_packery_plugin_settings_page", null, 99);

	// }
	// add_action("admin_menu", "pegasus_packery_menu_item");

	/*function pegasus_packery_plugin_settings_page() { ?>
	    <div class="wrap pegasus-wrap">
	    <h1>packery</h1>
			<p>Section shortcode Usage: <pre>[packery] image content goes here [/packery]</pre></p>
			<p style="color:red;">MAKE SURE YOU DO NOT HAVE ANY RETURNS OR <?php echo htmlspecialchars('<br>'); ?>'s IN YOUR SHORTCODES, OTHERWISE IT WILL NOT WORK CORRECTLY</p>
		</div>
	<?php
	} */


	function pegasus_packery_plugin_styles() {
		//wp_enqueue_style( 'packery-css', trailingslashit( plugin_dir_url( __FILE__ ) ) . 'css/packery.css', array(), null, 'all' );
		//wp_enqueue_style( 'slippery-slider-css', trailingslashit( plugin_dir_url( __FILE__ ) ) . 'css/slippery-slider.css', array(), null, 'all' );
	}
	add_action( 'wp_enqueue_scripts', 'pegasus_packery_plugin_styles' );

	/**
	* Proper way to enqueue JS
	*/
	function pegasus_packery_plugin_js() {

		//wp_enqueue_script( 'one-page-scroll-js', trailingslashit( plugin_dir_url( __FILE__ ) ) . 'js/jquery.onepage-scroll.js', array( 'jquery' ), null, true );
		//wp_enqueue_script( 'snap-scroll-js', trailingslashit( plugin_dir_url( __FILE__ ) ) . 'js/jquery.snapscroll.js', array( 'jquery' ), null, true );
		//wp_enqueue_script( 'scrollspy-js', trailingslashit( plugin_dir_url( __FILE__ ) ) . 'js/scrollspy.js', array( 'jquery' ), null, true );

		wp_register_script( 'images-loaded-js', trailingslashit( plugin_dir_url( __FILE__ ) ) . 'js/imagesLoaded.js', array( 'jquery' ), null, 'all' );

		wp_register_script( 'packery-js', trailingslashit( plugin_dir_url( __FILE__ ) ) . 'js/packery.js', array( 'jquery' ), null, 'all' );
		wp_register_script( 'pegasus-packery-plugin-js', trailingslashit( plugin_dir_url( __FILE__ ) ) . 'js/plugin.js', array( 'jquery' ), null, 'all' );

	} //end function
	add_action( 'wp_enqueue_scripts', 'pegasus_packery_plugin_js' );

	/*~~~~~~~~~~~~~~~~~~~~
		packery
	~~~~~~~~~~~~~~~~~~~~~*/
	// [packery ] content [/packery]
		function pegasus_packery_func( $atts, $content = null ) {
			$a = shortcode_atts( array(
				'id' => '',
				'class' => ''
			), $atts );

			$output = '';

				$output .= '<div id="packery-grid" class="" >';
					$output .=   do_shortcode($content);
				$output .= '</div><br clear="all">';

			//wp_enqueue_style( 'slick-theme-css' );
			wp_enqueue_script( 'images-loaded-js' );
			wp_enqueue_script( 'packery-js' );
			wp_enqueue_script( 'pegasus-packery-plugin-js' );

			return $output;
		}
		add_shortcode( 'packery', 'pegasus_packery_func' );




