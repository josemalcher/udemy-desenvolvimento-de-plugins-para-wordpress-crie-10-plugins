<?php

function ns_add_scripts(){
	wp_enqueue_style  ('ns-main-style',  plugins_url().'/Curso10-newslatter/css/style.css');
	wp_enqueue_script( 'ns-main-script', plugins_url().'/Curso10-newslatter/js/main.js', array('jquery'));
}

add_action('wp_enqueue_scripts','ns_add_scripts');