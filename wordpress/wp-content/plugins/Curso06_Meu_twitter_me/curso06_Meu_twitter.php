<?php
/*
Plugin Name: Curso 06 - Meu Twitter Do Curso
Plugin URI: http://exemplo.com
Description: Plugin desenvolvido para cadastro do twitter
Version: 1.0
Author: José Malcher Jr.
Author URI: https://josemalcher.net
Text Domain: meu-twitter
License: GPL2
*/

class curso06_Meu_twitter {
	private static $instance;

	/* **************************** */
	private function __construct() {
		add_action( 'admin_menu', array( $this, 'set_custom_fields' ) );
		add_shortcode('twitter', array($this, 'twitter'));
	}

	public function set_custom_fields() {
		add_menu_page(
			'Meu Twitter',  //string $page_title
			'Meu Twitter', //string $menu_title
			'manage_options', //string $capability
			'meu_twitter', //string $menu_slug
			'curso06_Meu_twitter::save_custom_fields', //callable $function = ''
			'dashicons-twitter', //string $icon_url = ''
			'10' //int $position = null
		);
	}

	public static function save_custom_fields() {

		echo "<h3>" . __( "Cadastro do Twitter", "meu-twitter" ) . "</h3>";
		echo "<form method='post'>";

		echo "<table class='form-table'>
				<tbody>";

		$campos = array( 'twitter' );
		foreach ($campos as $campo ) {

			if(isset($_POST[$campo])){
				update_option( $campo, $_POST[$campo] );
			}

			$valor = stripcslashes( get_option( $campo ) );
			$label = ucwords( strtolower( $campo ) );

			echo "<tr>";
			echo "
					<th scope='row'><label for='input_id'> $label </label></th>
					<td><textarea cols='100' rows='5' name='$campo' type='text' id='input_id'>$valor</textarea>></td>
			";
			echo "</tr>";

		}

		echo "</tbody>
				</table>";

		$nomeBotao = ( get_option( 'twitter' ) !== "" ) ? "Editar" : "Cadastrar";
		echo "<input class='button button-secondary' type='submit' value='".$nomeBotao."'>";
		echo "</form>";
	}

	public function twitter( $param = null ) {
		return stripslashes(get_option( 'twitter' ));
	}

	/* ************************* */
	public static function getInstance() {
		if ( self::$instance == null ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
}

curso06_Meu_twitter::getInstance();