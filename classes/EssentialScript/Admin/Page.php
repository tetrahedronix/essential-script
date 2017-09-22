<?php
/**
 * @package Essential_Script\Admin
 */
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
 * Manages the administration page, print the fields.
 *
 * @author docwho
 */
final class Page {
	/**
	 * The options from Wordpress DB.
	 * @var array 
	 */
	private $options = array();
	/**
	 * The submenu slug for the administration page.
	 * @var string
	 */
	private $submenu_page;
			
	/**
	 * Setup class.
	 * 
	 * @param \ArrayAccess $opts The plugin options.
	 */
	function __construct( \ArrayAccess $opts ) {
		$this->options = $opts;
		
		$this->submenu_page = \EssentialScript\Admin\Menu::get_slug();
		
		if ( $this->submenu_page ) {
			$enqueued = new \EssentialScript\Admin\Queuing;
			$enqueued->init( $this->submenu_page );
			// Register a new setting for "essentialscript" page.
			register_setting( 'essentialscript_options', 
				'essentialscript_options',
				array ( $this, 'settings_sanitize' )
			);
			$this->settings();
		}
	}

	public function field_where () {
?>
<fieldset>		
<legend class="screen-reader-text">
	<span><?php esc_html_e( 'Choose where to enqueue the script',
			'essential-script' ); ?></span></legend>
<label>
	<input type="radio" name="essentialscript_options[where]" value="head" 
<?php checked( $this->options['where'], 'head', true ) ?>>
	<span class="input-text"><?php esc_html_e( 'Head', 'essential-script' ); ?></span>
</label><br/>
<label>
	<input type="radio" name="essentialscript_options[where]" value="content" 
<?php checked( $this->options['where'], 'content', true ) ?>>
	<span class="input-text"><?php esc_html_e( 'Content', 'essential-script' ); ?></span>
</label><br/>
<label>
	<input type="radio" name="essentialscript_options[where]" value="foot" 
<?php checked( $this->options['where'], 'foot', true ) ?>>
	<span class="input-text"><?php esc_html_e( 'Foot', 'essential-script' ); ?></span>
</label>
</fieldset>					
<?php
	}
	
	public function field_storage() {
?>
<fieldset>
<legend class="screen-reader-text">
	<span><?php esc_html_e( 'Choose where to store the script',
			'essential-script' ); ?></span></legend>
<label>
	<input type="radio" name="essentialscript_options[storage]" value="file" 
<?php checked( $this->options['storage'], 'file', true ); ?>/>
	<span class="input-text"><?php esc_html_e( 'File (Recommended)',
			'essential-script' ); ?></span>
	<input type="text" name="essentialscript_options[filename]" value="<?php echo esc_attr( $this->options['filename'] ); ?>" size="25" />
	<p class="description"><?php esc_html_e( 'Enter the filename',
			'essential-script' ); ?></p>
</label><br/>
<label>
	<input type="radio" name="essentialscript_options[storage]" value="wpdb" 
<?php checked( $this->options['storage'], 'wpdb', true ); ?>/>
	<span class="input-radio"><?php esc_html_e( 'Wordpress DB',
			'essential-script' ); ?></span>
</label>
</fieldset>
<?php
		}
	public function field_pages() {
?>
<fieldset>
<legend class="screen-reader-text">
	<span><?php esc_html_e( 'Pages to exclude', 'essential-script' ); ?></span></legend>
<label>
	<input type="checkbox" name="essentialscript_options[pages][index]" 
<?php checked( $this->options['pages']['index'], true, true ); ?>/>
	<span class="input-text"><?php esc_html_e( 'Default Homepage',
			'essential-script' ); ?></span>
</label><br/>
<label>
	<input type="checkbox" name="essentialscript_options[pages][single]" 
<?php checked( $this->options['pages']['single'], true, true ); ?>/>
	<span class="input-text"><?php esc_html_e( 'Single Post',
			'essential-script' ); ?></span>	
</label><br/>
<label>
	<input type="checkbox" name="essentialscript_options[pages][page]" 
<?php checked( $this->options['pages']['page'], true, true ); ?>/>
	<span class="input-text"><?php esc_html_e( 'Pages', 'essential-script' ); ?></span>
</label><br/>
<label>
	<input type="checkbox" name="essentialscript_options[pages][archive]" 
<?php checked( $this->options['pages']['archive'], true, true ); ?>/>
	<span class="input-text"><?php esc_html_e( 'Archive', 'essential-script' ); ?></span>
</label>
</fieldset>	
<?php		
		}
		
	public function field_textarea() {
		switch ( $this->options['storage'] ) {
			case 'wpdb':
				$textarea = $this->options['script'];
				break;
			case 'file':
				//$dir = wp_upload_dir();
				//$f = $dir['path'] . '/' . $options['filename'];
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
			default:
				$textarea = '';
			}
			
?>
<textarea id="textarea-script" name="essentialscript_options[script]"
		  rows="10" cols="80"><?php echo $textarea; ?></textarea>
<p class="description"><?php esc_html_e( 'Max 512 chars. The allowed tags are listed in settings_sanitize(). You can add or remove tags as required.',
		'essential-script' ); ?></p>
<?php
		echo<<<'JS'
<!-- Codemirror -->   
<script>
   var textarea_node=document.getElementById("textarea-script");
   var editor = CodeMirror.fromTextArea(textarea_node, {
		lineNumbers: true,
		mode: { name: "xml", htmlMode: true },
		viewportMargin: Infinity,
		lint: true
});
</script> 
JS
. PHP_EOL;

	}	

	static function section_text() {
		echo ( '<p>' );
		esc_html_e( 'Fill your script settings below: script code, position and storage.',
				'essential-script' );
		echo ( '</p>' );
	}
	
	private function settings() {
		// Add a new section to a settings page.
		add_settings_section(
			'es_section_id',		// HTML ID tag
			'Script Area',			// The section title text
			'\EssentialScript\Admin\Page::section_text',	// Callback that will echo some explanations
			$this->submenu_page		// Settings page
		);				
		// Register a settings field to a settings page and section.
		add_settings_field( 
			'es_textarea',
			__( 'Enter the script code here', 'essential-script' ),
			array ( $this, 'field_textarea' ),
			$this->submenu_page,
			'es_section_id' );
		add_settings_field(
			'es_radiobutton_where',
			__( 'Choose where to enqueue the script', 'essential-script' ),  
			array ( $this, 'field_where' ),
			$this->submenu_page,
			'es_section_id' );
		add_settings_field(
			'es_checkbox_pages',
			__( 'Pages to exclude', 'essential-script' ),
			array ( $this, 'field_pages' ),
			$this->submenu_page,
			'es_section_id' );
		add_settings_field(
			'es_radiobutton_storage',
			__( 'Choose where to store the script', 'essential-script' ),
			array ( $this, 'field_storage' ),
			$this->submenu_page,
			'es_section_id' );
	}
	
	public function settings_sanitize( $input ) {
		$sane = array ();
		// List of allowed tags and attributes 
		add_filter( 'safe_style_css', function( $styles ) {
			$styles[] = 'display';
			return $styles;
		} );
		$allow_html = array (
			'a' => array (
				'href' => true,
			),
			'center' => array(),
			'img' => array (
				'src' => true,
				'alt' => true,
				'style' => true,
			),
			'ins' => array ( 
				'class' => true,
				'style' => array (
					'display' => true, 
					'width'=> true, 
					'height'=> true ), 
				'data-ad-client' => true,
				'data-ad-slot' => true ),
			'noscript' => true,
			'script' => array (
				'async' => true,
				'src' => true ),
		);
		// Sanitize the script
		$sane['script'] = substr( wp_kses( $input['script'], $allow_html ), 0, 511 );
		// Sanitize where we want the script
 		switch ( $input['where'] ) {
			case 'head':
				$sane['where'] = 'head';
				break;
			case 'content':
				$sane['where'] = 'content';
				break;
			case 'foot':
				$sane['where'] = 'foot';
				break;
			default:
				$sane['where'] = 'foot';
		} 
		/* Sanitize the filename: 
		 * if no name was specified then it creates a hash for the filename, else
		 * sanitize the user input.
		 */
		$f = ( '' === $input['filename'] ) ?
				uniqid( 'es', true ) : sanitize_file_name( $input['filename'] );
		/* Equivalent to:
		if ( $input['filename'] === '' ) {
			// Creates a 23 character hash for the filename
			//$f = md5( time() . mt_rand() );
			$f = uniqid( 'es', true );
		} else {
			$f = sanitize_file_name( $input['filename'] );
		} */
	
		$sane['pages']['index'] = ( 'on' === $input['pages']['index'] ) ? 
				true : false;
		$sane['pages']['single'] = ( 'on' === $input['pages']['single'] ) ? 
				true : false;
		$sane['pages']['page'] = ( 'on' === $input['pages']['page'] ) ? 
				true : false;
		$sane['pages']['archive'] = ( 'on' === $input['pages']['archive'] ) ? 
				true : false;
		/* Equivalent to:
		 * if ( $input['pages']['index'] === 'on' ) {
			$sane['pages']['index'] = true;
		} else {
			$sane['pages']['index'] = false;
		}
		if ( $input['pages']['single'] === 'on' ) {
			$sane['pages']['single'] = true;
		} else {
			$sane['pages']['single'] = false;
		}
		if ( $input['pages']['page'] === 'on' ) {
			$sane['pages']['page'] = true;
		} else {
			$sane['pages']['page'] = false;
		}
		if ( $input['pages']['archive'] === 'on' ) {
			$sane['pages']['archive'] = true;
		} else {
			$sane['pages']['archive'] = false;
		} */
		
		switch ( $input['storage'] ) {
			case 'wpdb':
				$sane['storage'] = 'wpdb';
				$sane['filename'] = '';
				$sane['path'] = '';
				break;
			case 'file':
				$dir = wp_upload_dir();
				// Path to the file where to write the data. 
				$path = $dir['path'] . '/' . $f;
				$sane['storage'] = 'file';
				file_put_contents( $path, $sane['script'] );
				$sane['path'] = $dir['path'];
				$sane['filename'] = $f;
				$sane['script'] = '';
				break;
		} 

		return $sane;
	}
}
