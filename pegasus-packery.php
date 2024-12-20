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

	function pegasus_packery_admin_table_css() {
		if ( packery_check_main_theme_name() == 'Pegasus' || packery_check_main_theme_name() == 'Pegasus Child' ) {
			//do nothing
		} else {
			//wp_register_style('packery-admin-table-css', trailingslashit(plugin_dir_url(__FILE__)) . 'css/pegasus-packery-admin-table.css', array(), null, 'all');
			ob_start();
			?>
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
				table.pegasus-table {
					width: 100%;
					border-collapse: collapse;
					border-color: #777 !important;
				}
				table.pegasus-table th {
					background-color: #f1f1f1;
					text-align: left;
				}
				table.pegasus-table th,
				table.pegasus-table td {
					border: 1px solid #ddd;
					padding: 8px;
				}
				table.pegasus-table tr:nth-child(even) {
					background-color: #f2f2f2;
				}
				table.pegasus-table thead tr { background-color: #282828; }
				table.pegasus-table thead tr td { padding: 10px; }
				table.pegasus-table thead tr td strong { color: white; }
				table.pegasus-table tbody tr:nth-child(0) { background-color: #cccccc; }
				table.pegasus-table tbody tr td { padding: 10px; }
				table.pegasus-table code { color: #d63384; }

			<?php
			// Get the buffered content
			$inline_css = ob_get_clean();

			wp_register_style('packery-admin-table-css', false);
			wp_enqueue_style('packery-admin-table-css');

			wp_add_inline_style('packery-admin-table-css', $inline_css);
		}
	}

	add_action('admin_enqueue_scripts', 'pegasus_packery_admin_table_css');

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

			<div>
				<?php echo pegasus_packery_settings_table(); ?>
			</div>
		</div>
	<?php
	}

	function pegasus_packery_settings_table() {

		$data = json_decode( file_get_contents( plugin_dir_path( __FILE__ ) . 'settings.json' ), true );

		if (json_last_error() !== JSON_ERROR_NONE) {
			return '<p style="color: red;">Error: Invalid JSON provided.</p>';
		}

		// Start building the HTML
		$html = '<table border="0" cellpadding="1" class="table pegasus-table" align="left">
		<thead>
		<tr style="background-color: #282828;">
		<td <span><strong>Name</strong></span></td>
		<td <span><strong>Attribute</strong></span></td>
		<td <span><strong>Options</strong></span></td>
		<td <span><strong>Description</strong></span></td>
		<td <span><strong>Example</strong></span></td>
		</tr>
		</thead>
		<tbody>';

		// Iterate over the data to populate rows
		if (!empty($data['rows'])) {
			foreach ($data['rows'] as $section) {
				// Add section header
				$html .= '<tr >';
				$html .= '<td colspan="5">';
				$html .= '<span>';
				$html .= '<strong>' . htmlspecialchars($section['section_name']) . '</strong>';
				$html .= '</span>';
				$html .= '</td>';
				$html .= '</tr>';

				// Add rows in the section
				foreach ($section['rows'] as $row) {
					$html .= '<tr>
						<td >' . htmlspecialchars($row['name']) . '</td>
						<td >' . htmlspecialchars($row['attribute']) . '</td>
						<td >' . nl2br(htmlspecialchars($row['options'])) . '</td>
						<td >' . nl2br(htmlspecialchars($row['description'])) . '</td>
						<td ><code>' . htmlspecialchars($row['example']) . '</code></td>
					</tr>';
				}
			}
		}

		$html .= '</tbody></table>';

		// Return the generated HTML
		return $html;
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




