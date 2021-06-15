<?php

/**
 * LemonHive Login Page customization
 */
class lh_login_page_Settings_Page {

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'lh_create_settings' ) );
		add_action( 'admin_init', array( $this, 'lh_setup_sections' ) );
		add_action( 'admin_init', array( $this, 'lh_setup_fields' ) );
		add_action( 'admin_footer', array( $this, 'media_fields' ) );
		wp_enqueue_style( 'wp-color-picker' );
		add_action( 'admin_enqueue_scripts', 'wp_enqueue_media' );
		add_action( 'admin_enqueue_scripts', array( $this,'lh_admin_enqueue_media') );
	}

	public function lh_create_settings() {
		$page_title = __('Login Page Customization', '_s');
		$menu_title = __('Login Page', '_s');
		$capability = 'manage_options';
		$slug = 'lh_login_page';
		$callback = array($this, 'lh_settings_content');
		add_options_page($page_title, $menu_title, $capability, $slug, $callback);
	}

	public function lh_admin_enqueue_media() {
		wp_enqueue_style( 'alpha-color-picker', get_template_directory_uri() . '/assets/css/alpha-color-picker.css');
		wp_enqueue_script( 'wp-color-picker-alpha', get_template_directory_uri() . '/assets/js/alpha-color-picker.js' , array( 'jquery', 'wp-color-picker' ), '', true  );
		wp_enqueue_script( 'cpa_custom_js', get_template_directory_uri() . '/assets/js/login-page-customizer.js' , array( 'jquery', 'wp-color-picker' ), '', true  );
	}


	public function lh_settings_content() { ?>
        <div class="wrap">
            <h1><?php esc_html_e('Login Page', '_s'); ?></h1>
            <form method="POST" action="options.php">
				<?php
				settings_fields( 'lh_login_page' );
				do_settings_sections( 'lh_login_page' );
				submit_button();
				?>
            </form>
        </div> <?php
	}

	public function lh_setup_sections() {
		add_settings_section( 'lh_login_page_section', '', array(), 'lh_login_page' );
	}

	public function lh_setup_fields() {
		$fields = array(
			array(
				'section' => 'lh_login_page_section',
				'label' => __('Background Color', '_s'),
				'id' => 'background_color',
				'type' => 'text',
			),
			array(
				'section' => 'lh_login_page_section',
				'label' => __('Background Image', '_s'),
				'id' => 'background_image',
				'type' => 'media',
				'returnvalue' => 'url'
			),
			array(
				'section' => 'lh_login_page_section',
				'label' => __('Logo', '_s'),
				'id' => __('login_form_logo', '_s'),
				'desc' => __('Logo Will be 80x80px and svg format', '_s'),
				'type' => 'media',
				'returnvalue' => 'url'
			),
			array(
				'section' => 'lh_login_page_section',
				'label' => __('Logo Url', '_s'),
				'id' => 'lgoo_url',
				'type' => 'url',
			),
			array(
				'section' => 'lh_login_page_section',
				'label' => __('Login Box Backgroud', '_s'),
				'id' => 'login_box_background',
				'type' => 'text',
			),
			array(
				'section' => 'lh_login_page_section',
				'label' => __('Login Box Border Radius', '_s'),
				'id' => 'login_box_border_radius',
				'type' => 'number',
			),
			array(
				'section' => 'lh_login_page_section',
				'label' => __('Form Label Color', '_s'),
				'id' => 'login_form_label_color',
				'type' => 'text',
			),
			array(
				'section' => 'lh_login_page_section',
				'label' => __('Input Background', '_s'),
				'id' => 'input_background_color',
				'type' => 'text',
			),
			array(
				'section' => 'lh_login_page_section',
				'label' => __('Input Border Color', '_s'),
				'id' => 'input_border_color',
				'type' => 'text',
			),
			array(
				'section' => 'lh_login_page_section',
				'label' => __('Input Color', '_s'),
				'id' => 'input_color',
				'type' => 'text',
			),
			array(
				'section' => 'lh_login_page_section',
				'label' => __('Submit Button Backgroud', '_s'),
				'id' => 'submit_button_background',
				'type' => 'text',
			),
			array(
				'section' => 'lh_login_page_section',
				'label' => __('Submit Button Color', '_s'),
				'id' => 'submit_button_color',
				'type' => 'text',
			),
			array(
				'section' => 'lh_login_page_section',
				'label' => __('Nav Color', '_s'),
				'id' => 'login_nav_color',
				'type' => 'text',
			),
			array(
				'section' => 'lh_login_page_section',
				'label' => __('Backlog Color', '_s'),
				'id' => 'login_backlog_color',
				'type' => 'text',
			),
		);
		foreach( $fields as $field ){
			add_settings_field( $field['id'], $field['label'], array( $this, 'lh_field_callback' ), 'lh_login_page', $field['section'], $field );
			register_setting( 'lh_login_page', $field['id'] );
		}
	}
	public function lh_field_callback( $field ) {
		$value = get_option( $field['id'] );
		$placeholder = '';
		if ( isset($field['placeholder']) ) {
			$placeholder = $field['placeholder'];
		}
		switch ( $field['type'] ) {

			case 'media':
				$field_url = '';
				if ($value) {
					if ($field['returnvalue'] == 'url') {
						$field_url = $value;
					} else {
						$field_url = wp_get_attachment_url($value);
					}
				}
				printf(
					'<input style="display:none;" id="%s" name="%s" type="text" value="%s"  data-return="%s"><div id="preview%s" style="margin-right:10px;border:1px solid #e2e4e7;background-color:#fafafa;display:inline-block;width: 100px;height:100px;background-image:url(%s);background-size:cover;background-repeat:no-repeat;background-position:center;"></div><input style="width: 19%%;margin-right:5px;" class="button menutitle-media" id="%s_button" name="%s_button" type="button" value="Select" /><input style="width: 19%%;" class="button remove-media" id="%s_buttonremove" name="%s_buttonremove" type="button" value="Clear" />',
					$field['id'],
					$field['id'],
					$value,
					$field['returnvalue'],
					$field['id'],
					$field_url,
					$field['id'],
					$field['id'],
					$field['id'],
					$field['id']
				);
				break;

			case 'text':
				printf( '<input class="cpa-color-picker" name="%1$s" id="%1$s" type="%2$s" placeholder="%3$s" value="%4$s" />',
					$field['id'],
					$field['type'],
					$placeholder,
					$value
				);
				break;

			default:
				printf( '<input class="regular-text" name="%1$s" id="%1$s" type="%2$s" placeholder="%3$s" value="%4$s" />',
					$field['id'],
					$field['type'],
					$placeholder,
					$value
				);
		}
		if( isset($field['desc']) ) {
			if( $desc = $field['desc'] ) {
				printf( '<p class="description">%s </p>', $desc );
			}
		}
	}

	public function media_fields() {
		?><script>
            jQuery(document).ready(function($){
                if ( typeof wp.media !== 'undefined' ) {
                    var _custom_media = true,
                        _orig_send_attachment = wp.media.editor.send.attachment;
                    $('.menutitle-media').click(function(e) {
                        var send_attachment_bkp = wp.media.editor.send.attachment;
                        var button = $(this);
                        var id = button.attr('id').replace('_button', '');
                        _custom_media = true;
                        wp.media.editor.send.attachment = function(props, attachment){
                            if ( _custom_media ) {
                                if ($('input#' + id).data('return') == 'url') {
                                    $('input#' + id).val(attachment.url);
                                } else {
                                    $('input#' + id).val(attachment.id);
                                }
                                $('div#preview'+id).css('background-image', 'url('+attachment.url+')');
                            } else {
                                return _orig_send_attachment.apply( this, [props, attachment] );
                            };
                        }
                        wp.media.editor.open(button);
                        return false;
                    });
                    $('.add_media').on('click', function(){
                        _custom_media = false;
                    });
                    $('.remove-media').on('click', function(){
                        var parent = $(this).parents('td');
                        parent.find('input[type="text"]').val('');
                        parent.find('div').css('background-image', 'url()');
                    });
                }
            });
        </script><?php
	}


}
new lh_login_page_Settings_Page();
