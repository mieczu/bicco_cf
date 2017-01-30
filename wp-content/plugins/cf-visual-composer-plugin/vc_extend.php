<?php
/*
Plugin Name: Coffe Roasters Visual Composer Plugin
Description: Coffe Roasters shortcodes for VC.
Version: 0.1.1
Author: Cezary Mieczkowski
Author URI: http://mailto:czarek.mieczkowski@gmail.com
License: GPLv2 or later
*/

/*
This example/starter plugin can be used to speed up Visual Composer plugins creation process.
More information can be found here: http://kb.wpbakery.com/index.php?title=Category:Visual_Composer
*/

// don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}


class VCExtendAddonClass {
	function __construct() {
		// We safely integrate with VC with this hook
		add_action( 'init', array( $this, 'integrateWithVC' ) );

		// Use this when creating a shortcode addon
		add_shortcode( 'cf_portfolio', array( $this, 'renderMyBartag' ) );

		// Register CSS and JS
		add_action( 'wp_enqueue_scripts', array( $this, 'loadCssAndJs' ) );
	}

	public function integrateWithVC() {
		// Check if Visual Composer is installed
		if ( ! defined( 'WPB_VC_VERSION' ) ) {
			// Display notice that Visual Compser is required
			add_action( 'admin_notices', array( $this, 'showVcVersionNotice' ) );

			return;
		}

		$us_portfolio_categories     = array();
		$us_portfolio_categories_raw = get_categories( array(
			'taxonomy'     => 'us_portfolio_category',
			'hierarchical' => 0,
		) );
		if ( $us_portfolio_categories_raw ) {
			foreach ( $us_portfolio_categories_raw as $portfolio_category_raw ) {
				if ( is_object( $portfolio_category_raw ) ) {
					$us_portfolio_categories[ $portfolio_category_raw->name ] = $portfolio_category_raw->slug;
				}
			}
		}
//		echo '<pre>';
//			var_dump($us_portfolio_categories);
//		echo '</pre>';
//		die('aaaaaaaa');

		vc_map( array(
			'base'     => 'cf_portfolio',
			'name'     => __( 'CF Portfolio Grid', 'us' ),
			'icon'     => 'icon-wpb-ui-separator-label',
			'category' => __( 'Content', 'js_composer' ),
			'weight'   => 250,
			'params'   => array(
				array(
					'param_name'       => 'columns',
					'heading'          => __( 'Columns', 'us' ),
					'type'             => 'dropdown',
					'value'            => array(
						'2' => '2',
						'3' => '3',
						'4' => '4',
						'5' => '5',
					),
					'std'              => 4,
					'admin_label'      => true,
					'edit_field_class' => 'vc_col-sm-6',
					'weight'           => 120,
				),
				array(
					'param_name'       => 'orderby',
					'heading'          => _x( 'Order', 'sequence of items', 'us' ),
					'type'             => 'dropdown',
					'value'            => array(
						__( 'By date (newer first)', 'us' ) => 'date',
						__( 'By date (older first)', 'us' ) => 'date_asc',
						__( 'Alphabetically', 'us' )        => 'alpha',
						__( 'Random', 'us' )                => 'rand',
					),
					'std'              => 'date',
					'edit_field_class' => 'vc_col-sm-6',
					'weight'           => 110,
				),
				array(
					'param_name'       => 'items',
					'heading'          => __( 'Items Quantity', 'us' ),
					'description'      => __( 'If left blank, will output all the items', 'us' ),
					'type'             => 'textfield',
					'std'              => '',
					'edit_field_class' => 'vc_col-sm-6',
					'weight'           => 100,
				),
				array(
					'param_name'       => 'pagination',
					'heading'          => __( 'Pagination', 'us' ),
					'type'             => 'dropdown',
					'value'            => array(
						__( 'No pagination', 'us' )      => 'none',
						__( 'Regular pagination', 'us' ) => 'regular',
						__( 'Load More Button', 'us' )   => 'ajax',
						__( 'Infinite Scroll', 'us' )    => 'infinite',
					),
					'std'              => 'none',
					'edit_field_class' => 'vc_col-sm-6',
					'weight'           => 90,
				),
				array(
					'param_name'       => 'ratio',
					'heading'          => __( 'Items Ratio', 'us' ),
					'type'             => 'dropdown',
					'value'            => array(
						__( '4:3 (landscape)', 'us' ) => '4x3',
						__( '3:2 (landscape)', 'us' ) => '3x2',
						__( '1:1 (square)', 'us' )    => '1x1',
						__( '2:3 (portrait)', 'us' )  => '2x3',
						__( '3:4 (portrait)', 'us' )  => '3x4',
						__( 'Initial', 'us' )         => 'initial',
					),
					'std'              => '3x4',
					'edit_field_class' => 'vc_col-sm-6',
					'weight'           => 80,
				),
				array(
					'param_name'       => 'meta',
					'heading'          => __( 'Items Meta', 'us' ),
					'type'             => 'dropdown',
					'value'            => array(
						__( 'Do not show', 'us' )           => '',
						__( 'Show Item date', 'us' )        => 'date',
						__( 'Show Item categories', 'us' )  => 'categories',
						__( 'Show Item description', 'us' ) => 'desc',
					),
					'std'              => '',
					'edit_field_class' => 'vc_col-sm-6',
					'weight'           => 70,
				),
				array(
					'param_name'       => 'with_indents',
					'type'             => 'checkbox',
					'value'            => array( __( 'Add indents between items', 'us' ) => true ),
					'std'              => true,
					'edit_field_class' => 'vc_col-sm-6',
					'weight'           => 50,
				),
				array(
					'param_name'       => 'style',
					'heading'          => __( 'Items Style', 'us' ),
					'type'             => 'dropdown',
					'value'            => array(
						sprintf( __( 'Style %d', 'us' ), 1 )  => 'style_1',
						sprintf( __( 'Style %d', 'us' ), 2 )  => 'style_2',
						sprintf( __( 'Style %d', 'us' ), 3 )  => 'style_3',
						sprintf( __( 'Style %d', 'us' ), 4 )  => 'style_4',
						sprintf( __( 'Style %d', 'us' ), 5 )  => 'style_5',
						sprintf( __( 'Style %d', 'us' ), 6 )  => 'style_6',
						sprintf( __( 'Style %d', 'us' ), 7 )  => 'style_7',
						sprintf( __( 'Style %d', 'us' ), 8 )  => 'style_8',
						sprintf( __( 'Style %d', 'us' ), 9 )  => 'style_9',
						sprintf( __( 'Style %d', 'us' ), 10 ) => 'style_10',
						sprintf( __( 'Style %d', 'us' ), 11 ) => 'style_11',
						sprintf( __( 'Style %d', 'us' ), 12 ) => 'style_12',
						sprintf( __( 'Style %d', 'us' ), 13 ) => 'style_13',
						sprintf( __( 'Style %d', 'us' ), 14 ) => 'style_14',
						sprintf( __( 'Style %d', 'us' ), 15 ) => 'style_15',
						sprintf( __( 'Style %d', 'us' ), 16 ) => 'style_16',
						sprintf( __( 'Style %d', 'us' ), 17 ) => 'style_17',
						sprintf( __( 'Style %d', 'us' ), 18 ) => 'style_18',
					),
					'std'              => 'style_16',
					'admin_label'      => true,
					'edit_field_class' => 'vc_col-sm-6',
					'group'            => __( 'Styling', 'us' ),
					'weight'           => 16,
				),
				array(
					'param_name'       => 'align',
					'heading'          => __( 'Items Text Alignment', 'us' ),
					'type'             => 'dropdown',
					'value'            => array(
						__( 'Left', 'us' )   => 'left',
						__( 'Center', 'us' ) => 'center',
						__( 'Right', 'us' )  => 'right',
					),
					'std'              => 'center',
					'edit_field_class' => 'vc_col-sm-6',
					'group'            => __( 'Styling', 'us' ),
					'weight'           => 15,
				),
				array(
					'param_name'       => 'title_size',
					'heading'          => __( 'Items Title Size', 'us' ),
					'description'      => sprintf( __( 'Examples: %s', 'us' ), '26px, 1.3em, 200%' ),
					'type'             => 'textfield',
					'std'              => '',
					'edit_field_class' => 'vc_col-sm-6',
					'group'            => __( 'Styling', 'us' ),
					'weight'           => 14,
				),
				array(
					'param_name'       => 'meta_size',
					'heading'          => __( 'Items Meta Size', 'us' ),
					'description'      => sprintf( __( 'Examples: %s', 'us' ), '26px, 1.3em, 200%' ),
					'type'             => 'textfield',
					'std'              => '',
					'edit_field_class' => 'vc_col-sm-6',
					'group'            => __( 'Styling', 'us' ),
					'weight'           => 13,
				),
				array(
					'param_name'       => 'bg_color',
					'heading'          => __( 'Items Background Color', 'us' ),
					'type'             => 'colorpicker',
					'std'              => '',
					'edit_field_class' => 'vc_col-sm-6',
					'group'            => __( 'Styling', 'us' ),
					'weight'           => 12,
				),
				array(
					'param_name'       => 'text_color',
					'heading'          => __( 'Items Text Color', 'us' ),
					'type'             => 'colorpicker',
					'std'              => '',
					'edit_field_class' => 'vc_col-sm-6',
					'group'            => __( 'Styling', 'us' ),
					'weight'           => 11,
				),
				array(
					'param_name' => 'filter',
					'type'       => 'checkbox',
					'value'      => array( __( 'Enable filtering by category', 'us' ) => 'category' ),
					'std'        => true,
					'group'      => __( 'Filtering', 'us' ),
					'weight'     => 9,
				),
				array(
					'param_name' => 'filter_style',
					'heading'    => __( 'Filter Bar Style', 'us' ),
					'type'       => 'dropdown',
					'value'      => array(
						sprintf( __( 'Style %d', 'us' ), 1 ) => 'style_1',
						sprintf( __( 'Style %d', 'us' ), 2 ) => 'style_2',
						sprintf( __( 'Style %d', 'us' ), 3 ) => 'style_3',
					),
					'std'        => 'style_2',
					'group'      => __( 'Filtering', 'us' ),
					'dependency' => array( 'element' => 'filter', 'not_empty' => true ),
					'weight'     => 8,
				),
			),

		) );

		vc_add_param( 'cf_portfolio', array(
			'param_name' => 'categories',
			'heading'    => __( 'Display Items of selected categories', 'us' ),
			'type'       => 'checkbox',
			'value'      => $us_portfolio_categories,
			'std'        => 'checked',
			'weight'     => 30,
		) );

		vc_add_param( 'cf_portfolio', array(
			'param_name'  => 'el_class',
			'heading'     => us_translate_with_external_domain( 'Extra class name', 'js_composer' ),
			'description' => us_translate_with_external_domain( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'js_composer' ),
			'type'        => 'textfield',
			'std'         => '',
			'group'       => __( 'Styling', 'us' ),
			'weight'      => 10,
		) );
	}

	/*
	Shortcode logic how it should be rendered
	*/
	public function renderMyBartag( $atts, $content = null ) {
		global $sitepress;

		extract( shortcode_atts( array(
			'categories'   => (isset($atts['categories'])?$atts['categories']:''),
			'style_name'   => (isset($atts['style'])?$atts['style']:''),
			'columns'      => (isset($atts['columns'])?$atts['columns']:''),
			'ratio'        => (isset($atts['ratio'])?$atts['ratio']:''),
			'metas'        => (isset($atts['meta'])?array( 'title', $atts['meta'] ):array( 'title', '' )),
			'align'        => (isset($atts['align'])?$atts['align']:''),
			'with_indents' => (isset($atts['with_indents'])?$atts['with_indents']:''),
			'pagination'   => (isset($atts['pagination'])?$atts['pagination']:''),
			'orderby'      => 'date',//'date','date_asc','alpha','rand'
			'perpage'      => (isset($atts['items'])?intval( $atts['items'] ):''),
			'title_size'   => (isset($atts['title_size'])?$atts['title_size']:''),
			'meta_size'    => (isset($atts['meta_size'])?$atts['meta_size']:''),
			'text_color'   => (isset($atts['text_color'])?$atts['text_color']:''),
			'bg_color'     => (isset($atts['bg_color'])?$atts['bg_color']:''),
			'el_class'     => (isset($atts['el_class'])?$atts['el_class']:''),
			'filter'       => (isset($atts['filter'])?$atts['filter']:''),
			'filter_style' => (isset($atts['filter_style'])?$atts['filter_style']:''),
		), $atts ) );

		$content = wpb_js_remove_wpautop( $content, true ); // fix unclosed/unwanted paragraph tags in $content

		$classes   = '';
		$inner_css = '';

		$is_widget = ( isset( $is_widget ) ) ? $is_widget : false;

		//if ( ! $is_widget ) {
			$style_name = isset( $style_name ) ? $style_name : 'style_17';
			$classes .= ' ' . 'style_17';
		//}

//		$title_size = isset( $title_size ) ? $title_size : null;
//		$meta_size  = isset( $meta_size ) ? $meta_size : null;
//		$text_color = isset( $text_color ) ? $text_color : null;
//		$bg_color   = isset( $bg_color ) ? $bg_color : null;

		$classes .= ' cols_' . 4;

		$align = isset( $align ) ? $align : 'left';
		$classes .= ' align_' . $align;

		$available_ratios = array( '3x2', '4x3', '1x1', '2x3', '3x4', 'initial' );
		$ratio            = ( isset( $ratio ) AND in_array( $ratio, $available_ratios ) ) ? $ratio : '3x4';
		$classes .= ' ratio_' . str_replace( ':', '-', $ratio );

		$available_metas = array( 'title', 'date', 'categories', 'desc' );
		$metas           = ( isset( $metas ) AND is_array( $metas ) ) ? array_intersect( $metas, $available_metas ) : array( 'title' );

		$with_indents = ( isset( $with_indents ) AND $with_indents );
		if ( $with_indents ) {
			$classes .= ' with_indents';
		}

		// Preparing query
		$query_args = array(
			'post_type'   => 'us_portfolio',
			'post_status' => 'publish',
		);


		// Show only items from the certain categories
		$categories = ( isset( $categories ) AND ! empty( $categories ) ) ? array_filter( explode( ',', $categories ) ) : array();


//switch ($sitepress->get_current_language()){
//	case 'pl':
//		$categories = array('mlynki-do-kawy','silosy','urzadzenia-typu-r','urzadzenia-typu-rv' ) ;
//		break;
//	case 'en':
//		$categories = array('coffee-grinder','de-stoner','model-r','model-rv' ) ;
//		break;
//	default:
//		break;
//}

//		$terms = get_terms( 'us_portfolio_category', array(
//			'hide_empty' => false,
//		) );
//
//		$slug = array();
//
//		foreach ($terms as $term){
//			$slug[] = $term->slug;
//
////			get_term_by('id', $term->term_id, 'us_portfolio_category');
////			echo '<pre> ';
////			var_dump($term);
////
//////			var_dump(icl_object_id ($aaa, 'us_portfolio_category', true, $sitepress->get_current_language()));
//////			var_dump(icl_object_id ($aaa, 'us_portfolio', true, $sitepress->get_current_language()));
//////			var_dump(icl_object_id ($aaa, 'us_category', true, $sitepress->get_current_language()));
//////			var_dump(icl_object_id ($aaa, 'portfolio_category', true, $sitepress->get_current_language()));
////			echo '</pre> ';
//
//
//		}
//
//		echo '<pre> ';
//		var_dump($categories);
//		echo '</pre> ';


		if ( ! empty( $categories ) ) {
			$query_args['us_portfolio_category'] = implode( ',', $categories );
		}




		// Setting items order
		$orderby_translate     = array(
			'date'     => 'date',
			'date_asc' => 'date',
			'alpha'    => 'title',
			'rand'     => 'rand',
		);
		$orderby_translate_sql = array(
			'date'     => '`post_date`',
			'date_asc' => '`post_date`',
			'alpha'    => '`post_title`',
			'rand'     => 'RAND()',
		);
		$order_translate       = array(
			'date'     => 'DESC',
			'date_asc' => 'ASC',
			'alpha'    => 'ASC',
			'rand'     => '',
		);
		$orderby               = ( isset( $orderby ) AND in_array( $orderby, array(
				'date',
				'date_asc',
				'alpha',
				'rand',
			) ) ) ? $orderby : 'date';
		$order                 = ( isset( $order ) AND $order == 'ASC' ) ? 'ASC' : 'DESC';
		if ( $orderby == 'rand' ) {
			$query_args['orderby'] = 'rand';
		} else/*if ( $atts['order_by'] == 'date' )*/ {
			$query_args['orderby'] = array(
				$orderby_translate[ $orderby ] => $order_translate[ $orderby ],
			);
		}

		// Posts per page
		$pagination     = isset( $pagination ) ? $pagination : 'none';
		$has_pagination = ( $pagination != 'none' );
		if ( $pagination == 'infinite' ) {
			$is_infinite = true;
			$pagination  = 'ajax';
		}
		$perpage = isset( $perpage ) ? intval( $perpage ) : 0;
		$page    = isset( $page ) ? max( 1, intval( $page ) ) : 1;
		if ( $perpage < 1 ) {
			$query_args['nopaging'] = true;
			$has_pagination         = false;
		} else {
			$query_args['posts_per_page'] = $perpage;
			$query_args['paged']          = $page;
		}
		$old_lang = $sitepress->get_current_language();
//		$sitepress->switch_lang('pl',true);

		// Grabbing all the categories with a single request
		global $wpdb;
		$wpdb_query = 'SELECT `terms`.`slug` AS `category_slug`, `terms`.`name` AS `category_name`, `term_relationships`.`object_id` ';
		$wpdb_query .= 'FROM `' . $wpdb->term_taxonomy . '` as `term_taxonomy`, `' . $wpdb->terms . '` as `terms`, `' . $wpdb->term_relationships . '` AS `term_relationships` ';
		if ( class_exists( 'SitePress' ) AND defined( 'ICL_LANGUAGE_CODE' ) AND ICL_LANGUAGE_CODE ) {
			$wpdb_query .= ', `' . $wpdb->prefix . 'icl_translations` AS `translations` ';
		}
		$wpdb_query .= 'WHERE `term_taxonomy`.`taxonomy` = \'us_portfolio_category\' AND `terms`.`term_id` = `term_taxonomy`.`term_id`';
		if ( class_exists( 'SitePress' ) AND defined( 'ICL_LANGUAGE_CODE' ) AND ICL_LANGUAGE_CODE ) {
			$wpdb_query .= ' AND `translations`.element_id = `term_relationships`.`object_id`  AND `translations`.`language_code` = \'' . $sitepress->get_current_language() . '\'';
		}
		if ( ! empty( $categories ) ) {
			$wpdb_query .= ' AND `terms`.`slug` IN (\'' . implode( '\',\'', array_map( 'esc_sql', $categories ) ) . '\')';
		}
		$wpdb_query .= ' AND `term_relationships`.`term_taxonomy_id` = `term_taxonomy`.`term_taxonomy_id`';

		$wpdb_query .= ' ORDER BY  `terms`.`term_order` ASC';

//		$sitepress->switch_lang($old_lang,true);

		// Categories slugs for all the portfolio items that may be shown by the element
		$items_categories = array();
		// Category names for all the slugs
		$categories_names = array();
		foreach ( $wpdb->get_results( $wpdb_query ) as $row ) {
			if ( ! isset( $items_categories[ $row->object_id ] ) ) {
				$items_categories[ $row->object_id ] = array();
			}
			$items_categories[ $row->object_id ][] = $row->category_slug;
			if ( ! isset( $categories_names[ $row->category_slug ] ) ) {
				$categories_names[ $row->category_slug ] = $row->category_name;
			}
		}



//		echo '<pre> ';
////		var_dump(icl_object_id (933, 'category', true, 'en'));
////		var_dump(icl_object_id (933, 'category', true, 'pl'));
////		var_dump(icl_object_id (933, 'us_portfolio_category', true, 'en'));
////		var_dump(icl_object_id (933, 'us_portfolio', true, 'en'));
////		var_dump(icl_object_id (933, 'portfolio_category', true, 'en'));
//		echo '</pre> ';
//
		if ( empty( $items_categories ) ) {
			if ( ! empty( $categories ) ) {
				// Nothing is found in the needed categories
				return;
			} else {
				// Very unlikely, but still: portfolio posts may be not attached to categories, so fetching them the other way
				// TODO Rewrite the whole algorithm in a more lean way
				us_open_wp_query_context();

				foreach (get_posts( array( 'post_type' => 'us_portfolio', 'numberposts' => - 1 ) )  as $post ) {
					$items_categories[ $post->ID ] = array();
				}
				us_close_wp_query_context();
			}
		}

		if ( $has_pagination AND count( $items_categories ) <= $perpage ) {
			$has_pagination = false;
		}

		// Obtaining tiles sizes for proper
		$tile_sizes = array();
		if ( count( array_keys( $items_categories ) ) > 0 ) {
			$items_ids = implode( ',', array_keys( $items_categories ) );
			// Grabbing information about non-standard tile sizes to show them properly from the very beginning
			$wpdb_query = 'SELECT `post_id`, `meta_value` FROM `' . $wpdb->postmeta . '` ';
			$wpdb_query .= 'WHERE `post_id` IN (' . $items_ids . ') AND `meta_key`=\'us_tile_size\' AND `meta_value` NOT IN (\'\', \'1x1\')';

			foreach ( $wpdb->get_results( $wpdb_query ) as $result ) {
				$tile_sizes[ $result->post_id ] = $result->meta_value;
			}
		}

		us_open_wp_query_context();
		global $wp_query;

		$query_args['suppress_filters']=1;

		$wp_query = new WP_Query( $query_args );
		if ( ! have_posts() ) {
			// TODO Move to a separate variable
			_e( 'No portfolio items were found.', 'us' );

			return;
		}

		$available_filter_styles = array( 'style_1', 'style_2', 'style_3' );
		$filter_style            = ( isset( $filter_style ) AND in_array( $filter_style, $available_filter_styles ) ) ? $filter_style : 'style_2';

		$filter_html = '';
		$filter      = isset( $filter ) ? $filter : 'none';
		if ( $filter == 'category' ) {
			// $categories_names already contains only the used categories
//			echo '<pre> ';
//			var_dump($categories_names);
//			echo '</pre>aaaa ';
//					    krsort( $categories_names );
//			echo '<pre> ';
//			var_dump($categories_names);
//			echo '</pre> ';
			if ( count( $categories_names ) > 1 ) {
				$classes .= ' with_filters';
				$filter_html .= '<div class="g-filters ' . $filter_style . '"><div class="g-filters-list">';
				//		$filter_html .= '<div class="g-filters-item active" data-category="*"><span>' . __( 'All', 'us' ) . '</span></div>';

				$active = ' active';
				foreach ( $categories_names as $category_slug => $category_name ) {
					$filter_html .= '<div class="g-filters-item ' . $active . '" data-category="' . $category_slug . '"><span>' . $category_name . '</span></div>';
					$active = '';
				}


				$filter_html .= '</div></div>';
			}
		}

		if ( ( ! $is_widget ) AND ( ! empty( $filter_html ) OR $has_pagination OR $ratio == 'initial' OR ! empty( $tile_sizes ) ) ) {
			// We'll need the isotope script for any of the above cases
			if ( us_get_option( 'ajax_load_js', false ) == false ) {
				wp_enqueue_script( 'us-isotope' );
			}
			//$classes .= ' position_isotope';
		}

		$el_class = isset( $el_class ) ? $el_class : '';
		if ( ! empty( $el_class ) ) {
			$classes .= ' ' . $el_class;
		}

		$classes = apply_filters( 'us_portfolio_listing_classes', $classes );
		ob_start();
		?>

		<div class="w-portfolio<?php echo $classes ?>"><?php echo $filter_html; ?>
		<div class="debug-div">
			<?php

		foreach ( $categories_names as $category_slug => $category_name ) {
			$terms[] = get_terms( array(
				'taxonomy' => 'us_portfolio_category',
				'hide_empty' => false,
				'slug'=>$category_slug,
			) )[0];
		}

//			$terms['rv'] = get_terms( array(
//				'taxonomy' => 'us_portfolio_category',
//				'hide_empty' => false,
//				'slug'=>'urzadzenia-typu-rv',
//			) )[0];
//			$terms['silosy'] = get_terms( array(
//				'taxonomy' => 'us_portfolio_category',
//				'hide_empty' => false,
//				'slug'=>'silosy',
//			) )[0];
//			$terms['mlynki'] = get_terms( array(
//				'taxonomy' => 'us_portfolio_category',
//				'hide_empty' => false,
//				'slug'=>'mlynki-do-kawy',
//			) )[0];
			foreach($terms as $term){
				echo '<div class="us_portfolio_category" style="display: none;" id="'.$term->slug.'">' .$term->description. '</div>';
			}

//			echo '<div class="us_portfolio_category" id="'.$terms['r']->slug.'">' .$terms['r']->description. '</div>';
//			echo '<div class="us_portfolio_category" style="display: none;" id="'.$terms['rv']->slug.'">' .$terms['rv']->description. '</div>';
//			echo '<div class="us_portfolio_category" style="display: none;" id="'.$terms['silosy']->slug.'">' .$terms['silosy']->description. '</div>';
//			echo '<div class="us_portfolio_category" style="display: none;" id="'.$terms['mlynki']->slug.'">' .$terms['mlynki']->description. '</div>';
		?>
		</div>
		<div class="w-portfolio-list"><?php

			// Preparing template settings for loop post template
			$template_vars = array(
				'metas'      => $metas,
				'ratio'      => $ratio,
				'is_widget'  => $is_widget,
				'columns'    => $columns,
				'title_size' => $title_size,
				'meta_size'  => $meta_size,
				'text_color' => $text_color,
				'bg_color'   => $bg_color,
			);
			// Start the loop.
			while ( have_posts() ) {
				the_post();

				//		    us_load_template( 'templates/portfolio/listing-post', $template_vars );
				us_load_template( 'templates/portfolio/listing-post_prod', $template_vars );
			}

			?></div>
		<div id="produkty-content" class="w-portfolio-content">
			<div class="w-separator type_default size_huge thick_1 style_solid color_border cont_none"><span class="w-separator-h"></span></div>
			<div class="w-blog layout_smallcircle cols_1 with_categories">
				<div class="w-blog-list">
					<div class="preloader" style="text-align: center; display: none;">
						<img src="<?php echo plugins_url( 'assets/preload.gif', __FILE__ ); ?>"/>
					</div>
					<article>

					</article>
				</div>
			</div>
		</div>
		</div><?php

		// Cleaning up
		us_close_wp_query_context();


		$output = ob_get_clean();

		return $output;
	}

	/*
	Load plugin css and javascript files which you may need on front end of your site
	*/
	public function loadCssAndJs() {
		wp_register_style( 'vc_extend_style', plugins_url( 'assets/vc_extend.css', __FILE__ ) );
		wp_enqueue_style( 'vc_extend_style' );

		// If you need any javascript files on front end, here is how you can load them.
		wp_enqueue_script( 'vc_extend_js', plugins_url( 'assets/vc_extend.js', __FILE__ ), array( 'jquery' ) );
	}

	/*
	Show notice if your plugin is activated but Visual Composer is not
	*/
	public function showVcVersionNotice() {
		$plugin_data = get_plugin_data( __FILE__ );
		echo '
        <div class="updated">
          <p>' . sprintf( __( '<strong>%s</strong> requires <strong><a href="http://bit.ly/vcomposer" target="_blank">Visual Composer</a></strong> plugin to be installed and activated on your site.', 'vc_extend' ), $plugin_data['Name'] ) . '</p>
        </div>';
	}

	public function create_product_post_types() {
		// Portfolio post type
		global $portfolio_slug;
		if ( $portfolio_slug == '' ) {
			$portfolio_rewrite = array( 'slug' => false, 'with_front' => false );
		} else {
			$portfolio_rewrite = array( 'slug' => untrailingslashit( $portfolio_slug ) );
		}
		register_post_type( 'us_portfolio', array(
			'labels'          => array(
				'name'          => __( 'Portfolio Items', 'us' ),
				'singular_name' => __( 'Portfolio Item', 'us' ),
				'add_new'       => __( 'Add Portfolio Item', 'us' ),
			),
			'public'          => true,
			'rewrite'         => $portfolio_rewrite,
			'supports'        => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'comments' ),
			'can_export'      => true,
			'capability_type' => 'us_portfolio',
			'map_meta_cap'    => true,
			'menu_icon'       => 'dashicons-images-alt',
		) );

		// Portfolio categories
		register_taxonomy( 'us_portfolio_category', array( 'us_portfolio' ), array(
			'hierarchical'   => true,
			'label'          => __( 'Portfolio Categories', 'us' ),
			'singular_label' => __( 'Portfolio Category', 'us' ),
			'rewrite'        => array( 'slug' => us_get_option( 'portfolio_category_slug', 'portfolio_category' ) ),
		) );

		// Portfolio slug may have changed, so we need to keep WP's rewrite rules fresh
		if ( get_transient( 'us_flush_rules' ) ) {
			flush_rewrite_rules();
			delete_transient( 'us_flush_rules' );
		}
	}
}

// Finally initialize code
new VCExtendAddonClass();