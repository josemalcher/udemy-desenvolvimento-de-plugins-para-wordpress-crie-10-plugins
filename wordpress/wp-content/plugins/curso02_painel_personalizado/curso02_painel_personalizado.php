<?php
/*
Plugin Name: Curso 02 - Painel Personalizado
Plugin URI: http://#
Description: Exemplo 02 do curso - Painel personalizado
Version: 1.0.0
Author: José Malcher Junior
Author URI: https://josemalcher.net
License: GPLv2 or later
Text Domain: my_welcome_panel
*/

/*
remove_action('welcome_panel', 'wp_welcome_panel');
function my_welcome_panel(){
    */ ?><!--
    <div class="welcome-panel-content">
        <h3>Bem vindo ao Painel administrativo</h3>
        <p>Siga nossas redes sociais</p>
        <div id="icons">
            <a href="#" target="_blank">
                <img src="<? /*=plugins_url()*/ ?>/curso02_painel_personalizado/img/facebook-circle-color.png" alt="Facebook">
            </a>
            <a href="#">
                <img src="<? /*=plugins_url()*/ ?>/curso02_painel_personalizado/img/youtube-circle-color.png" alt="Youtube">
            </a>
        </div>
    </div>
--><?php
/*}
add_action('welcome_panel', 'my_welcome_panel');
*/

// Refatoranto
class Curso02Painel
{
    private static $instance;
    const TEXT_DOMAIN = "my_welcome_panel";

    public static function getInstance()
    {
        if(self::$instance == NULL){
            self::$instance = new self();
        }
    }
    private function __construct()
    {
        // desativa a action welcome_panel
        remove_action('welcome_panel', 'wp_welcome_panel');

        add_action('welcome_panel',         array($this, 'my_welcome_panel'));
        add_action('admin_enqueue_scripts', array($this, 'add_css'));
        add_action('init', array($this, 'meusegundoplugin_load_textdomain'));
    }

    public function my_welcome_panel()
    {
        ?>
        <div class="welcome-panel-content">
            <h3><?=__("Bem vindo ao Painel administrativo", "my_welcome_panel")?></h3>
            <p> <?=__("Siga nossas redes sociais", "my_welcome_panel")?></p>
            <div id="icons">
                <a href="#" target="_blank">
                    <img src="<?=plugin_dir_url(__FILE__) ?>img/facebook-circle-color.png"
                         alt="Facebook">
                </a>
                <a href="#">
                    <img src="<?=plugin_dir_url(__FILE__) ?>img/youtube-circle-color.png"
                         alt="Youtube">
                </a>
            </div>
        </div>
        <?php
    }

    public function meusegundoplugin_load_textdomain(){
        load_plugin_textdomain(self::TEXT_DOMAIN, false, dirname(plugin_basename(__FILE__)));
    }

    public function add_css(){
        wp_register_style('meu-segundo-plugin', plugin_dir_url(__FILE__). 'css/meu-segundo-plugin.css');
        wp_enqueue_style( 'meu-segundo-plugin');
    }
}
Curso02Painel::getInstance();