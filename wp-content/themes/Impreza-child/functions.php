<?php
function adding_scripts() {
    wp_register_script('my_js', get_stylesheet_directory_uri().'/custom.js', array('jquery'),'1.1', true);
    wp_enqueue_script('my_js');
 } 

add_action( 'wp_enqueue_scripts', 'adding_scripts',999 );

//vc_map( array(
//    "name" => __("Bar tag test"),
//    "base" => "bartag",
//    "category" => __('Content'),
//    "params" => array(
//        array(
//            "type" => "textfield",
//            "holder" => "div",
//            "class" => "",
//            "heading" => __("Text"),
//            "param_name" => "foo",
//            "value" => __("Default params value"),
//            "description" => __("Description for foo param.")
//        )
//    )
//) );

add_action( 'wp_ajax_nopriv_get_product', 'get_product' );
add_action( 'wp_ajax_get_product', 'get_product' );

function get_product() {
	// get the submitted parameters
	$postID = $_POST['post_id'];

	$post = get_post($postID);
//die(json_encode( $post ));
	$response['content']=$post->post_content;
	$response['name']=$post->post_title;
	$response['status']=$post->post_status;

	$response['image'] = wp_get_attachment_url( get_post_thumbnail_id($post->ID), 'medium' );

	$response['opis'] = $post->post_content;
	$response['title'] = get_post_custom_values('title1', $post->ID)[0];
	$response['spec'] = wp_get_attachment_url( get_post_custom_values('specyfikacja', $post->ID)[0]);

	$response = json_encode( $response );

 // response output
 header( "Content-Type: application/json" );
 echo $response;

 // IMPORTANT: don't forget to "exit"
 exit;
}

function remove_core_updates(){
	global $wp_version;return(object) array('last_checked'=> time(),'version_checked'=> $wp_version,);
}
add_filter('pre_site_transient_update_core','remove_core_updates');
add_filter('pre_site_transient_update_plugins','remove_core_updates');
add_filter('pre_site_transient_update_themes','remove_core_updates');

function fuege_javascripts_ein() {
	wp_enqueue_script( 'jqueryMagnificPopup', get_template_directory_uri() . '/framework/js/jquery.magnific-popup.js', array( 'jquery' ) );
}
add_action( 'wp_enqueue_scripts', 'fuege_javascripts_ein' );
