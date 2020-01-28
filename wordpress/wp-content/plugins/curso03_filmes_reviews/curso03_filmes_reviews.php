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
	const FIELD_PREFIX = 'fr_'; // metabox

	public static function getInstance() {
		if ( self::$instance == null ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	private function __construct() {
		add_action( 'init', 'FilmesReviews::register_post_type' );
		add_action( 'init', 'FilmesReviews::register_taxonomies' );
		add_action( 'tgmpa_register', array( $this, 'check_required_plugins' ) );
		add_filter( 'rwmb_meta_boxes', array( $this, 'metabox_custom_fields' ) );
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

	/* FIM META BOX */

	public static function activate() {
		self::register_post_type();
		self::register_taxonomies();
		flush_rewrite_rules();
	}

}

FilmesReviews::getInstance();
register_deactivation_hook( __FILE__, 'flush_rewrite_rules' );
register_activation_hook( __FILE__, 'FilmesReviews::activate' );


