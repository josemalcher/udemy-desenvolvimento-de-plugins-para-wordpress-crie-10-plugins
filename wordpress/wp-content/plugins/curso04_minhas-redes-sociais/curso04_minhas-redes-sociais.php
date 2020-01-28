<?php
/*
Plugin Name: Curso 04 - Minhas Redes Sociais
Plugin URI: http://#
Description: Plugin desenvolvido para exibir as minhas redes sociais
Version: 1.0
Author: José Malcher Jr.
Author URI: https://josemacher.net
Text Domain: minhas-redes-sociais
License: GPL2
*/

require_once (dirname(__FILE__) . '/meu_widget.php' );
class Minhas_Redes {
	private static $instance;

	public static function getInstance() {
		if ( self::$instance == NULL ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function __construct() {
		add_action('widgets_init', array($this, 'register_widgerts'));
	}
	public function register_widgerts(){
		register_widget('Meu_widget');
	}
}

Minhas_Redes::getInstance();