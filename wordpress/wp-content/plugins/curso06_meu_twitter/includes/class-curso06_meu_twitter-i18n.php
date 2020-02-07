<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://josemalcher.net
 * @since      1.0.0
 *
 * @package    Curso06_meu_twitter
 * @subpackage Curso06_meu_twitter/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Curso06_meu_twitter
 * @subpackage Curso06_meu_twitter/includes
 * @author     José Malcher jR. <contato@josemalcher.net>
 */
class Curso06_meu_twitter_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'curso06_meu_twitter',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
