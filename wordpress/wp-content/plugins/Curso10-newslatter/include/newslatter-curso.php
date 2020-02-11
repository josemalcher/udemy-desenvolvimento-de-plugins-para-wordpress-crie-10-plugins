<?php

class Newslatter_Curso_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'newslatter_curso_widget', // Base ID
			'Newslatter - Curso WP-Plugin', // Name
			//esc_html__('Newslatter Curso','ns_domain').
			array( 'description' => __( 'Newslatter do Curso', 'ns_domain' ), ) // Args
		);
	}

	public function widget( $args, $instance ) {

		echo $args['before_widget'];
		echo $args['before_title'];

		if ( ! empty( $instance['title'] ) ) {
			echo $instance['title'];
		}
		echo $args['after_title'];

		$script_mailer = "/Curso10-newslatter/include/newslatter-curso-mailer.php";
		?>

        <div id="form-msg">

        </div>
        <form id="subscriber-form" method="post" action="<?php echo plugins_url() . $script_mailer; ?>">
            <div class="form-group">
                <label for="name">Nome: </label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="text" id="email" name="email" class="form-control" required>
            </div>
            <br>
            <input type="hidden" name="recipient" value="<?php $instance['recipient']; ?>">
            <input type="hidden" name="subject" value="<?php $instance['subject']; ?>">
            <input type="submit" class="btn btn-primaty" name="subscriber_submit" value="Inscreva-se">

        </form>
        <br>

		<?php


	}

	public function form( $instance ) {
		$title     = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Newslatter Curso', 'ns_domain' );
		$recipient = $instance['recipient'];
		$subject   = ! empty( $instance['subject'] ) ? $instance['subject'] : __( 'Você tem um novo inscrito', 'ns_domain' );

		?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>">
				<?php echo __( 'Título' ); ?>
            </label>
            <br>
            <input type="text"
                   id="<?php echo $this->get_field_id( 'title' ); ?>"
                   name="<?php echo $this->get_field_name( 'title' ); ?>"
                   value="<?php echo esc_attr( $title ); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'recipient' ); ?>">
				<?php echo __( 'Destinatário' ); ?>
            </label>
            <br>
            <input type="text"
                   id="<?php echo $this->get_field_id( 'recipient' ); ?>"
                   name="<?php echo $this->get_field_name( 'recipient' ); ?>"
                   value="<?php echo esc_attr( $recipient ); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'subject' ); ?>">
				<?php echo __( 'Assunto' ); ?>
            </label>
            <br>
            <input type="text"
                   id="<?php echo $this->get_field_id( 'subject' ); ?>"
                   name="<?php echo $this->get_field_name( 'subject' ); ?>"
                   value="<?php echo esc_attr( $subject ); ?>">
        </p>


		<?php

	}

	public function update( $new_instance, $old_instance ) {
		$instance = array(
			'title'     => ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '',
			'recipient' => ( ! empty( $new_instance['recipient'] ) ) ? strip_tags( $new_instance['recipient'] ) : '',
			'subject'   => ( ! empty( $new_instance['subject'] ) ) ? strip_tags( $new_instance['subject'] ) : '',
		);

		return $instance;
	}
}

?>