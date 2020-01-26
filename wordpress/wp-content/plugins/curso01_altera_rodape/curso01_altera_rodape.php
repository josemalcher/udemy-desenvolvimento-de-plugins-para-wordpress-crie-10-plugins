<?php

/*
Plugin Name: Curso 01 - Altera Rodapé
Plugin URI: http://#
Description: Exemplo 01 do curso
Version: 1.0.0
Author: José Malcher Junior
Author URI: https://josemalcher.net
License: GPLv2 or later
Text Domain: exemplo
*/

function altera_rodape_footer(){
    echo "Meu primeiro plugin - José Malcher Jr. 2020";
}

add_action('wp_footer','altera_rodape_footer');