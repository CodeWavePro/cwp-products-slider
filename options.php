<?php if ( !defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'is_auto'	=> array(
		'type'	=> 'multi-picker',
		'label' => false,
		'desc'  => false,
		'value' => array(
			'fill'	=> 'auto_fill'
		),

		'picker'	=> array(
			'fill'	=> array(
				'type'		=> 'select',
				'label'		=> esc_html__( 'Slider Content Type', 'mebel-laim' ),
				'desc'		=> esc_html__( 'Please choose content type for slider', 'mebel-laim' ),
				'choices'	=> array(
					'auto_fill'		=> esc_html__( 'Auto Fill', 'mebel-laim' ),
					'manually_fill'	=> esc_html__( 'Fill Manually', 'mebel-laim')
				)
			),
		),

		'choices'	=> array(
			'auto_fill'		=> array(),
			'manually_fill'	=> array(
				'slider'	=> array(
				    'type'			=> 'multi-select',
				    'label'			=> esc_html__( 'Select Products', 'mebel-laim' ),
				    'desc'			=> esc_html__( 'Please select products you need to be placed in slider', 'mebel-laim' ),
				    'population'	=> 'posts',
				    'source'		=> 'products',
				    'prepopulate'	=> false,
				    'limit'			=> 30
				)
			)
		),
		'show_borders'	=> false
	),

	'slides_per_screen'	=> array(
    	'type'	=> 'text',
    	'label'	=> esc_html__( 'Slides Per Screen', 'mebel-laim' ),
	    'desc'	=> esc_html__( 'Please enter the number of slides', 'mebel-laim' )
    ),

    'timer'	=> array(
    	'type'	=> 'text',
    	'label'	=> esc_html__( 'Timer (seconds)', 'mebel-laim' ),
	    'desc'	=> esc_html__( 'Please enter the number of seconds for slider timer', 'mebel-laim' )
    )
);