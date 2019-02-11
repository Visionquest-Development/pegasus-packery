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

	function pegasus_packery_menu_item() {
		//add_menu_page("Packery", "Packery", "manage_options", "pegasus_packery_plugin_options", "pegasus_packery_plugin_settings_page", null, 99);
		
	}
	add_action("admin_menu", "pegasus_packery_menu_item");

	function pegasus_packery_plugin_settings_page() { ?>
	    <div class="wrap pegasus-wrap">
	    <h1>packery</h1>			
			<p>Section shortcode Usage: <pre>[packery] image content goes here [/packery]</pre></p>	
			<p style="color:red;">MAKE SURE YOU DO NOT HAVE ANY RETURNS OR <?php echo htmlspecialchars('<br>'); ?>'s IN YOUR SHORTCODES, OTHERWISE IT WILL NOT WORK CORRECTLY</p>
		</div>
	<?php
	}

	
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
	
		
		
		
		