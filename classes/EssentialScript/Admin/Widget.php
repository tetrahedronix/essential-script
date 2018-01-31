<?php

/*
 * Copyright (C) 2017 docwho
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace EssentialScript\Admin;

/**
 * Essential Script Widget
 * 
 * Creates a widget for adding the script to your sidebar. 
 * Please visit https://codex.wordpress.org/Widgets_API for more details
 * about this class.
 *
 * @author docwho
 */
class Widget extends \WP_Widget {
	/**
	 * Id for this widget.
	 */
	const CLASS_WIDGET = 'essential_script';
	/**
	 * @var object Plugin options from Wordpress DB.
	 */
	private $options;
	/**
	 * @var array Default fields for this widget.
	 */
	protected $default_instance = array(
		'title' => '',
		'content' => '',
	);
	/**
	 * Sets up the widget.
	 */
	public function __construct() {
		// Essential Script options.
		$this->options = new \EssentialScript\Core\Options;
		// Widget options
		$widget_opts = array (
			// Class name added to the <li> element.
			'classname' => self::CLASS_WIDGET,
			// Description for the Widget Screen.
			'description' => esc_html__( 
				'Arbitrary Javascript/XML code.', 'essential-script'),
			'customize_selective_refresh' => true
		);
		/* __CLASS__: ID for the tags <div>
		 * 'Essential Script': widget title displayed in the Widgets screen.
		 * $widget_opts: widget options.
		 */
		parent::__construct( self::CLASS_WIDGET,
			esc_html__( 'Essential Script', 'essential-script' ), 
			$widget_opts
		);
		//if ( is_active_widget( false, false, $this->id_base ) || is_customize_preview() ) {
		add_action( 'current_screen', array( $this, 'enqueue_admin_scripts') );
		//} 
	}
	
	/**
	 * Displays the widget form in Apparence/Widgets menu.
	 * 
	 * @see WP_Widget::form()
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, $this->default_instance );
		$title = !empty( $instance['title'] ) ? $instance['title'] : '';
			//esc_html__( 'New Title', 'essential-script' );
?>
<p>
	<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
		<?php esc_attr_e( 'Title', 'essential-script' ); ?>:
	</label>
	<input class="widefat" 
		   id="<?php echo esc_attr(	$this->get_field_id( 'title' ) ) ;?>"
		   name="<?php echo esc_attr( $this->get_field_name( 'title' ) ) ?>"
		   type="text"
		   value="<?php echo esc_attr( $title ); ?>">
</p>
<p>
	<textarea class="widefat code"
			  rows="16" cols="20"
			  id="<?php echo esc_attr( $this->get_field_id( 'content' ) ); ?>"
			  name="<?php echo esc_attr( $this->get_field_name( 'content' ) ); ?>">
<?php echo $this->gettextarea(); ?></textarea>
</p>  
<?php
		//return '';
	}
	
	public function gettextarea() {
		$textarea = '';
		$storage = 'file';
		$script = '';
		
		if ( $this->options->offsetExists('storage') ) {
			$storage = $this->options->offsetGet( 'storage' );
		}
		
		if ( $this->options->offsetExists( 'script' ) ) {
			$script = $this->options->offsetGet( 'script' ); 
		}
		
		switch ( $storage ) {
			case 'wpdb':
				$textarea = $script;
				break;
			case 'file':
				$f = $this->options['path'] . '/' . $this->options['filename'];
				if ( file_exists( $f ) ) {
					$textarea = file_get_contents( $f );
				} else {
					add_settings_error(
						// slug title for our settings.
						'essentialscript_messages',
						// slug name for this error/event
						'essentialscript_file_error',
						// The formatted message text to display.
						__('File ' . $f . ' Not found', 'essential-script'),
						// The type of message it is: error/updated
						'error'								
					);
					settings_errors();
					$textarea = '';
				}
					break;
		}

		return $textarea; 
	}
	
	/**
	 * Outputs the content of the Widget.
	 * 
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		if ( !empty ( $instance['title'] ) ) {
			echo $args['before_title'] . 
				apply_filters( 'widget_title', $instance['title'] ) .
				$args['after_title'];
		}
		echo $this->gettextarea();
		echo $args['after_widget'];
	}
	
	/**
	 * Processing widget options on save.
	 * 
	 * @see WP_Widget::update()
	 * 
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 * 
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array_merge( $this->default_instance, $old_instance );
		$instance['title'] = ( !empty ( $new_instance['title'] ) ) ?
			sanitize_text_field( $new_instance['title'] ) : '';
		
		return $instance;
	}
	/**
	 * Loads the required scripts and styles for the widget control.
	 * 
	 * @param object $current_screen Current WP_Screen object.
	 * @since 0.9
	 */
	public function enqueue_admin_scripts( $current_screen ) {
		$highlighter = 'xml';
		
		if ( $this->options->offsetExists( 'highlighter' ) ) {
			$highlighter = $this->options['highlighter'];
		} 
		
		if ( 'widgets' === $current_screen->id ) {
			new \EssentialScript\Admin\Queuing(
				'widgets',
				// Necessary dependencies to run Codemirror inside the Widget.
				array ( 'widgets-wp-codemirror' ),
				array ( $highlighter, $this->id_base ) );
		}
		
	}
}
