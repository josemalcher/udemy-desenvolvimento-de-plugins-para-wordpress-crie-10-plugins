<?php
/*
Plugin Name: Curso 07 - Proteger Login
Plugin URI: http://exemplo.com
Description: Plugin desenvolvido para proteger tela de login do administrador
Version: 1.0
Author: José Malcher Jr.
Author URI: https://josemalcher.net
Text Domain: proteger-login
License: GPL2
*/

if(!defined('ABSPATH'))exit;
class Proteger_login {
	private static $instance;

	public static function getInstance() {
		if (self::$instance == NULL) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	private function __construct() {

		add_action('login_form_login',array($this,'pt_login'));
	}

	public function pt_login(){

		if($_SERVER['SCRIPT_NAME'] == '/wp-login.php'){

			$minuto = Date( 'i' );
			echo "<script> alert(" . $minuto . "); </script>";

			if(!isset($_GET['empresa'.$minuto])){

				header('Location:http://localhost/');
			}
		}

	}

}

Proteger_login::getInstance();