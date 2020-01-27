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

- wordpress/wp-content/plugins/curso02_painel_personalizado/curso02_painel_personalizado.php

```php
<?php
/*
Plugin Name: Curso 02 - Painel Personalizado
Plugin URI: http://#
Description: Exemplo 02 do curso - Painel personalizado
Version: 1.0.0
Author: José Malcher Junior
Author URI: https://josemalcher.net
License: GPLv2 or later
Text Domain: exemplo
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
    }

    public function my_welcome_panel()
    {
        ?>
        <div class="welcome-panel-content">
            <h3>Bem vindo ao Painel administrativo</h3>
            <p>Siga nossas redes sociais</p>
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
    public function add_css(){
        wp_register_style('meu-segundo-plugin', plugin_dir_url(__FILE__). 'css/meu-segundo-plugin.css');
        wp_enqueue_style( 'meu-segundo-plugin');
    }
}
Curso02Painel::getInstance();
```

[Voltar ao Índice](#indice)

---


## <a name="parte8">8 - Terceiro plugin - Reviews de Filmes</a>

### Aula 16/17 - Iniciando a criação do plugin | Recriando regras de rewrite

- https://codex.wordpress.org/Function_Reference/register_post_type
- https://developer.wordpress.org/reference/functions/flush_rewrite_rules/

```php
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



```
### 19 - Instalação de plugins necessários

- wordpress/wp-content/plugins/curso03_filmes_reviews/curso03_filmes_reviews.php
- wordpress/wp-content/plugins/curso03_filmes_reviews/lib/class-tgm-plugin-activation.php

- http://tgmpluginactivation.com/configuration/

```php
<?php
/*
Plugin Name: Curso 03 - Filmes Reviews
Plugin URI: http://#
Description: Exemplo 03 do curso - Filmes Reviews
Version: 1.0.0
Author: José Malcher Junior
Author URI: https://josemalcher.net
License: GPLv2 or later
Text Domain: filmes-reviews
*/
require dirname( __FILE__ ) . '/lib/class-tgm-plugin-activation.php';

class FilmesReviews {

	private static $instance;
	const TEXT_PLUGIN = "curso03_filmes_reviews";

	public static function getInstance() {
		if ( self::$instance == null ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	private function __construct() {
		add_action( 'init', 'FilmesReviews::register_post_type' );
		add_action( 'tgmpa_register', array( $this, 'check_required_plugins' ) );
	}

	public static function register_post_type() {
		register_post_type( 'filmes_reviews', array(
			'labels'        => array(
				'Filmes Reviews',
				'singular_name' => 'Filme Review'
			),
			'description'   => 'Post para cadastro de Reviews de Filmes',
			'supports'      => array(
				'title',
				'editor',
				'execerpt',
				'author',
				'revisions',
				'thumbnail',
				'custom-fields',
			),
			'public'        => true,
			'menu_icon'     => 'dashicons-format-video',
			'menu_position' => 3,
		) );
	}

	/*
	 *   Checar plugins requeridos
	 */

	function check_required_plugins() {
		$plugins = array(
			array(
				'name'                => 'Meta Box',
				'slug'                => 'meta-box',
				'required'            => true,
				'forced_activation'   => false,
				'force_desactivation' => false
			)
		);
		$config  = array(
			'id'           => 'filmes-reviews',
			// Unique ID for hashing notices for multiple instances of TGMPA.
			'default_path' => '',
			// Default absolute path to bundled plugins.
			'menu'         => 'tgmpa-install-plugins',
			// Menu slug.
			'parent_slug'  => 'plugins.php',
			// Parent menu slug.
			'capability'   => 'manage_options',
			// Capability needed to view plugin install page, should be a capability associated with the parent menu used.
			'has_notices'  => true,
			// Show admin notices or not.
			'dismissable'  => true,
			// If false, a user cannot dismiss the nag message.
			'dismiss_msg'  => '',
			// If 'dismissable' is false, this message will be output at top of nag.
			'is_automatic' => false,
			// Automatically activate plugins after installation or not.
			'message'      => '',
			// Message to output right before the plugins table.


			'strings' => array(
				'page_title'                      => __( 'Install Required Plugins', 'filmes-reviews' ),
				'menu_title'                      => __( 'Install Plugins', 'filmes-reviews' ),
				'installing'                      => __( 'Installing Plugin: %s', 'filmes-reviews' ),
				'updating'                        => __( 'Updating Plugin: %s', 'filmes-reviews' ),
				'oops'                            => __( 'Something went wrong with the plugin API.', 'filmes-reviews' ),
				'notice_can_install_required'     => _n_noop(
					'This theme requires the following plugin: %1$s.',
					'This theme requires the following plugins: %1$s.',
					'filmes-reviews'
				),
				'notice_can_install_recommended'  => _n_noop(
					'This theme recommends the following plugin: %1$s.',
					'This theme recommends the following plugins: %1$s.',
					'filmes-reviews'
				),
				'notice_ask_to_update'            => _n_noop(
					'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
					'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
					'filmes-reviews'
				),
				'notice_ask_to_update_maybe'      => _n_noop(
					'There is an update available for: %1$s.',
					'There are updates available for the following plugins: %1$s.',
					'filmes-reviews'
				),
				'notice_can_activate_required'    => _n_noop(
					'The following required plugin is currently inactive: %1$s.',
					'The following required plugins are currently inactive: %1$s.',
					'filmes-reviews'
				),
				'notice_can_activate_recommended' => _n_noop(
					'The following recommended plugin is currently inactive: %1$s.',
					'The following recommended plugins are currently inactive: %1$s.',
					'filmes-reviews'
				),
				'install_link'                    => _n_noop(
					'Begin installing plugin',
					'Begin installing plugins',
					'filmes-reviews'
				),
				'update_link'                     => _n_noop(
					'Begin updating plugin',
					'Begin updating plugins',
					'filmes-reviews'
				),
				'activate_link'                   => _n_noop(
					'Begin activating plugin',
					'Begin activating plugins',
					'filmes-reviews'
				),
				'return'                          => __( 'Return to Required Plugins Installer', 'filmes-reviews' ),
				'plugin_activated'                => __( 'Plugin activated successfully.', 'filmes-reviews' ),
				'activated_successfully'          => __( 'The following plugin was activated successfully:', 'filmes-reviews' ),
				'plugin_already_active'           => __( 'No action taken. Plugin %1$s was already active.', 'filmes-reviews' ),
				'plugin_needs_higher_version'     => __( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'filmes-reviews' ),
				'complete'                        => __( 'All plugins installed and activated successfully. %1$s', 'filmes-reviews' ),
				'dismiss'                         => __( 'Dismiss this notice', 'filmes-reviews' ),
				'notice_cannot_install_activate'  => __( 'There are one or more required or recommended plugins to install, update or activate.', 'filmes-reviews' ),
				'contact_admin'                   => __( 'Please contact the administrator of this site for help.', 'filmes-reviews' ),

				'nag_type' => '',
				// Determines admin notice type - can only be one of the typical WP notice classes, such as 'updated', 'update-nag', 'notice-warning', 'notice-info' or 'error'. Some of which may not work as expected in older WP versions.
			),

		);
		tgmpa( $plugins, $config );
	}

	public static function activate() {
		self::register_post_type();
		flush_rewrite_rules();
	}

}

FilmesReviews::getInstance();
register_deactivation_hook( __FILE__, 'flush_rewrite_rules' );
register_activation_hook( __FILE__, 'FilmesReviews::activate' );



```

- 24 Registrando Taxonomias

```php
<?php

// ....
	private function __construct() {
		add_action( 'init', 'FilmesReviews::register_post_type' );
		add_action( 'init', 'FilmesReviews::register_taxonomies' );
		add_action( 'tgmpa_register', array( $this, 'check_required_plugins' ) );
	}

// ....


	public static function register_taxonomies() {
		register_taxonomy( 'tipos_filmes', array( 'filmes_reviews' ),
			array(
				'labels'       => array(
					'name'          => __( 'Filmes Tipos' ),
					'singular_name' => __( 'Filme Tipo' ),
				),
				'public'       => true,
				'hierarchical' => true,
				'rewrite'      => array( 'slug' => 'tipos-filmes' ),
			)

		);
	}

// ....

public static function activate() {
		self::register_post_type();
		self::register_taxonomies();
		flush_rewrite_rules();
	}

```

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

