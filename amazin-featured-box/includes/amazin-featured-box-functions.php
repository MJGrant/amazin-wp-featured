<?php
defined( 'ABSPATH' ) OR exit;

/**
 * Get all featured boxes
 *
 * @param $args array
 *
 * @return array
 */
function afb_get_all_featured_boxes( $args = array() ) {
    global $wpdb;

    $defaults = array(
        'number'     => 20,
        'offset'     => 0,
        'orderby'    => 'ID',
        'order'      => 'ASC',
    );

    $args      = wp_parse_args( $args, $defaults );
    $cache_key = 'featuredbox-all';
    $items     = wp_cache_get( $cache_key, 'afb' );

    if ( false === $items ) {
        $items = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . 'posts WHERE `post_type`="amazin_featured_box" ORDER BY ' . $args['orderby'] .' ' . $args['order'] .' LIMIT ' . $args['offset'] . ', ' . $args['number'] );

        wp_cache_set( $cache_key, $items, 'afb' );
    }

    return $items;
}

/**
 * Fetch all featured box from database
 *
 * @return array
 */
function afb_get_featured_box_count() {
    global $wpdb;

    return (int) $wpdb->get_var( 'SELECT COUNT(*) FROM ' . $wpdb->prefix . 'posts WHERE `post_type`="amazin_featured_box"' );
}

/**
 * Fetch a single featured box from database
 *
 * @param int   $id
 *
 * @return array
 */
function afb_get_featured_box( $id ) {
    global $wpdb;

    return $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->prefix . 'posts WHERE id = %d', $id ) );
}

function afb_new_featured_box ( $featured_box) {
    wp_insert_post( $featured_box );
    return 1;
}

function afb_update_featured_box ( $featured_box) {
    wp_update_post ( $featured_box );
    return $featured_box->id;
}

function afb_delete_featured_boxes ( $ids ) {
    global $wpdb;

    $ids = implode( ',', array_map( 'absint', $ids ) );
    $delQuery = "DELETE FROM " . $wpdb->prefix . "posts WHERE id IN ($ids)";

    return $wpdb->query( $delQuery );
}
