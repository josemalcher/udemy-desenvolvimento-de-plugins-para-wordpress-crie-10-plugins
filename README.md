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

### 27 - Campos personalizados com Meta BOX

```php
const FIELD_PREFIX = 'fr_'; // metabox

add_filter( 'rwmb_meta_boxes', array( $this, 'metabox_custom_fields' ) );


	/* META BOX */

	public function metabox_custom_fields() {

		$meta_boxes[] = array(

			'id'       => 'data_filme',
			'title'    => __( 'Informações Adicionais', 'filmes-reviews' ),
			'pages'    => array( 'filmes_reviews', 'post' ),
			'context'  => 'normal',
			'priority' => 'high',
			'fields'   => array(

				array(
					'name' => __( 'Ano de laçamento', 'filmes-reviews' ),
					'desc' => __( 'Ano que o filme foi lançano', 'filmes-reviews' ),
					'id'   => self::FIELD_PREFIX . 'filme_ano',
					'type' => 'number',
					'std'  => date( 'Y' ),
					'min'  => '1880',

				),
				array(

					'name' => __( 'Diretor', 'filmes-reviews' ),
					'desc' => __( 'Quem dirigiu o filme', 'filmes-reviews' ),
					'type' => 'text',
					'std'  => '',

				),
				array(

					'name' => 'Site',
					'desc' => 'Link do site do filme',
					'id'   => self::FIELD_PREFIX . 'filme_site',
					'type' => 'url',
					'std'  => '',

				),

			)

		);

		return $meta_boxes;
	}

	/* FIM META BOX */
```

### 30 Compos personalizados 2 Meta BOX - campo de avaliação

```php
public function metabox_custom_fields() {

		$meta_boxes[] = array(

			'id'       => 'data_filme',
			'title'    => __( 'Informações Adicionais', 'filmes-reviews' ),
			'pages'    => array( 'filmes_reviews', 'post' ),
			'context'  => 'normal',
			'priority' => 'high',
			'fields'   => array(

				array(
					'name' => __( 'Ano de laçamento', 'filmes-reviews' ),
					'desc' => __( 'Ano que o filme foi lançano', 'filmes-reviews' ),
					'id'   => self::FIELD_PREFIX . 'filme_ano',
					'type' => 'number',
					'std'  => date( 'Y' ),
					'min'  => '1880',

				),
				array(

					'name' => __( 'Diretor', 'filmes-reviews' ),
					'desc' => __( 'Quem dirigiu o filme', 'filmes-reviews' ),
					'type' => 'text',
					'std'  => '',

				),
				array(

					'name' => 'Site',
					'desc' => 'Link do site do filme',
					'id'   => self::FIELD_PREFIX . 'filme_site',
					'type' => 'url',
					'std'  => '',

				),

			)

		);

		$meta_boxes[] = array(

			'id'        => 'review_data',
			'title'     => __('Filme Review','filmes-reviews'),
			'pages'     => array('filmes_reviews'),
			'context'   => 'side',
			'priority'  => 'high',
			'fields'    => array(

				array(
					'name' => __('Rating','filmes-reviews'),
					'desc' => __('Em uma escala de 1 - 10 , sendo que 10 é a melhor nota','filmes-reviews'),
					'id'   => self::FIELD_PREFIX.'review_rating',
					'type' => 'select',
					'options' => array(

						'' => __('Avalie Aqui','filmes-reviews'),
						1  => __('1 - Gostei um pouco','filmes-reviews'),
						2  => __('2 - Eu gostei mais ou menos','filmes-reviews'),
						3  => __('3 - Não recomendo','filmes-reviews'),
						4  => __('4 - Deu pra assistir tudo','filmes-reviews'),
						5  => __('5 - Filme decente','filmes-reviews'),
						6  => __('6 - Filme legal','filmes-reviews'),
						7  => __('7 - Legal, recomendo','filmes-reviews'),
						8  => __('8 - O meu favorito','filmes-reviews'),
						9  => __('9 - Amei um dos meus melhores filmes','filmes-reviews'),
						10 => __('10 - O melhor filme de todos os tempos, recomendo!!','filmes-reviews'),

					),
					'std' => '',
				),
			)
		);
		return $meta_boxes;
	}
```

### 38 - Adicionando Página de template a ser exibida no plugin (front-end)

- wordpress/wp-content/plugins/curso03_filmes_reviews/single-filme_review.php

```php
<?php

/*

Template Default do Filmes Reviews
*/

get_header();

?>
    <div id="primary" class="content-area">

        <main id="main" class="content site-main" role="main">
			<?php
			while ( have_posts() ):the_post();

				$campo_prefixo = FilmesReviews::FIELD_PREFIX;
				$imagem        = get_the_post_thumbnail( get_the_ID(), 'medium' );
				$imagem_url    = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'medium' ); //RECUPERAR O THUMBNAIL

				$rating        = (int) post_custom( $campo_prefixo . 'review_rating' );
				$exibir_rating = mostrar_rating( $rating ); /*mostrar rating função para exibir dash icons*/

				$diretor   = wp_strip_all_tags( post_custom( $campo_prefixo . 'filme_diretor' ) );
				$link_site = esc_url( post_custom( $campo_prefixo . 'filme_site' ) );

				$ano = (int) post_custom( $campo_prefixo . 'filme_ano' );

				$filmes_categoria = get_the_terms( get_the_ID(), 'tipos_filmes' );
				$filme_tipo       = '';

				if ( $filmes_categoria && ! is_wp_error( $filmes_categoria ) ):

					$filme_tipo = array();

					foreach ( $filmes_categoria as $cat ) :

						$filme_tipo[] = $cat->name;
					endforeach;

				endif;


				?>
                <article id="post-<?php the_ID(); ?>" <?php post_class( 'hentry' ) ?>>
                    <header class="entry-header">
						<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
                    </header>

                    <div class="entry-content">
                        <div class="left">
							<?php

							if ( isset( $imagem ) ):
							?>
                            <div class="poster">
								<?php
								if ( isset( $link_site ) ):
									?>
									<?php echo '<a href="' . $link_site . '" target="__blank"> ' . $imagem . ' </a>'; ?>
								<?php

								else:

									echo $imagem;

								endif;
								endif;

								?>

								<?php if ( ! empty( $exibir_rating ) ): ?>
                                    <div class="rating rating-<?php echo $rating; ?>">

										<?php echo $exibir_rating; ?>

                                    </div>
								<?php endif; ?>

                                <div class="filme-meta">

									<?php if ( ! empty( $diretor ) ): ?>

                                        <label>Dirigido por:</label><?php echo $diretor; ?>

									<?php endif; ?>

									<?php if ( ! empty( $filmes_categoria ) ): ?>

                                        <div class="tipo">

                                            <label>Genero:</label>
											<?php
											foreach ( $filme_tipo as $t ):
												echo ' / ' . $t;
											endforeach;

											?>
                                        </div>
									<?php endif; ?>

									<?php if ( ! empty( $ano ) ): ?>

                                        <div class="lacamento-ano">

                                            <label>Ano:</label>
											<?php
											echo $ano;
											?>
                                        </div>
									<?php endif; ?>

									<?php if ( ! empty( $link_site ) ): ?>

                                        <div class="link">

                                            <label>Site:</label>
											<?php
											echo '<a href="' . $link_site . '" target="__blank"> Visite o site </a>';
											?>
                                        </div>
									<?php endif; ?>

                                    <div class="right">

                                        <div class="review-body">

											<?php the_content(); ?>

                                        </div>

                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>

					<?php

					edit_post_link( __( 'Editar' ), '<footer class="entry-footer"><span class="edit-link">', '</span> </footer>' );

					?>

                </article>
				<?php
				/*Comentarios*/

				if ( comments_open() || get_comments_number() ):
					comments_template();
				endif;

				/*NAVEGAÇÃO*/

				the_post_navigation(
					array(

						'next_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Próximo' ) . '</span>' .
						               '<span class="screen-reader-text">' . __( 'Próximo Review' ) . '</span>' .
						               '<span class="post-title"> %title </span>',

						'prev_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Anterior' ) . '</span>' .
						               '<span class="screen-reader-text">' . __( 'Review Anterior' ) . '</span>' .
						               '<span class="post-title"> %title </span>',
					)
				);
				?>
			<?php endwhile; ?>
        </main>
    </div>
<?php
get_footer();
?>

<?php

/*Função helper mostrar_rating */

function mostrar_rating( $rating = null ) {

	$rating = (int) $rating;

	if ( $rating > 0 ) {

		$estrelas_rating = array();
		$mostrar_rating  = "";

		for ( $i = 0; $i < floor( $rating / 2 ); $i ++ ) {

			$estrelas_rating[] = '<span class="dashicons dashicons-star-filled"> </span>';

		}

		if ( $rating % 2 === 1 ) {

			$estrelas_rating[] = '<span class="dashicons dashicons-star-half"> </span>';

		}

		$estrelas_rating = array_pad( $estrelas_rating, 5, '<span class="dashicons dashicons-star-empty"> </span>' );

		return implode( "\n", $estrelas_rating );

	}

	return false;

}

?>
```

- wordpress/wp-content/plugins/curso03_filmes_reviews/curso03_filmes_reviews.php

```php
/*TEMPLATE*/
		add_action( 'template_include', array( $this, 'add_cpt_template' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'add_style_scripts' ) );


/*TEMPLATE*/
	function add_cpt_template( $template ) {

		if ( is_singular( 'filmes_reviews' ) ) {

			if ( file_exists( get_stylesheet_directory() . 'single-filme_review.php' ) ) {

				return get_stylesheet_directory() . 'single-filme_review.php';

			}

			return plugin_dir_path( __FILE__ ) . 'single-filme_review.php';
		}

		return $template;

	}

	function add_style_scripts() {

		wp_enqueue_style( 'filme-review-style', plugin_dir_url( __FILE__ ) . 'filme-review.css' );
	}

```

[Voltar ao Índice](#indice)

---


## <a name="parte9">9 - Quarto Plugin - Redes Sociais</a>


- https://developer.wordpress.org/themes/functionality/widgets/

- wordpress/wp-content/plugins/curso04_minhas-redes-sociais/curso04_minhas-redes-sociais.php

```php
<?php
/*
Plugin Name: Curso 04 - Minhas Redes Sociais
Plugin URI: http://#
Description: Plugin desenvolvido para exibir as minhas redes sociais
Version: 1.0
Author: José Malcher Jr.
Author URI: https://josemacher.net
Text Domain: minhas-redes-sociais
License: GPL2
*/

require_once (dirname(__FILE__) . '/meu_widget.php' );
class Minhas_Redes {
	private static $instance;

	public static function getInstance() {
		if ( self::$instance == NULL ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function __construct() {
		add_action('widgets_init', array($this, 'register_widgerts'));
	}
	public function register_widgerts(){
		register_widget('Meu_widget');
	}
}

Minhas_Redes::getInstance();

```

- wordpress/wp-content/plugins/curso04_minhas-redes-sociais/meu_widget.php

```php

<?php

class Meu_widget extends WP_Widget {

	public function __construct() {

		parent::WP_Widget( false, $name = "Visite minhas redes sociais" );
	}

	public function widget( $args, $instance ) {

		extract( $args );
		$title        = apply_filters( 'widget_title', $instance['title'] );
		$urlFacebook  = $instance['urlFacebook'];
		$urlTwitter   = $instance['urlTwitter'];
		$urlInstagram = $instance['urlInstagram'];
		$urlYoutube   = $instance['urlYoutube'];

		echo $before_widget;

		if ( $title ) {
			echo $before_widget . $title . $after_widget;
		}

		echo '<a href="' . $urlFacebook . '" target="_blank"> 
<img src="' . plugin_dir_url( __FILE__ ) . 'icons/facebook.png" alt="facebook" width="50px"/>
 </a>';

		echo '<a href="' . $urlTwitter . '" target="_blank"> 
<img src="' . plugin_dir_url( __FILE__ ) . 'icons/twitter.png" alt="twitter" width="50px"/>
 </a>';

		echo '<a href="' . $urlInstagram . '" target="_blank"> 
<img src="' . plugin_dir_url( __FILE__ ) . 'icons/instagram.png" alt="instagram" width="50px"/>
 </a>';

		echo '<a href="' . $urlYoutube . '" target="_blank"> 
<img src="' . plugin_dir_url( __FILE__ ) . 'icons/youtube.png" alt="youtube" width="50px"/>
 </a>';

		echo $after_widget;

	}

	public function update( $new_instance, $old_instance ) {

		$instance                 = $old_instance;
		$instance['title']        = wp_strip_all_tags( $new_instance['title'] );
		$instance['urlFacebook']  = wp_strip_all_tags( $new_instance['urlFacebook'] );
		$instance['urlTwitter']   = wp_strip_all_tags( $new_instance['urlTwitter'] );
		$instance['urlInstagram'] = wp_strip_all_tags( $new_instance['urlInstagram'] );
		$instance['urlYoutube']   = wp_strip_all_tags( $new_instance['urlYoutube'] );

		return $instance;

	}

	public function form( $instance ) {

		$title        = esc_attr( $instance['title'] );
		$urlFacebook  = esc_attr( $instance['urlFacebook'] );
		$urlTwitter   = esc_attr( $instance['urlTwitter'] );
		$urlInstagram = esc_attr( $instance['urlInstagram'] );
		$urlYoutube   = esc_attr( $instance['urlYoutube'] );

		?>

        <p>
            <label for="<?= $this->get_field_id( 'title' ); ?>"> <?= _e( 'Título' ); ?></label>
            <input class="widefat" type="text" id="<?= $this->get_field_id( 'title' ); ?>"
                   name="<?= $this->get_field_name( 'title' ); ?>" value="<?= $title ?>"/>
        </p>

        <p>
            <label for="<?= $this->get_field_id( 'urlFacebook' ); ?>"> <?= _e( 'Facebook' ); ?></label>
            <input class="widefat" type="text" id="<?= $this->get_field_id( 'urlFacebook' ); ?>"
                   name="<?= $this->get_field_name( 'urlFacebook' ); ?>" value="<?= $urlFacebook ?>"/>
        </p>

        <p>
            <label for="<?= $this->get_field_id( 'urlTwitter' ); ?>"> <?= _e( 'Twitter' ); ?></label>
            <input class="widefat" type="text" id="<?= $this->get_field_id( 'urlTwitter' ); ?>"
                   name="<?= $this->get_field_name( 'urlTwitter' ); ?>" value="<?= $urlTwitter ?>"/>
        </p>

        <p>
            <label for="<?= $this->get_field_id( 'urlInstagram' ); ?>"> <?= _e( 'Instagram' ); ?></label>
            <input class="widefat" type="text" id="<?= $this->get_field_id( 'urlInstagram' ); ?>"
                   name="<?= $this->get_field_name( 'urlInstagram' ); ?>" value="<?= $urlInstagram ?>"/>
        </p>

        <p>
            <label for="<?= $this->get_field_id( 'urlYoutube' ); ?>"> <?= _e( 'Youtube' ); ?></label>
            <input class="widefat" type="text" id="<?= $this->get_field_id( 'urlYoutube' ); ?>"
                   name="<?= $this->get_field_name( 'urlYoutube' ); ?>" value="<?= $urlYoutube ?>"/>
        </p>

		<?php

	}

}

?>

```

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

