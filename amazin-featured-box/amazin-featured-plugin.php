<?php
/**
 * Plugin Name: Amazin' Featured Article Box
 * Plugin URI: http://majoh.dev
 * Description: Showcase your best pages andposts with this customizable "article preview"
 * Version: 1.0
 * Author: Mandi Grant
 * Author URI: http://majoh.dev
 */

defined( 'ABSPATH' ) OR exit;

add_action( 'init', function() {
    include dirname( __FILE__ ) . '/includes/class-amazin-featured-box-admin-menu.php';
    include dirname( __FILE__ ) . '/includes/class-amazin-featured-box-list-table.php';
    include dirname( __FILE__ ) . '/includes/class-form-handler.php';
    include dirname( __FILE__ ) . '/includes/amazin-featured-box-functions.php';

    // WordPress image upload library
    wp_enqueue_media();
    $jsurl = plugin_dir_url(__FILE__) . 'admin.js';
    wp_enqueue_script('admin', $jsurl, array( 'jquery' ), 1.1, true);

    $cssurl = plugin_dir_url(__FILE__) . 'styles.css';
    wp_enqueue_style( 'amazin-stylesheet', $cssurl, array(), 1.35 );

    register_post_type('amazin_product_box',
        array(
            'labels' => array(
                'name' => __( 'Amazin Featured Boxes' ),
                'singular_name' => __( ' Amazin Featured Box ')
            ),
            'public'            => false,
            'show_ui'           => false,
            'query_var'         => false,
            'rewrite'           => false,
            'capability_type'   => 'amazin_featured_box',
            'has_archive'       => true,
            'can_export'        => true,
        )
    );

    add_option( 'amazin_featured_box_option_headline', 'We recommend');
    add_option( 'amazin_featured_box_option_new_tab', false);
    register_setting( 'amazin_featured_box_options_group', 'amazin_featured_box_option_headline', 'amazin_featured_box_callback' );
    register_setting( 'amazin_featured_box_options_group', 'amazin_featured_box_option_new_tab', 'amazin_featured_box_callback' );

    add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'add_plugin_action_links' );

    new Amazin_Product_Box_Admin_Menu();
});

function add_plugin_action_links( $links ) {
    $plugin_url = admin_url( 'admin.php?page=amazinFeaturedBox' );
    $links[] = '<a href="' . $plugin_url . '">' . __( 'Manage Featured Boxes', 'apb' ) . '</a>';
    return $links;
}

function amazin_featured_box_shortcode( $atts ) {
    $a = shortcode_atts( array(
        'id' => 'id'
        ), $atts );

    $featuredBox = get_post($a['id']);

    if ($featuredBox) {
        return amazin_product_box_render_in_post($featuredBox);
    } else {
        return 'Error displaying Amazin Featured Box';
    }
}

function amazin_featured_box_render_in_post($featuredBox) {
    ob_start();
    $id = $productBox->ID;
    $featuredBoxTitle = $featuredBox->post_title;
    $item = apb_get_featured_box( 219 );
    //die($item);
    $content = json_decode($item->post_content, true);
    //$stripped = stripslashes($productBox->post_content);
    //$content = json_decode($stripped, true);
    $newTab = get_option('amazin_featured_box_option_new_tab') ? 'target="_blank"' : '';

    ?>
        <div class="amazin-featured-box" id="<?php echo 'amazin-featured-box-id-'.$id; ?>">
            <p class="amazin-featured-box-recommend-text"><?php echo get_option('amazin_featured_box_option_headline'); ?></p>
            <h3 class="amazin-featured-box-featured-name"><?php echo $productBoxTitle ?></h3>
            <div class="amazin-featured-box-image-row">
                <div class="amazin-featured-box-column amazin-featured-box-left">
                    <img src="<?php echo wp_get_attachment_url( $content['productImage'] ) ?>"/>
                </div>
                <div class="amazin-featured-box-column amazin-featured-box-right">
                    <p class="amazin-featured-box-tagline"><?php echo $content['productTagline'] ?></p>
                    <p class="amazin-featured-box-description" ><?php echo $content['productDescription'] ?></p>
                </div>
            </div>
            <div class="amazin-featured-box-button-wrap">
                <a href="<?php echo $content['productUrl'] ?>" class="amazin-featured-box-button" <?php echo $newTab ?> ><?php echo $content['productButtonText'] ?></a>
            </div>
        </div>
    <?php
    return ob_get_clean();
}

add_shortcode( 'amazin-featured-box', 'amazin_featured_box_shortcode' );

?>
