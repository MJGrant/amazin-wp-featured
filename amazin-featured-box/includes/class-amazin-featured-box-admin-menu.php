<?php
defined( 'ABSPATH' ) OR exit;

/**
 * Admin Menu
 */
class Amazin_Featured_Box_Admin_Menu {

    /**
     * Kick-in the class
     */
    public function __construct() {
        add_action( 'admin_menu', array( $this, 'admin_menu' ) );
    }

    /**
     * Add menu items
     *
     * @return void
     */
    public function admin_menu() {

        /** Top Menu **/
        add_menu_page( __( 'AmazinFeaturedBox', 'afb' ), __( 'Amazin\' Featured Box', 'afb' ), 'manage_options', 'amazinFeaturedBox', array( $this, 'plugin_page' ), 'dashicons-grid-view', null );

        add_submenu_page( 'amazinFeaturedBox', __( 'AmazinFeaturedBox', 'afb' ), __( 'AmazinFeaturedBox', 'afb' ), 'manage_options', 'amazinFeaturedBox', array( $this, 'plugin_page' ) );

        wp_enqueue_media();
    }

    /**
     * Handles the plugin page
     *
     * @return void
     */
    public function plugin_page() {
        $action = isset( $_GET['action'] ) ? $_GET['action'] : 'list';
        $ID     = isset( $_GET['ID'] ) ? intval( $_GET['ID'] ) : 0;

        switch ($action) {
            case 'view':

                $template = dirname( __FILE__ ) . '/views/featured-box-single.php';
                break;

            case 'edit':
                $template = dirname( __FILE__ ) . '/views/featured-box-edit.php';
                break;

            case 'new':
                $template = dirname( __FILE__ ) . '/views/featured-box-new.php';
                break;

            default:
                $template = dirname( __FILE__ ) . '/views/featured-box-list.php';
                break;
        }

        if ( file_exists( $template ) ) {
            include $template;
        }

    }
}
