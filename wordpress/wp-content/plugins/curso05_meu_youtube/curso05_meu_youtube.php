<?php
/*
Plugin Name: Curso 05 - Meu Youtube
Plugin URI: http://#
Description: Plugin desenvolvido para ...
Version: 1.0
Author: José Malcher Jr.
Author URI: https://josemacher.net
Text Domain: meu-youtube
License: GPL2
*/


class Meu_youtube {
	private static $instance;

	public static function getInstance() {
		if ( self::$instance == null ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function __construct() {
		add_shortcode( 'youtube', array( $this, 'youtube' ) );
		// [youtube canal="nome_do_canal"]
		
		/* Adicionar diretamente em algum lugar do HTML: */
		// echo do_shortcode('[youtube canal="nome_do_canal"]');
	}

	public function youtube( $parametros ) {

		$a     = shortcode_atts( array( 'canal' => '' ), $parametros );
		$canal = $a['canal'];

		return '

		    <script src="https://apis.google.com/js/platform.js"></script>
		
			<div class="g-ytsubscribe" data-channel="' . $canal . '" data-layout="default" data-count="default"></div>
  			';
	}


}

Meu_youtube::getInstance();