<?php
/*
Plugin Name: Curso 06 - Meu Twitter ME
Plugin URI: http://exemplo.com
Description: Plugin desenvolvido para cadastro do twitter
Version: 1.0
Author: José Malcher Jr.
Author URI: https://josemalcher.net
Text Domain: meu-twitter
License: GPL2
*/

class curso06_Meu_twitter{
  private static $instance;
  
/* **************************** */
  private function __construct(){
    add_action('admin_menu', array($this,'set_custom_fields'));
  }
  public function set_custom_fields(){
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
  public static function save_custom_fields(){
    echo "Olá Mundo";
  }

  /* ************************* */
  public static function getInstance(){
    if(self::$instance == NULL){
      self::$instance = new self();
    }
    return self::$instance;
  }
}
curso06_Meu_twitter::getInstance();