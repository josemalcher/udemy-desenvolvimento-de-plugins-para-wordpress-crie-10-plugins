<?php
/*
Plugin Name: Curso 10 - Newslatter
Plugin URI: http://exemplo.com
Description: Plugin desenvolvido Newslatter
Version: 1.0
Author: José Malcher Jr.
Author URI: https://josemalcher.net
Text Domain: meu-newslatter
License: GPL2
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Load script
require_once( plugin_dir_path( __FILE__ ) . '/include/newslatter-script.php' );
require_once( plugin_dir_path( __FILE__ ) . '/include/newslatter-curso.php' );

function register_newslatter_curso(){
	register_widget('Newslatter_Curso_Widget');
}

add_action('widgets_init','register_newslatter_curso');