<?php
/*
Plugin Name: Curso 03 - Filmes Reviews
Plugin URI: http://#
Description: Exemplo 03 do curso - Filmes Reviews
Version: 1.0.0
Author: José Malcher Junior
Author URI: https://josemalcher.net
License: GPLv2 or later
Text Domain: exemplo
*/
class FilmesReviews{

	private static $instance;

	public static function getInstance(){
		if(self::$instance == NULL){
			self::$instance = new self();
		}
		return self::$instance;
	}
	private function __construct() {
		add_action('init', 'FilmesReviews::register_post_type');
	}
	public static function register_post_type(){
		register_post_type('filmes_reviews', array(
				'labels' => array('Filmes Reviews',
				'singular_name' => 'Filme Review'
			),
			'description' => 'Post para cadastro de Reviews de Filmes',
			'supports' => array(
				'title', 'editor', 'execerpt', 'author', 'revisions', 'thumbnail', 'custom-fields',
			),
			'public' => TRUE,
			'menu_icon' => 'dashicons-format-video',
			'menu_position' => 3,
		));
	}

	public static function activate(){
		self::register_post_type();
		flush_rewrite_rules();
	}

}

FilmesReviews::getInstance();
register_deactivation_hook(__FILE__,'flush_rewrite_rules');
register_activation_hook(__FILE__, 'FilmesReviews::activate');


