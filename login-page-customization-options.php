<?php
/**
 * Login form Customizaton
 */

function lh_login_logo() {
	$logo = get_option('login_form_logo');
	?>
		<style type="text/css">
	        #login h1 a, .login h1 a {
	            background-image: url(<?php echo esc_url($logo);?>);
	        }
		</style>
	<?php
}
add_action( 'login_enqueue_scripts', 'lh_login_logo' );

function lh_login_logo_url() {
	$logo_url = get_option('lgoo_url');
	if (!empty($logo_url)) {
		return $logo_url;
	} else {
		return home_url();
	}

}
add_filter( 'login_headerurl', 'lh_login_logo_url' );

function lh_login_stylesheet() {
	wp_enqueue_style( 'custom-login', get_stylesheet_directory_uri() . '/assets/css/style-login.css' );
//	wp_enqueue_script( 'custom-login', get_stylesheet_directory_uri() . '/assets/css/style-login.js' );

	$logo = get_option('login_form_logo');
	$background_color = get_option('background_color');
	$background_image = get_option('background_image');
	$login_box_background = get_option('login_box_background');
	$login_box_border_radius = get_option('login_box_border_radius');
	$login_box_border_radius = $login_box_border_radius."px";
	$login_form_label_color = get_option('login_form_label_color');
	$submit_button_background = get_option('submit_button_background');
	$submit_button_color = get_option('submit_button_color');
	$input_background_color = get_option('input_background_color');
	$input_border_color = get_option('input_border_color');
	$input_color = get_option('input_color');
	$login_nav_color = get_option('login_nav_color');
	$login_backlog_color = get_option('login_backlog_color');


    $custom_login = '';
    $custom_login .= "
        #login h1 a, .login h1 a {
            background-image: url($logo);
        }
    ";

    if (!empty($background_image)) {
	    $custom_login .= "
        body.login {
            background-image: url($background_image);
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
            position: relative;
            z-index: 1;
        }
        body.login:after {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: $background_color;
            z-index: -1;
            content: '';
        }
            
    ";
    } else {
	    $custom_login .= "
        body.login {
            background-color: $background_color;
        }
    ";
    }

    $custom_login .= "
        body.login div#login form#loginform,
        body.login div#login form#lostpasswordform  {
            background: $login_box_background;
            border-color: $login_box_background;
            border-radius: $login_box_border_radius
        }
    ";
    $custom_login .= "
        body.login div#login form#loginform label,
        body.login div#login form#lostpasswordform label,
        body.login div#login form#loginform p label {
            color: $login_form_label_color;
        }
    ";
    $custom_login .= "
        #login form p {
            width: 100%;
            display: block;
        }
    ";
    $custom_login .= "
    body.login div#login form#lostpasswordform input#user_login,
    body.login div#login form#loginform input#user_login,
    body.login div#login form#loginform input#user_pass {
            background: $input_background_color;
            color: $input_color;
            border-color: $input_border_color;
        }
        .dashicons-visibility:before {
            color: $input_color;
        }
    ";
    $custom_login .= "
        body.login div#login form#lostpasswordform p.submit input#wp-submit,
        body.login div#login form#loginform p.submit input#wp-submit {
            background: $submit_button_background;
            color: $submit_button_color;
            border-color: $submit_button_background;
            display: block;
            width: 100%;
            margin-top: 13px;
        }
    ";
    $custom_login .= "
        body.login div#login p#nav a {
            color: $login_nav_color;
        }
    ";
    $custom_login .= "
        body.login div#login p#backtoblog a {
            color: $login_backlog_color
        }
    ";

    wp_add_inline_style('custom-login', $custom_login);
}
add_action( 'login_enqueue_scripts', 'lh_login_stylesheet' );