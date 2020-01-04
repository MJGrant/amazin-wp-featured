<?php
/**
 * Plugin Name: Amazin' Featured Article Box
 * Plugin URI: http://majoh.dev
 * Description: Embed a customizable "article preview" into your posts and pages.
 * Version: 1.0
 * Author: Mandi Grant
 * Author URI: http://majoh.dev
 * Example CSS: https://gist.github.com/MJGrant/2b88077fdb8de8c7c118939cfed99a52 
 */

defined( 'ABSPATH' ) OR exit;

add_action( 'init', function() {
    include dirname( __FILE__ ) . '/includes/class-amazin-featured-box-admin-menu.php';
    include dirname( __FILE__ ) . '/includes/class-amazin-featured-box-list-table.php';
    include dirname( __FILE__ ) . '/includes/class-amazin-featured-box-form-handler.php';
    include dirname( __FILE__ ) . '/includes/amazin-featured-box-functions.php';

    // WordPress image upload library
    wp_enqueue_media();
    $jsurl = plugin_dir_url(__FILE__) . 'admin.js';
    wp_enqueue_script('admin', $jsurl, array( 'jquery' ), 1.4, true);

    $cssurl = plugin_dir_url(__FILE__) . 'styles.css';
    wp_enqueue_style( 'amazin-featured-box-stylesheet', $cssurl, array(), 1.39 );

    register_post_type('amazin_featured_box',
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

    add_option( 'amazin_featured_box_option_label', 'Editor\'s Choice');
    add_option( 'amazin_featured_box_option_new_tab', false);
    add_option( 'amazin_featured_box_option_by_label', 'By');
    add_option( 'amazin_featured_box_option_display_post_date', true);
    add_option( 'amazin_featured_box_option_display_post_author', true);

    register_setting( 'amazin_featured_box_options_group', 'amazin_featured_box_option_label', 'amazin_featured_box_callback' );
    register_setting( 'amazin_featured_box_options_group', 'amazin_featured_box_option_new_tab', 'amazin_featured_box_callback' );
    register_setting( 'amazin_featured_box_options_group', 'amazin_featured_box_option_by_label', 'amazin_featured_box_callback' );
    register_setting( 'amazin_featured_box_options_group', 'amazin_featured_box_option_display_post_date', 'amazin_featured_box_callback' );
    register_setting( 'amazin_featured_box_options_group', 'amazin_featured_box_option_display_post_author', 'amazin_featured_box_callback' );

    add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'amazin_featured_add_plugin_action_links' );

    new Amazin_Featured_Box_Admin_Menu();
});

function amazin_featured_add_plugin_action_links( $links ) {
    $plugin_url = admin_url( 'admin.php?page=amazinFeaturedBox' );
    $links[] = '<a href="' . $plugin_url . '">' . __( 'Manage Featured Article Boxes', 'afb' ) . '</a>';
    return $links;
}

function amazin_featured_box_shortcode( $atts ) {
    $a = shortcode_atts( array(
        'id' => 'id'
        ), $atts );

    $featuredBox = get_post($a['id']);

    if ($featuredBox) {
        return amazin_featured_box_render_in_post($featuredBox);
    } else {
        return 'Error displaying Amazin Featured Box';
    }
}

function amazin_featured_box_render_in_post($featuredBox) {
    ob_start();
    $id = $featuredBox->ID;
    $featuredBoxTitle = $featuredBox->post_title;
    $item = afb_get_featured_box( $id );
    $newTab = get_option('amazin_featured_box_option_new_tab') ? 'target="_blank"' : '';
    $displayPostAuthor = get_option('amazin_featured_box_option_display_post_author');

    // content contains things like post ID, custom label and tagline, etc. 
    $content = json_decode($item->post_content, true);

    // If the user set a label, use that. Otherwise, use the universal label from options. 
    $featuredPostID = $content['featuredPostID'];
    $label = $content['customLabel'] ? $content['customLabel'] : get_option('amazin-featured_box_option_label');
    
    // if custom name is empty, use the post's title. Else, use the custom name. 
    $title = empty($content['customName']) ? get_the_title( $featuredPostID ) : $content['customName'];
    $featuredURL = $content['featuredURL']; 

    // Get the post's author and last updated date using the post ID saved to this feature box
    $authorID = get_the_author_meta( $featuredPostID );

    // Set to empty strings if the option to display them is not true
    $by = get_option( 'amazin_featured_box_option_by_label' ) ? get_option( 'amazin_featured_box_option_by_label' ) : '';
    $postAuthor = get_option( 'amazin_featured_box_option_display_post_author' ) ? get_the_author_meta( 'display_name', $authorID ) : '';

    $assembledAuthor = $by;
    $assembledAuthor .= " ";
    $assembledAuthor .= $postAuthor;

    // Set to empty string if the option to display the date is not true
    $postDate = get_option( 'amazin_featured_box_option_display_post_date' ) ? get_the_modified_time( 'F j, Y', $featuredPostID ) : '';

    $assembledDate = " | ";
    $assembledDate .= $postDate;

    // If featuredImage is empty, use post's featured image instead
    $imagePath = empty($content['featuredImage']) ?  wp_get_attachment_url( get_post_thumbnail_id($featuredPostID)) : wp_get_attachment_url( $content['featuredImage'] );

    ?>
        <div class="amazin-featured-box" id="<?php echo 'amazin-featured-box-id-'.$id; ?>">
            <div class="amazin-featured-box-text">
                <!-- label -->
                <h2 class="amazin-featured-box-label"><?php echo $label ?></h2>
                <!-- Post title or custom name -->
                <h3 class="amazin-featured-box-title"><a href="<?php echo $featuredURL ?>"><?php echo $title ?></a></h3>
                <!-- Tagline, if there is one -->
                <p class="amazin-featured-box-tagline"><?php echo $content['featuredTagline'] ?></p>
                <!-- Author name and last updated date, if options checked -->
                <p class="amazin-featured-box-author-and-date"><span><?php echo $assembledAuthor ?></span><span><?php echo $assembledDate ?></span></p>
            </div>

            <div class="amazin-featured-box-image">
                <!-- Featured or Custom Image -->
                <div class="amazin-featured-box-image-row">
                    <a href="<?php echo $featuredURL ?>"><img src="<?php echo $imagePath ?>"/></a>
                </div>
            </div>
            
        </div>
    <?php
    return ob_get_clean();
}

add_shortcode( 'amazin-featured-box', 'amazin_featured_box_shortcode' );

?>
