<?php
/**
 * Plugin Name: Admin Column
 * Plugin URI: http://danielpataki.com
 * Description: This is a plugin that allows to customise the Admin column
 * Version: 1.0.0
 * Author: Youssef Jarid
 * Author URI: http://danielpataki.com
 * License: GPL2
 */


add_filter( 'manage_recipe_posts_columns', 'GS_recipe_columns' );
function GS_recipe_columns( $columns ) {
  $columns['views'] = __( 'Views', 'GS' );
 unset($columns['taxonomy-mood']);
  return $columns;
}

add_action( 'manage_recipe_posts_custom_column', 'GS_recipe_column', 10, 2);
function GS_recipe_column( $column, $post_id ) {
  // views column

  $t=date('d-m-Y');
  $year = date("Y",strtotime($t));

  if ( 'views' === $column ) {
    $num_views = get_post_meta($post_id, 'views_count_'.$year, true);
    echo $num_views;
  }
}

add_filter( 'manage_edit-recipe_sortable_columns', 'GS_recipe_sort_column' );
function GS_recipe_sort_column($columns) {

  $columns['views'] = 'views';
  $columns['author'] = 'author';
  return $columns;

}

add_action( 'pre_get_posts', 'my_views_orderby' );
function my_views_orderby( $query ) {
    if( ! is_admin() )
        return;

    $orderby = $query->get( 'orderby');


    if( 'views' == $orderby ) {
      $t=date('d-m-Y');
      $year = date("Y",strtotime($t));
      $test = 'views_count_'.$year;
        $query->set('meta_key',$test);
        $query->set('orderby','meta_value_num');
    }
}
