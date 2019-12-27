<?php if ( !defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = [
	'is_auto'	=> [
		'type'	=> 'multi-picker',
		'label' => false,
		'desc'  => false,
		'value' => [
			'fill'	=> 'auto_fill'
		],

		'picker'	=> [
			'fill'	=> [
				'type'		=> 'select',
				'label'		=> esc_html__( 'Slider Content Type', 'mebel-laim' ),
				'desc'		=> esc_html__( 'Please choose content type for slider', 'mebel-laim' ),
				'choices'	=> [
					'auto_fill'		=> esc_html__( 'Auto Fill', 'mebel-laim' ),
					'manually_fill'	=> esc_html__( 'Fill Manually', 'mebel-laim')
				]
			]
		],

		'choices'	=> [
			'auto_fill'		=> [],
			'manually_fill'	=> [
				'slider'	=> [
				    'type'			=> 'multi-select',
				    'label'			=> esc_html__( 'Select Products', 'mebel-laim' ),
				    'desc'			=> esc_html__( 'Please select products you need to be placed in slider', 'mebel-laim' ),
				    'population'	=> 'posts',
				    'source'		=> 'products',
				    'prepopulate'	=> false,
				    'limit'			=> 30
				]
			]
		],
		'show_borders'	=> false
	],

	'slides_per_screen'	=> [
    	'type'	=> 'text',
    	'label'	=> esc_html__( 'Slides Per Screen', 'mebel-laim' ),
	    'desc'	=> esc_html__( 'Please enter the number of slides', 'mebel-laim' )
    ],

    'slides_max_count'	=> [
    	'type'	=> 'text',
    	'label'	=> esc_html__( 'Maximum Slides Count', 'mebel-laim' ),
	    'desc'	=> esc_html__( 'Please enter maximum slides count', 'mebel-laim' )
    ],

    'timer'	=> [
    	'type'	=> 'text',
    	'label'	=> esc_html__( 'Timer (seconds)', 'mebel-laim' ),
	    'desc'	=> esc_html__( 'Please enter the number of seconds for slider timer', 'mebel-laim' )
    ],

    'slider_bg_color' => [
		'label' => __( 'Background Color', 'mebel-laim' ),
		'desc'  => __( 'Please select the background color', 'mebel-laim' ),
		'type'  => 'color-picker'
	],

	'margin_top'	=> [
    	'type'	=> 'text',
    	'label'	=> esc_html__( 'Margin Top (px)', 'mebel-laim' ),
	    'desc'	=> esc_html__( 'Please enter margin top value in pixels', 'mebel-laim' )
    ],

    'margin_bottom'	=> [
    	'type'	=> 'text',
    	'label'	=> esc_html__( 'Margin Bottom (px)', 'mebel-laim' ),
	    'desc'	=> esc_html__( 'Please enter margin bottom value in pixels', 'mebel-laim' )
    ],

    'specification_icon'  => [
        'type'          => 'icon-v2',
        'label'         => esc_html__( 'Specification Icon', 'mebel-laim' ),
        'desc'          => esc_html__( 'Please choose icon for specification field', 'mebel-laim' ),
        'preview_size'  => 'medium',
        'modal_size'    => 'medium'
    ],

    'currency_icon'  => [
        'type'          => 'icon-v2',
        'label'         => esc_html__( 'Currency Icon', 'mebel-laim' ),
        'desc'          => esc_html__( 'Please choose icon for currency', 'mebel-laim' ),
        'preview_size'  => 'medium',
        'modal_size'    => 'medium'
    ]
];