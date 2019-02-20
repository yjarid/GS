<?php
/*
 * Example setup for the custom Attached Posts field for CMB2.
 */

/**
 * Get the bootstrap! If using as a plugin, REMOVE THIS!
 */
require_once WPMU_PLUGIN_DIR . '/cmb2/init.php';
require_once WPMU_PLUGIN_DIR . '/cmb2-attached-posts/cmb2-attached-posts-field.php';

/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */
function cmb2_attached_posts_field_metaboxes_example() {



}
add_action( 'cmb2_admin_init', 'cmb2_attached_posts_field_metaboxes_example' );


