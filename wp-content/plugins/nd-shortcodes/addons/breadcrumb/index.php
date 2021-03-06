<?php


$nd_options_breadcrumbs_enable = get_option('nd_options_breadcrumbs_enable');

//START enable
if ( $nd_options_breadcrumbs_enable == 1 ) {


  //nd learning plugin compatibility
  add_action('nd_learning_end_header_img_single_course_hook','nd_options_create_breadcrumbs');
  add_action('nd_learning_end_header_img_archive_courses_hook','nd_options_create_breadcrumbs');
  add_action('nd_learning_end_header_img_single_teacher_hook','nd_options_create_breadcrumbs');
  add_action('nd_learning_end_header_img_archive_teachers_hook','nd_options_create_breadcrumbs');


  add_action('nd_options_end_header_img_page_hook','nd_options_create_breadcrumbs');
  add_action('nd_options_end_header_img_post_hook','nd_options_create_breadcrumbs');
  add_action('nd_options_end_header_img_search_hook','nd_options_create_breadcrumbs');
  add_action('nd_options_end_header_img_archive_hook','nd_options_create_breadcrumbs');
  function nd_options_create_breadcrumbs() {
    
    

    //variables
    $nd_options_delimiter = '<img alt="" class="nd_options_margin_left_10 nd_options_margin_right_10" width="10" height="10" src="'.plugins_url().'/nd-shortcodes/addons/breadcrumb/img/icon-next-grey.svg">';
    $nd_options_home = __('Home', 'nd-shortcodes');
    $nd_options_before = '<span class="nd_learning_current_breadcrumb">';
    $nd_options_after = '</span>';
    


    if ( !is_home() && !is_front_page() || is_paged() ) {
      
      global $post;


      //START
      echo '

      <div id="nd_options_breadcrumbs" class="nd_options_section nd_options_bg_grey nd_options_border_bottom_1_solid_grey">

          <!--start nd_options_container-->
          <div class="nd_options_container nd_options_clearfix">

              <div class="nd_options_section nd_options_padding_15 nd_options_box_sizing_border_box">
    
    ';
    
      

      //Home
      $nd_options_home_link = home_url();
      echo '<a href="' . $nd_options_home_link . '">' . $nd_options_home . '</a> ' . $nd_options_delimiter . ' ';
    
      
      //Category
      if ( is_category() ) {
        global $wp_query;
        $cat_obj = $wp_query->get_queried_object();
        $thisCat = $cat_obj->term_id;
        $thisCat = get_category($thisCat);
        $parentCat = get_category($thisCat->parent);
        if ($thisCat->parent != 0) echo(get_category_parents($parentCat, TRUE, ' ' . $nd_options_delimiter . ' '));
        echo $nd_options_before . single_cat_title('', false) . $nd_options_after;
    
      } 

      //Day
      elseif ( is_day() ) {
        echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $nd_options_delimiter . ' ';
        echo '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $nd_options_delimiter . ' ';
        echo $nd_options_before . get_the_time('d') . $nd_options_after;
    
      } 


      //Month
      elseif ( is_month() ) {
        echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $nd_options_delimiter . ' ';
        echo $nd_options_before . get_the_time('F') . $nd_options_after;
    
      } 


      //Year
      elseif ( is_year() ) {
        echo $nd_options_before . get_the_time('Y') . $nd_options_after;
    
      } 


      //Post
      elseif ( is_single() && !is_attachment() ) {
        if ( get_post_type() != 'post' ) {
          $post_type = get_post_type_object(get_post_type());
          $slug = $post_type->rewrite;
          echo '<a href="' . $nd_options_home_link . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a> ' . $nd_options_delimiter . ' ';
          echo $nd_options_before . get_the_title() . $nd_options_after;
        } else {
          $cat = get_the_category(); $cat = $cat[0];
          echo get_category_parents($cat, TRUE, ' ' . $nd_options_delimiter . ' ');
          echo $nd_options_before . get_the_title() . $nd_options_after;
        }
    
      } 


      //post type
      elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
        
        if ( get_post_type() != '' ) { 

          $post_type = get_post_type_object(get_post_type());
          echo $nd_options_before . $post_type->labels->singular_name . $nd_options_after;

        }

      } 


      //Media
      elseif ( is_attachment() ) {
        $parent = get_post($post->post_parent);
        $cat = get_the_category($parent->ID); $cat = $cat[0];
        echo get_category_parents($cat, TRUE, ' ' . $nd_options_delimiter . ' ');
        echo '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a> ' . $nd_options_delimiter . ' ';
        echo $nd_options_before . get_the_title() . $nd_options_after;
    
      } 


      //
      elseif ( is_page() && !$post->post_parent ) {
        echo $nd_options_before . get_the_title() . $nd_options_after;
    
      } 


      //Page
      elseif ( is_page() && $post->post_parent ) {
        $parent_id  = $post->post_parent;
        $breadcrumbs = array();
        while ($parent_id) {
          $page = get_page($parent_id);
          $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
          $parent_id  = $page->post_parent;
        }
        $breadcrumbs = array_reverse($breadcrumbs);
        foreach ($breadcrumbs as $crumb) echo $crumb . ' ' . $nd_options_delimiter . ' ';
        echo $nd_options_before . get_the_title() . $nd_options_after;
    
      } 


      //Search
      elseif ( is_search() ) {
        echo $nd_options_before . get_search_query() . $nd_options_after;
    
      } 


      //Tag
      elseif ( is_tag() ) {
        echo $nd_options_before . single_tag_title('', false) . $nd_options_after;
    
      } 


      //author
      elseif ( is_author() ) {
         global $author;
        $userdata = get_userdata($author);
        echo $nd_options_before . $userdata->display_name . $nd_options_after;
    
      } 


      //404
      elseif ( is_404() ) {
        echo $nd_options_before . 'Error 404' . $nd_options_after;
      }
    
      
      //Pagination
      if ( get_query_var('paged') ) {
        if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' - ';
        echo esc_html__('Page', 'nd-shortcodes') . ' ' . get_query_var('paged');
        if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' ';
      }


    
      echo '
        </div>


        </div>
        <!--end container-->

    </div>
    ';
    //END

    
    }
  }


}
//END enable