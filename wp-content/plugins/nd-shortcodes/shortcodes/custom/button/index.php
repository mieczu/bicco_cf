<?php

//START
add_shortcode('nd_options_button', 'nd_options_shortcode_button');
function nd_options_shortcode_button($atts, $content = null)
{  

  $atts = shortcode_atts(
  array(
    'nd_options_class' => '',
    'nd_options_layout' => '',
    'nd_options_link' => '',
    'nd_options_image' => '',
    'nd_options_image_width' => '',
    'nd_options_text_color' => '',
    'nd_options_bg_color' => '',
    'nd_options_padding' => '',
    'nd_options_margin' => '',
    'nd_options_font_family' => '',
    'nd_options_font_size' => '',
    'nd_options_border_radius' => '',
    'nd_options_border_color' => '',
    'nd_options_border_width' => '',
  ), $atts);

  $str = '';

  //get variables
  $nd_options_class = $atts['nd_options_class'];
  $nd_options_layout = $atts['nd_options_layout'];
  $nd_options_border_color = $atts['nd_options_border_color'];
  $nd_options_border_width = $atts['nd_options_border_width'];
  $nd_options_text_color = $atts['nd_options_text_color'];
  $nd_options_bg_color = $atts['nd_options_bg_color'];
  $nd_options_padding = $atts['nd_options_padding'];
  $nd_options_margin = $atts['nd_options_margin'];
  $nd_options_font_family = $atts['nd_options_font_family'];
  $nd_options_font_size = $atts['nd_options_font_size'];
  $nd_options_border_radius = $atts['nd_options_border_radius'];
  $nd_options_image_width = $atts['nd_options_image_width'];

  //nd_options_image
  $nd_options_image_src = wp_get_attachment_image_src($atts['nd_options_image'],'large');


  //nd_options_link 
  $nd_options_link = vc_build_link( $atts['nd_options_link'] );
  $nd_options_link_url = $nd_options_link['url'];
  $nd_options_link_title = $nd_options_link['title'];
  $nd_options_link_target = $nd_options_link['target'];
  $nd_options_link_rel = $nd_options_link['rel'];


  //target attr
  if ( $nd_options_link_target == '' ) {
    $nd_options_link_target_output = '';
  }else{
    $nd_options_link_target_output = 'target="'.$nd_options_link_target.'"';
  }

  
  //default value for avoid error include
  if ($nd_options_layout == '') { $nd_options_layout = "layout-1"; }

  //include the layout selected
  include 'layout/'.$nd_options_layout.'.php';

   return apply_filters('uds_shortcode_out_filter', $str);
}
//END PRICE





//vc
add_action( 'vc_before_init', 'nd_options_button' );
function nd_options_button() {


    //START get all layout
  $nd_options_layouts = array();

  //php function to descover all name files in directory
  $nd_options_directory = plugin_dir_path( __FILE__ ) .'layout/';
  $nd_options_layouts = scandir($nd_options_directory);


  //cicle for delete hidden file that not are php files
  $i = 0;
  foreach ($nd_options_layouts as $value) {
    
    //remove all files that aren't php
    if ( strpos( $nd_options_layouts[$i] , ".php" ) != true ){
      unset($nd_options_layouts[$i]);
    }else{
      $nd_options_layout_name = str_replace(".php","",$nd_options_layouts[$i]);
      $nd_options_layouts[$i] = $nd_options_layout_name;
    } 
    $i++; 

  }
  //END get all layout


   vc_map( array(
      "name" => __( "Button", "nd-shortcodes" ),
      "base" => "nd_options_button",
      'description' => __( 'Add Button', 'nd-shortcodes' ),
      'show_settings_on_create' => true,
      "icon" => plugins_url() . "/nd-shortcodes/shortcodes/custom/thumb/button.jpg",
      "class" => "",
      "category" => __( "NDS - Orange Coll.", "nd-shortcodes"),
      "params" => array(

        array(
           'type' => 'dropdown',
            'heading' => "Layout",
            'param_name' => 'nd_options_layout',
            'value' => $nd_options_layouts,
            'description' => __( "Choose the layout", "nd-shortcodes" )
         ),
        array(
            'type' => 'attach_image',
            'heading' => __( 'Image', 'nd-shortcodes' ),
            'param_name' => 'nd_options_image',
            'description' => __( 'Select image from media library.', 'nd-shortcodes' ),
            'dependency' => array( 'element' => 'nd_options_layout', 'value' => array( 'layout-2' ) )
         ),
        array(
            "type" => "textfield",
            "class" => "",
            "heading" => __( "Image Width", "nd-shortcodes" ),
            "param_name" => "nd_options_image_width",
            "description" => __( "Insert the image width in px ( only numbers )", "nd-shortcodes" ),
            'dependency' => array( 'element' => 'nd_options_layout', 'value' => array( 'layout-2' ) )
         ),
        array(
         'type' => 'vc_link',
          'heading' => "Link",
          'param_name' => 'nd_options_link',
          'description' => __( "Insert button link", "nd-shortcodes" )
         ),
        array(
            "type" => "colorpicker",
            "class" => "",
            "heading" => __( "Background Color", "nd-shortcodes" ),
            "param_name" => "nd_options_bg_color",
            "description" => __( "Choose background color", "nd-shortcodes" )
         ),
        array(
            "type" => "colorpicker",
            "class" => "",
            "heading" => __( "Text Color", "nd-shortcodes" ),
            "param_name" => "nd_options_text_color",
            "description" => __( "Choose text color", "nd-shortcodes" ),
            'dependency' => array( 'element' => 'nd_options_layout', 'value' => array( 'layout-1' ) )
         ),
        array(
         'type' => 'dropdown',
          "heading" => __( "Button Padding", "nd-shortcodes" ),
          'param_name' => 'nd_options_padding',
          'value' => array('select'=>'','Padding 5px 10px'=>'5px 10px','Padding 5px'=>'5px','Padding 10px 20px'=>'10px 20px','Padding 10px'=>'10px','Padding 20px'=>'20px'),
          'description' => __( "Select padding for button 'TOP/BOTTOM' and 'LEFT/RIGHT'", "nd-shortcodes" )
         ),
        array(
         'type' => 'dropdown',
          "heading" => __( "Button Margin", "nd-shortcodes" ),
          'param_name' => 'nd_options_margin',
          'value' => array('select'=>'','Margin 5px'=>'5px','Margin 10px'=>'10px','Margin 20px'=>'20px','Margin Right 20px'=>'0px 20px 0px 0px'),
          'description' => __( "Select margin for button 'TOP RIGHT BOTTOM LEFT'", "nd-shortcodes" )
         ),
        array(
         'type' => 'dropdown',
          "heading" => __( "Button Font", "nd-shortcodes" ),
          'param_name' => 'nd_options_font_family',
          'value' => array('select'=>'','First Font'=>'nd_options_first_font','Second Font'=>'nd_options_second_font'),
          'description' => __( "Select Font for button", "nd-shortcodes" ),
          'dependency' => array( 'element' => 'nd_options_layout', 'value' => array( 'layout-1' ) )
         ),
        array(
            "type" => "textfield",
            "class" => "",
            "heading" => __( "Font Size", "nd-shortcodes" ),
            "param_name" => "nd_options_font_size",
            "description" => __( "Insert the font size in px ( only numbers )", "nd-shortcodes" ),
            'dependency' => array( 'element' => 'nd_options_layout', 'value' => array( 'layout-1' ) )
         ),
        array(
            "type" => "textfield",
            "class" => "",
            "heading" => __( "Border Radius", "nd-shortcodes" ),
            "param_name" => "nd_options_border_radius",
            "description" => __( "Insert the border radius in px ( only numbers )", "nd-shortcodes" )
         ),
        array(
            "type" => "colorpicker",
            "class" => "",
            "heading" => __( "Border Color", "nd-shortcodes" ),
            "param_name" => "nd_options_border_color",
            "description" => __( "Choose border color", "nd-shortcodes" )
         ),
        array(
            "type" => "textfield",
            "class" => "",
            "heading" => __( "Border Width", "nd-shortcodes" ),
            "param_name" => "nd_options_border_width",
            "description" => __( "Insert the border width in px ( only numbers )", "nd-shortcodes" )
         ),
         array(
            "type" => "textfield",
            "class" => "",
            "heading" => __( "Custom class", "nd-shortcodes" ),
            "param_name" => "nd_options_class",
            "description" => __( "Insert custom class", "nd-shortcodes" )
         )
  

      )
   ) );
}
//end shortcode