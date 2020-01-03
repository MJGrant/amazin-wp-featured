<?php
defined( 'ABSPATH' ) OR exit;

/**
 * Get all product boxes
 *
 * @param $args array
 *
 * @return array
 */
function apb_get_all_product_boxes( $args = array() ) {
    global $wpdb;

    $defaults = array(
        'number'     => 20,
        'offset'     => 0,
        'orderby'    => 'ID',
        'order'      => 'ASC',
    );

    $args      = wp_parse_args( $args, $defaults );
    $cache_key = 'productbox-all';
    $items     = wp_cache_get( $cache_key, 'apb' );

    if ( false === $items ) {
        $items = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . 'posts WHERE `post_type`="amazin_product_box" ORDER BY ' . $args['orderby'] .' ' . $args['order'] .' LIMIT ' . $args['offset'] . ', ' . $args['number'] );

        wp_cache_set( $cache_key, $items, 'apb' );
    }

    return $items;
}

/**
 * Fetch all product box from database
 *
 * @return array
 */
function apb_get_product_box_count() {
    global $wpdb;

    return (int) $wpdb->get_var( 'SELECT COUNT(*) FROM ' . $wpdb->prefix . 'posts WHERE `post_type`="amazin_product_box"' );
}

/**
 * Fetch a single product box from database
 *
 * @param int   $id
 *
 * @return array
 */
function apb_get_product_box( $id ) {
    global $wpdb;

    return $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->prefix . 'posts WHERE id = %d', $id ) );
}

function apb_new_product_box ( $product_box) {
    wp_insert_post( $product_box );
    return 1;
}

function apb_update_product_box ( $product_box) {
    wp_update_post ( $product_box );
    return $product_box->id;
}

function apb_delete_product_boxes ( $ids ) {
    global $wpdb;

    $ids = implode( ',', array_map( 'absint', $ids ) );
    $delQuery = "DELETE FROM " . $wpdb->prefix . "posts WHERE id IN ($ids)";

    return $wpdb->query( $delQuery );
}
