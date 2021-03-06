<?php defined( 'ABSPATH' ) OR die( 'This script cannot be accessed directly.' );

/**
 * Shortcode: us_social_links
 *
 * @var $shortcode string Current shortcode name
 * @var $config array Shortcode's config
 *
 * @param $config ['atts'] array Shortcode's attributes and default values
 */

$social_links = us_config( 'social_links' );

$social_links_config = array();

$weight = 300;
foreach ( $social_links as $name => $title ) {
	$social_links_config[] = array(
		'param_name' => $name,
		'heading' => $title,
		'type' => 'textfield',
		'std' => $config['atts'][ $name ],
		'edit_field_class' => 'vc_col-sm-4',
		'weight' => $weight,
	);
	$weight -= 1;
}

vc_map( array(
	'base' => 'us_social_links',
	'name' => __( 'Social Links', 'us' ),
	'icon' => 'icon-wpb-ui-separator',
	'category' => us_translate_with_external_domain( 'Content', 'js_composer' ),
	'weight' => 170,
	'params' => array_merge(
		array(
			array(
				'param_name' => 'email',
				'heading' => __( 'Email', 'us' ),
				'type' => 'textfield',
				'std' => $config['atts']['email'],
				'edit_field_class' => 'vc_col-sm-4',
				'weight' => 301,
			),
		),
		$social_links_config,
		array(
			array(
				'param_name' => 'custom_link',
				'heading' => __( 'Custom Link', 'us' ),
				'type' => 'textfield',
				'std' => $config['atts']['custom_link'],
				'weight' => 50,
			),
			array(
				'param_name' => 'custom_title',
				'heading' => __( 'Custom Link Title', 'us' ),
				'type' => 'textfield',
				'std' => $config['atts']['custom_title'],
				'dependency' => array( 'element' => 'custom_link', 'not_empty' => TRUE ),
				'weight' => 40,
			),
			array(
				'param_name' => 'custom_icon',
				'heading' => __( 'Custom Link Icon', 'us' ),
				'description' => sprintf( __( '%s or %s icon name', 'us' ), '<a href="http://fontawesome.io/icons/" target="_blank">FontAwesome</a>', '<a href="https://material.io/icons/" target="_blank">Material</a>' ),
				'type' => 'textfield',
				'std' => $config['atts']['custom_icon'],
				'dependency' => array( 'element' => 'custom_link', 'not_empty' => TRUE ),
				'edit_field_class' => 'vc_col-sm-6',
				'weight' => 30,
			),
			array(
				'param_name' => 'custom_color',
				'heading' => __( 'Custom Link Color', 'us' ),
				'type' => 'colorpicker',
				'std' => $config['atts']['custom_color'],
				'dependency' => array( 'element' => 'custom_link', 'not_empty' => TRUE ),
				'weight' => 20,
			),
			array(
				'param_name' => 'style',
				'heading' => __( 'Icons Style', 'us' ),
				'type' => 'dropdown',
				'value' => array(
					__( 'Simple', 'us' ) => 'default',
					__( 'Inside the Solid square', 'us' ) => 'solid_square',
					__( 'Inside the Outlined square', 'us' ) => 'outlined_square',
					__( 'Inside the Solid circle', 'us' ) => 'solid_circle',
					__( 'Inside the Outlined circle', 'us' ) => 'outlined_circle',
				),
				'std' => $config['atts']['style'],
				'edit_field_class' => 'vc_col-sm-6',
				'group' => __( 'Styling', 'us' ),
				'weight' => 19,
			),
			array(
				'param_name' => 'color',
				'heading' => __( 'Icons Color', 'us' ),
				'type' => 'dropdown',
				'value' => array(
					__( 'Default brands colors', 'us' ) => 'brand',
					__( 'Text (theme color)', 'us' ) => 'text',
					__( 'Link (theme color)', 'us' ) => 'link',
				),
				'std' => $config['atts']['color'],
				'edit_field_class' => 'vc_col-sm-6',
				'group' => __( 'Styling', 'us' ),
				'weight' => 18,
			),
			array(
				'param_name' => 'size',
				'heading' => __( 'Icons Size', 'us' ),
				'description' => sprintf(__( 'Examples: %s', 'us' ), '26px, 1.3em, 200%'),
				'type' => 'textfield',
				'std' => $config['atts']['size'],
				'edit_field_class' => 'vc_col-sm-6',
				'group' => __( 'Styling', 'us' ),
				'weight' => 12,
			),
			array(
				'param_name' => 'align',
				'heading' => __( 'Icons Alignment', 'us' ),
				'type' => 'dropdown',
				'value' => array(
					__( 'Left', 'us' ) => 'left',
					__( 'Center', 'us' ) => 'center',
					__( 'Right', 'us' ) => 'right',
				),
				'std' => $config['atts']['align'],
				'edit_field_class' => 'vc_col-sm-6',
				'group' => __( 'Styling', 'us' ),
				'weight' => 11,
			),
			array(
				'param_name' => 'el_class',
				'heading' => us_translate_with_external_domain( 'Extra class name', 'js_composer' ),
				'description' => us_translate_with_external_domain( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'js_composer' ),
				'type' => 'textfield',
				'std' => $config['atts']['el_class'],
				'group' => __( 'Styling', 'us' ),
				'weight' => 10,
			),
		)
	),
) );
