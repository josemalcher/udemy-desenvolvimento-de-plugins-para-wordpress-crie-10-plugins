# Desenvolvimento de Plugins Para Wordpress - Crie 10 Plugins

https://www.udemy.com/course/desenvolvimento-de-plugins-para-wordpress-crie-10-plugins/

Aprenda a planejar, desenvolver e publicar plugins para WordPress com profissional especializado

## <a name="indice">Índice</a>

1. [Introdução](#parte1)     
2. [Baixando o Wordpress e configurando e ambiente de desenvolvimento](#parte2)     
3. [Conhecendo os Plugins do WordPress](#parte3)     
4. [Apresentação do LOOP WordPress](#parte4)     
5. [Criando o primeiro plugin](#parte5)     
6. [Hooks - Actions e Filters](#parte6)     
7. [Segundo plugin - painel personalizado](#parte7)     
8. [Terceiro plugin - Reviews de Filmes](#parte8)     
9. [Quarto Plugin - Redes Sociais](#parte9)     
10. [Quinto Plugin - Botão de incrição do youtube](#parte10)     
11. [Wordpress Options API](#parte11)     
12. [Conhecendo as tabelas do Wordpress](#parte12)     
13. [Sexto Plugin - Twitter](#parte13)     
14. [Sétimo Plugin - Segurança de Login](#parte14)     
15. [Oitavo plugin - Upload de Arquivo em Massa](#parte15)     
16. [Nono Plugin - Shortcode com Quicktags](#parte16)     
17. [Décimo Plugin - Newsletter](#parte17)     
18. [Coding Standards - Padrões de Codificação](#parte18)     
19. [Distribuindo seu plugin no wordpress.org](#parte19)     
20. [Aulas extras](#parte20)     
---

## <a name="parte1">1 - Introdução</a>

- CMS - GLP

[Voltar ao Índice](#indice)

---

## <a name="parte2">2 - Baixando o Wordpress e configurando e ambiente de desenvolvimento</a>

- https://br.wordpress.org/download/
- XAMPP
- Editor ou IDE

[Voltar ao Índice](#indice)

---

## <a name="parte3">3 - Conhecendo os Plugins do WordPress</a>

[Voltar ao Índice](#indice)

---

## <a name="parte4">4 - Apresentação do LOOP WordPress</a>

- wordpress/wp-content/themes/twentynineteen/single.php

- https://developer.wordpress.org/themes/basics/template-tags/

```php
            /* Exemplos de Loop para aula 08 */

            //query_posts('posts_per_page=3&order=DESC');
            //query_posts('post_status=draft');
            //query_posts('tag_id=3');
            //query_posts('cat=4,5');

            /* ex1  LOOP */
//            global $wpdb;
//            $sql = "SELECT * FROM $wpdb->posts WHERE post_status = 'publish'";
//            $listaDados = $wpdb->get_results($sql);
//            //print_r($listaDados);
//
//            foreach ($listaDados as $value) {
//                echo '<h3>' . $value->post_title . '</h3>';
//                echo $value->post_content;
//            }
            /* ex1  END LOOP */

            /* ex2  LOOP */
             $myPosts = new WP_Query('posts_per_page=2&orderby=rand');
             while ($myPosts->have_posts()) : $myPosts->the_post();
                 echo '<h3>' . the_title() . '</h3>';
                 echo the_content();
             endwhile;
            /* ex2 END  LOOP */

```

[Voltar ao Índice](#indice)

---


## <a name="parte5">5 - Criando o primeiro plugin</a>

- wordpress/wp-content/plugins/curso01_altera_rodape/curso01_altera_rodape.php

```php
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
```

- wordpress/wp-content/plugins/curso01_altera_rodape/curso01_altera_rodape.php

```php
<?php //....
<a class="site-name" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php /*bloginfo( 'name' );*/ wp_footer(); ?></a>,
```

[Voltar ao Índice](#indice)

---


## <a name="parte6">6 - Hooks - Actions e Filters</a>

- **Actions - podem personalizar nossas funções**
- https://codex.wordpress.org/Plugin_API/Action_Reference
```php

function alert_teste(){
    if(is_user_logged_in()){
        echo "<script>alert(" . get_current_user_id() .")</script>";
    }
}
add_action('init', 'alert_teste');
```

- **Filters - capturar dados antes de ser inserido no banco ou exibido na página**
- https://codex.wordpress.org/Plugin_API/Filter_Reference

```php
function my_filter($value, $id){
    $value = '[*** '. $value . ' ***]';
    return $value;
}
add_filter( 'the_title', 'my_filter', 10,2 );
// 10 =< prioridade em compração aos outros filtros que estão sendo executados
// 2 => quantidade de parâmetros que a função personalizada aceita
```




[Voltar ao Índice](#indice)

---


## <a name="parte7">7 - Segundo plugin - painel personalizado</a>



[Voltar ao Índice](#indice)

---


## <a name="parte8">8 - Terceiro plugin - Reviews de Filmes</a>



[Voltar ao Índice](#indice)

---


## <a name="parte9">9 - Quarto Plugin - Redes Sociais</a>



[Voltar ao Índice](#indice)

---


## <a name="parte10">10 - Quinto Plugin - Botão de incrição do youtube</a>



[Voltar ao Índice](#indice)

---


## <a name="parte11">11 - Wordpress Options API</a>



[Voltar ao Índice](#indice)

---


## <a name="parte12">12 - Conhecendo as tabelas do Wordpress</a>



[Voltar ao Índice](#indice)

---


## <a name="parte13">13 - Sexto Plugin - Twitter</a>



[Voltar ao Índice](#indice)

---


## <a name="parte14">14 - Sétimo Plugin - Segurança de Login</a>



[Voltar ao Índice](#indice)

---


## <a name="parte15">15 - Oitavo plugin - Upload de Arquivo em Massa</a>



[Voltar ao Índice](#indice)

---


## <a name="parte16">16 - Nono Plugin - Shortcode com Quicktags</a>



[Voltar ao Índice](#indice)

---


## <a name="parte17">17 - Décimo Plugin - Newsletter</a>



[Voltar ao Índice](#indice)

---


## <a name="parte18">18 - Coding Standards - Padrões de Codificação</a>



[Voltar ao Índice](#indice)

---


## <a name="parte19">19 - Distribuindo seu plugin no wordpress.org</a>



[Voltar ao Índice](#indice)

---


## <a name="parte20">20 - Aulas extras</a>



[Voltar ao Índice](#indice)

---

