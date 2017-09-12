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
	
	private $options;

	/**
	 * Sets up the widget.
	 */
	public function __construct() {
		// Essential Script options.
		$this->options = new \EssentialScript\Core\Options;
		// Widget options
		$widget_opts = array (
			/* According mathiasbynens.be/demo/crazy-class,
			 * __CLASS__ is valid css name.
			 */
			'classname' => __CLASS__,   // Class name added to the <li> element.
			'description' => esc_html__( // Description for the Widget Screen.
				'Arbitrary Javascript/XML code.', 'essential-script')
		);
		/* __CLASS__: ID for the tag <li>
		 * 'Essential Script': widget title displayed in the Widgets screen.
		 * $widget_opts: widget options.
		 */
		parent::__construct( 
				__CLASS__, 
				esc_html__( 'Essential Script', 'essential-script' ), 
				$widget_opts 
		);
		$enqueued = new \EssentialScript\Admin\Queuing;
		$enqueued->init( 'widgets.php' );
	}
	
	/**
	 * Displays the widget form in Apparence/Widgets menu.
	 * 
	 * @see WP_Widget::form()
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title = !empty( $instance['title'] ) ? $instance['title'] :
			esc_html__( 'New Title', 'essential-script' );
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
	<label for="<?php echo esc_attr( $this->get_field_id( 'content' ) ); ?>">
		<?php echo esc_attr_e( 'Content', 'essential-script' ); ?>:
	</label>
	<textarea class="widefat code"
			  rows="16" cols="20"
			  id="<?php echo esc_attr( $this->get_field_id( 'content' ) ); ?>"
			  name="<?php echo esc_attr( $this->get_field_name( 'content' ) ); ?>">
<?php echo $this->gettextarea(); ?></textarea>
</p>
<!-- Codemirror -->   
<script>
	//var selector = "widget-essentialscript\\admin\\widget-__i__-content";
	//var textarea_node=document.getElementById(selector);
	var selector = 'textarea[id$="-content"';
	var textarea_node=document.querySelectorAll(selector);
	var editor = CodeMirror.fromTextArea(textarea_node[2], {
		lineNumbers: true,
		mode: { name: "xml", htmlMode: true },
		viewportMargin: Infinity 
});
</script> 
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
						'es_messages',
						// slug name for this error/event
						'es_file_error',
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
	 * @param array $arg
	 * @param array $instance
	 */
	public function widget( $arg, $instance ) {
		echo __CLASS__;
	}
	
	/**
	 * Processing widget options on save.
	 * 
	 * @param array $new_instance The new options.
	 * @param array $old_instance The previous options.
	 */
	public function update( $new_instance, $old_instance ) {
		
	}
}
