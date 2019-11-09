<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$cfg = array();

$cfg['page_builder'] = array(
	'title'			=> esc_html__( 'CWP Products Slider', 'mebel-laim' ),
	'description'	=> esc_html__( 'Add slider with settings.', 'mebel-laim' ),
	'tab'			=> esc_html__( 'Media Elements', 'mebel-laim' ),
	'icon' 			=> 'dashicons dashicons-format-gallery'
);