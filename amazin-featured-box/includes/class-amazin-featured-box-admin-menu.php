<?php
defined( 'ABSPATH' ) OR exit;

/**
 * Admin Menu
 */
class Amazin_Product_Box_Admin_Menu {

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
        add_menu_page( __( 'AmazinProductBox', 'apb' ), __( 'Amazin\' Product Box', 'apb' ), 'manage_options', 'amazinProductBox', array( $this, 'plugin_page' ), 'dashicons-grid-view', null );

        add_submenu_page( 'amazinProductBox', __( 'AmazinProductBox', 'apb' ), __( 'AmazinProductBox', 'apb' ), 'manage_options', 'amazinProductBox', array( $this, 'plugin_page' ) );

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

                $template = dirname( __FILE__ ) . '/views/product-box-single.php';
                break;

            case 'edit':
                $template = dirname( __FILE__ ) . '/views/product-box-edit.php';
                break;

            case 'new':
                $template = dirname( __FILE__ ) . '/views/product-box-new.php';
                break;

            default:
                $template = dirname( __FILE__ ) . '/views/product-box-list.php';
                break;
        }

        if ( file_exists( $template ) ) {
            include $template;
        }

    }
}
