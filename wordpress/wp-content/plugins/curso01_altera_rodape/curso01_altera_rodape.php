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



function alert_teste(){
    if(is_user_logged_in()){
        echo "<script>alert(" . get_current_user_id() .")</script>";
    }
}
//add_action('init', 'alert_teste');

function my_filter($value, $id){
    $value = '[*** '. $value . ' ***]';
    return $value;
}
add_filter( 'the_title', 'my_filter', 10,2 );
// 10 =< prioridade em compração aos outros filtros que estão sendo executados
// 2 => quantidade de parâmetros que a função personalizada aceita
