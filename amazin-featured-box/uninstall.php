<?php
// if uninstall.php is not called by WordPress, die
if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}

defined( 'ABSPATH' ) OR exit;

if ( ! current_user_can( 'activate_plugins' ) )
    return;

$option_names = array('amazin_product_box_option_headline', 'amazin_product_box_option_new_tab');
foreach ($option_names as $option_name) {
    delete_option($option_name);

    // for site options in Multisite
    delete_site_option($option_name);
}

// drop a custom database table
global $wpdb;
$wpdb->query("DELETE FROM {$wpdb->prefix}posts WHERE post_type='amazin_product_box'");
?>
